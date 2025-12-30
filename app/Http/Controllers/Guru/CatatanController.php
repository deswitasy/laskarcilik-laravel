<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatatanPerkembangan;
use App\Models\DetailCatatan;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;

class CatatanController extends Controller
{
    // Daftar catatan

    public function index(Request $request)
    {
        $query = CatatanPerkembangan::with(['siswa.kelas', 'user'])
            ->where('id_user', Auth::id());

        // Filter search
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_catat', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Pakai paginate() untuk dashboard
        $catatan = $query->orderBy('tanggal_catat', 'desc')->paginate(10);

        // Data untuk grafik
        $totalCatatan = CatatanPerkembangan::where('id_user', Auth::id())->count();
        $totalSiswaAktif = Siswa::where('status_siswa', 'aktif')->count();
        $catatanBulanIni = CatatanPerkembangan::where('id_user', Auth::id())
            ->whereMonth('tanggal_catat', now()->month)
            ->count();

        return view('guru.dashboard', compact('catatan', 'totalCatatan', 'totalSiswaAktif', 'catatanBulanIni'));
    }

    // Daftar siswa (read only untuk guru)
    public function daftarSiswa(Request $request)
    {
        $query = Siswa::with('kelas')->where('status_siswa', 'aktif');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }

        $siswa = $query->orderBy('nama_siswa')->paginate(10);

        return view('guru.siswa.index', compact('siswa'));
    }

    // Detail siswa untuk guru
    public function detailSiswa($id)
    {
        $siswa = Siswa::with(['kelas', 'catatanPerkembangan' => function ($q) {
            $q->where('id_user', Auth::id());
        }])->findOrFail($id);

        return view('guru.siswa.show', compact('siswa'));
    }

    // Form tambah catatan
    public function create()
    {
        $siswa = Siswa::where('status_siswa', 'aktif')
            ->with('kelas')
            ->orderBy('nama_siswa')
            ->get();

        $kategori = Kategori::all();

        return view('guru.catatan.create', compact('siswa', 'kategori'));
    }

    // Simpan catatan
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'semester' => 'required|integer|min:1|max:2',
            'tahun_ajaran' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',



            // VALIDASI DESKRIPSI
            'deskripsi_agama' => 'required|string',
            'deskripsi_jatidiri' => 'required|string',
            'deskripsi_stem' => 'required|string',
            'deskripsi_pancasila' => 'required|string',
        ], [
            // Custom error messages
            'deskripsi_agama.required' => 'Isi deskripsi Nilai Agama dan Budi Pekerti terlebih dahulu',
            'deskripsi_jatidiri.required' => 'Isi deskripsi Nilai Jati Diri terlebih dahulu',
            'deskripsi_stem.required' => 'Isi deskripsi Nilai STEM terlebih dahulu',
            'deskripsi_pancasila.required' => 'Isi deskripsi Nilai Pancasila terlebih dahulu',


        ]);

        try {
            DB::beginTransaction();

            $catatan = CatatanPerkembangan::create([
                'id_user' => Auth::id(),
                'id_siswa' => $request->id_siswa,
                'tanggal_catat' => Carbon::now(),
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran
            ]);

            // Simpan detail per kategori
            $kategori = Kategori::all();

            foreach ($kategori as $kat) {
                $fieldName = $this->getFieldName($kat->nama_kategori);

                if ($request->has('deskripsi_' . $fieldName)) {
                    DetailCatatan::create([
                        'id_catatan' => $catatan->id_catatan,
                        'id_kategori' => $kat->id_kategori,
                        'deskripsi' => $request->input('deskripsi_' . $fieldName)
                    ]);
                }
            }



            // Simpan foto jika ada
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filepath = $file->storeAs('catatan/' . $catatan->id_catatan, $filename, 'public');

                    Foto::create([
                        'id_catatan' => $catatan->id_catatan,
                        'file_path' => $filepath,
                        'keterangan' => $request->input('keterangan_foto') ?? null
                    ]);
                }
            }


            // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('catatan/' . $catatan->id_catatan, $filename, 'public');

                Foto::create([
                    'id_catatan' => $catatan->id_catatan,
                    'file_path' => $filepath,
                    'keterangan' => $request->input('keterangan_foto') ?? null
                ]);
            }
        }



            DB::commit();

            return redirect()->route('guru.catatan.index')
                ->with('success', 'Catatan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Detail catatan
    public function show($id)
    {
        $catatan = CatatanPerkembangan::with([
            'siswa.kelas',
            'user',
            'detailCatatan.kategori',
            'foto'
        ])->where('id_user', Auth::id())
            ->findOrFail($id);

        return view('guru.catatan.show', compact('catatan'));
    }

    // Form edit
    public function edit($id)
    {
        $catatan = CatatanPerkembangan::with([



            'detailCatatan.kategori',
            'foto'
        ])->where('id_user', Auth::id())
            ->findOrFail($id);


        'detailCatatan.kategori',
        'foto'
    ])->where('id_user', Auth::id())
        ->findOrFail($id);



        $siswa = Siswa::where('status_siswa', 'aktif')
            ->with('kelas')
            ->orderBy('nama_siswa')
            ->get();

        $kategori = Kategori::all();

        return view('guru.catatan.edit', compact('catatan', 'siswa', 'kategori'));
    }

    // Update catatan
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'semester' => 'required|integer|min:1|max:2',
            'tahun_ajaran' => 'required|string',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // VALIDASI DESKRIPSI
            'deskripsi_agama' => 'required|string',
            'deskripsi_jatidiri' => 'required|string',
            'deskripsi_stem' => 'required|string',
            'deskripsi_pancasila' => 'required|string',
        ], [
            // Custom error messages
            'deskripsi_agama.required' => 'Isi deskripsi Nilai Agama dan Budi Pekerti terlebih dahulu',
            'deskripsi_jatidiri.required' => 'Isi deskripsi Nilai Jati Diri terlebih dahulu',
            'deskripsi_stem.required' => 'Isi deskripsi Nilai STEM terlebih dahulu',
            'deskripsi_pancasila.required' => 'Isi deskripsi Nilai Pancasila terlebih dahulu',

        ]);

        try {
            DB::beginTransaction();

            $catatan = CatatanPerkembangan::where('id_user', Auth::id())
                ->findOrFail($id);

            $catatan->update([
                'id_siswa' => $request->id_siswa,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran
            ]);

            // Hapus detail lama
            DetailCatatan::where('id_catatan', $id)->delete();

            // Simpan detail baru
            $kategori = Kategori::all();

            foreach ($kategori as $kat) {
                $fieldName = $this->getFieldName($kat->nama_kategori);

                if ($request->has('deskripsi_' . $fieldName)) {
                    DetailCatatan::create([
                        'id_catatan' => $catatan->id_catatan,
                        'id_kategori' => $kat->id_kategori,
                        'deskripsi' => $request->input('deskripsi_' . $fieldName)
                    ]);
                }
            }

            
            // Hapus foto yang dipilih
            if ($request->has('hapus_foto')) {
                foreach ($request->input('hapus_foto') as $id_foto) {
                    $foto = Foto::findOrFail($id_foto);
                    Storage::disk('public')->delete($foto->file_path);
                    $foto->delete();
                }
            }
            
            // Simpan foto baru
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filepath = $file->storeAs('catatan/' . $catatan->id_catatan, $filename, 'public');

                    Foto::create([
                        'id_catatan' => $catatan->id_catatan,
                        'file_path' => $filepath,
                        'keterangan' => $request->input('keterangan_foto') ?? null
                    ]);
                }
            }


            if ($request->has('hapus_foto')) {
            foreach ($request->input('hapus_foto') as $id_foto) {
                $foto = Foto::findOrFail($id_foto);
                Storage::disk('public')->delete($foto->file_path);
                $foto->delete();
            }
        }
         // Simpan foto baru
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filepath = $file->storeAs('catatan/' . $catatan->id_catatan, $filename, 'public');

                Foto::create([
                    'id_catatan' => $catatan->id_catatan,
                    'file_path' => $filepath,
                    'keterangan' => $request->input('keterangan_foto') ?? null
                ]);
            }
        }


            DB::commit();

            return redirect()->route('guru.catatan.index')
                ->with('success', 'Catatan berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Hapus catatan
    public function destroy($id)
    {
        try {
            $catatan = CatatanPerkembangan::where('id_user', Auth::id())
                ->findOrFail($id);
            $catatan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Catatan berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cetak PDF
    public function cetakPDF($id)
    {
        $catatan = CatatanPerkembangan::with([
            'siswa.kelas',
            'user',
            'detailCatatan.kategori'
        ])->where('id_user', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView('guru.catatan.pdf', compact('catatan'));

        $filename = 'Laporan_' . $catatan->siswa->nama_siswa . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    // Helper function
    private function getFieldName($kategoriName)
    {
        $mapping = [
            'Nilai Agama dan Budi Pekerti' => 'agama',
            'Nilai Jati Diri' => 'jatidiri',
            'Nilai STEM' => 'stem',
            'Nilai Pancasila' => 'pancasila'
        ];

        return $mapping[$kategoriName] ?? strtolower(str_replace(' ', '_', $kategoriName));
    }

    
    // Index Catatan untuk halaman /guru/catatan
    public function indexCatatan(Request $request)
    {
        $query = CatatanPerkembangan::with(['siswa.kelas', 'user'])
            ->where('id_user', Auth::id());

        // Search nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_catat', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $catatan = $query
            ->orderBy('tanggal_catat', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('guru.catatan.index', compact('catatan'));
    }

}

}

    // Index Catatan untuk halaman /guru/catatan
public function indexCatatan(Request $request)
{
    $query = CatatanPerkembangan::with(['siswa.kelas', 'user'])
        ->where('id_user', Auth::id());

    // Search nama siswa
    if ($request->filled('search')) {
        $query->whereHas('siswa', function ($q) use ($request) {
            $q->where('nama_siswa', 'like', '%' . $request->search . '%');
        });
    }

    // Filter tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal_catat', [
            $request->start_date,
            $request->end_date
        ]);
    }

    $catatan = $query
        ->orderBy('tanggal_catat', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('guru.catatan.index', compact('catatan'));
}

}



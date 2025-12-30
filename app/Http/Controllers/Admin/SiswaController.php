<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    // Tampilkan daftar siswa
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }

        // Filter kelas
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('id_kelas', $request->kelas);
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_siswa', $request->status);
        }

        $siswa = $query->orderBy('nama_siswa')->paginate(10);
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    // Form tambah siswa
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    // Simpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'nama_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
        ]);

        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')
                        ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // Detail siswa
    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'catatanPerkembangan.detailCatatan.kategori'])
                     ->findOrFail($id);

        return view('admin.siswa.show', compact('siswa'));
    }

    // Form edit siswa
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    // Update siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'nama_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'status_siswa' => 'required|in:aktif,lulus,pindah,keluar'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')
                        ->with('success', 'Data siswa berhasil diupdate!');
    }

    // Hapus siswa
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}

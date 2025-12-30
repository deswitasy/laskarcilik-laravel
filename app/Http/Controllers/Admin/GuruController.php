<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Tampilkan daftar guru
    public function index(Request $request)
    {
        $query = User::where('hak_akses', 'guru');

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_user', 'like', '%' . $request->search . '%')
                  ->orWhere('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $guru = $query->orderBy('nama_user')->paginate(10);

        return view('admin.guru.index', compact('guru'));
    }

    // Form tambah guru
    public function create()
    {
        return view('admin.guru.create');
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'no_hp' => 'nullable|digits_between:11,15',
        ], [
            'nama_user.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'no_hp.digits_between' => 'Nomor HP minimal 11 angka dan hanya boleh angka',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'hak_akses' => 'guru',
            'status' => 'aktif'
        ]);

        return redirect()->route('admin.guru.index')
                        ->with('success', 'Akun guru berhasil ditambahkan!');
    }

    // Detail guru
    public function show($id)
    {
        $guru = User::where('hak_akses', 'guru')->findOrFail($id);
        
        // Hitung jumlah catatan yang dibuat guru ini
        $totalCatatan = $guru->catatanPerkembangan()->count();
        $catatanBulanIni = $guru->catatanPerkembangan()
                                ->whereMonth('tanggal_catat', now()->month)
                                ->count();

        return view('admin.guru.show', compact('guru', 'totalCatatan', 'catatanBulanIni'));
    }

    // Form edit guru
    public function edit($id)
    {
        $guru = User::where('hak_akses', 'guru')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    // Update guru
    public function update(Request $request, $id)
    {
        $guru = User::where('hak_akses', 'guru')->findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',id_user',
            'email' => 'required|email|max:100|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:6|confirmed',
            'no_hp' => 'nullable|digits_between:11,15',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $data = [
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status' => $request->status
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')
                        ->with('success', 'Akun guru berhasil diupdate!');
    }

    // Hapus guru
    public function destroy($id)
    {
        try {
            $guru = User::where('hak_akses', 'guru')->findOrFail($id);
 
            if ($guru->catatanPerkembangan()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus guru yang sudah membuat catatan!'
                ], 400);
            }

            $guru->delete();

            return response()->json([
                'success' => true,
                'message' => 'Akun guru berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
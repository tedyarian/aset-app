<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <-- TAMBAHKAN INI DI SINI


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil daftar pengguna untuk menu Manajemen Pengguna (Users & Roles)
        $users = User::all();
        return view('asset::settings.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asset::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
            'modules' => 'nullable|array',
        ]);

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'modules' => $request->modules ?? [], // Simpan array checkbox modul
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('asset::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $users = \App\Models\User::all();
        
        // Kita bisa mengirim kembali ke index dengan membawa data user yang akan diedit
        return view('asset::settings.index', compact('users', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'modules' => 'nullable|array',
        ]);

       $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'modules' => $request->modules ?? [],
    ];

    // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Pengguna berhasil diperbarui.');
        }

    // Menghapus pengguna
    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return redirect()->route('settings.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cek apakah user yang mau dihapus adalah admin utama / email tertentu
        if ($user->email === 'tedy@gmail.com' || $user->role === 'Super Admin') {
            return redirect()->back()->with('error', 'Akun Administrator utama tidak dapat dihapus!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}

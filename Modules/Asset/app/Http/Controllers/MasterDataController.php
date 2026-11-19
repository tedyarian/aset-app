<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Asset\Models\Department;
use Modules\Asset\Models\Location;
use Modules\Asset\Models\Room;
use Modules\Asset\Models\InstitutionKop;

class MasterDataController extends Controller
{
    /**
     * Halaman Daftar Departemen / Divisi
     */
    public function departmentIndex()
    {
        $departments = Department::all();
        return view('asset::master.departments-index', compact('departments'));
    
    }

    // Menyimpan Departemen Baru
    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Department::create($validated);

        return redirect()->route('master.department.index')->with('success', 'Departemen berhasil ditambahkan!');  
    }

    // Hapus Departemen
    public function destroyDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return redirect()->route('master.department.index')->with('success', 'Departemen berhasil dihapus!');
    }


    /**
     * Halaman Daftar Lokasi Penyimpanan Aset
     */
    public function locationIndex()
    {
        $locations = Location::all();
        return view('asset::master.locations-index', compact('locations'));
    }

    // Menyimpan Lokasi Baru
    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Location::create($validated);

        return redirect()->route('master.location.index')->with('success', 'Lokasi berhasil ditambahkan!');
    }

    // Hapus Lokasi
    public function destroyLocation($id)
    {
        Location::findOrFail($id)->delete();
        return redirect()->route('master.location.index')->with('success', 'Lokasi berhasil dihapus!');
    }


    /**
     * Halaman Daftar Ruangan & Detail Penandatangan
     */
    public function roomIndex()
    {
        $rooms = Room::all();
        return view('asset::master.rooms-index', compact('rooms'));
    }

    // Menyimpan Ruangan Baru (Lengkap dengan Detail Penandatangan)
    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'sign_tempat'    => 'nullable|string|max:255', // Digunakan untuk Tempat Penandatanganan
            'sign_date'      => 'nullable|date',          // Tanggal Penandatanganan
            'pic_jabatan'    => 'nullable|string|max:255',
            'pic_name'       => 'nullable|string|max:255',
            'pic_nip'        => 'nullable|string|max:255',
            'leader_jabatan' => 'nullable|string|max:255',
            'leader_name'    => 'nullable|string|max:255',
            'leader_nip'     => 'nullable|string|max:255',
        ]);

        Room::create($validated);

        return redirect()->route('master.room.index')->with('success', 'Ruangan beserta detail penandatangan berhasil ditambahkan!');
    }

     /**
     * Halaman Daftar Status Barang
     */
    public function statusBarangIndex()
    {
        $statusBarang = \Modules\Asset\Models\StatusBarang::latest()->get();
        return view('asset::master.status-index', compact('statusBarang'));
    }

    // Menyimpan Ruangan Baru (Lengkap dengan Detail Penandatangan)
    public function storeStatusBarang(Request $request)
    {
        $request->validate([
            'kondisi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        \Modules\Asset\Models\StatusBarang::create($request->all());

        return redirect()->route('master.status-barang.index')->with('success', 'Status barang berhasil ditambahkan!');   
    }

    public function destroyStatusBarang($id)
    {
        \Modules\Asset\Models\StatusBarang::findOrFail($id)->delete();
        return redirect()->route('master.status-barang.index')->with('success', 'Status barang berhasil dihapus!');
    }

    // Hapus Ruangan
    public function destroyRoom($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('master.room.index')->with('success', 'Ruangan berhasil dihapus!');
    }

    // --- SUMBER DANA ---
    public function sumberDanaIndex()
    {
        $sumberDana = \Modules\Asset\Models\SumberDana::latest()->get();
        return view('asset::master.sumber_dana-index', compact('sumberDana'));
    }

    public function storeSumberDana(Request $request)
    {
        $request->validate([
            'nama_sumber_dana' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        \Modules\Asset\Models\SumberDana::create($request->all());

        return redirect()->route('master.sumber-dana.index')->with('success', 'Sumber dana berhasil ditambahkan!');
    }

    public function destroySumberDana($id)
    {
        \Modules\Asset\Models\SumberDana::findOrFail($id)->delete();
        return redirect()->route('master.sumber-dana.index')->with('success', 'Sumber dana berhasil dihapus!');
    }


    /**
     * Halaman Master Template KOP Surat
     */
    public function kopIndex()
    {
        $kop = InstitutionKop::first();
        return view('asset::master.kop-index', compact('kop'));
    }

    // Update Master Template KOP Surat
    public function updateKop(Request $request)
    {
        $kop = InstitutionKop::first() ?? new InstitutionKop();

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'font_family' => 'nullable|string',
            'line_1' => 'nullable|string',
            'line_2' => 'nullable|string',
            'line_3' => 'nullable|string',
            'line_4' => 'nullable|string',
            'line_5' => 'nullable|string',
            'size_1' => 'nullable|string',
            'size_2' => 'nullable|string',
            'size_3' => 'nullable|string',
            'size_4' => 'nullable|string',
            'size_5' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $kop->logo = $path;
        }

        $kop->font_family = $request->font_family;
        $kop->line_1 = $request->line_1;
        $kop->line_2 = $request->line_2;
        $kop->line_3 = $request->line_3;
        $kop->line_4 = $request->line_4;
        $kop->line_5 = $request->line_5;
        $kop->size_1 = $request->size_1;
        $kop->size_2 = $request->size_2;
        $kop->size_3 = $request->size_3;
        $kop->size_4 = $request->size_4;
        $kop->size_5 = $request->size_5;
        
        $kop->save();

        return redirect()->route('master.kop.index')->with('success', 'Template KOP Surat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
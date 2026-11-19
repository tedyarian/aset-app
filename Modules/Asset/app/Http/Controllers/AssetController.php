<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Asset\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        // Perbaikan: Inisialisasi properti agar tidak bernilai null
        $this->assetService = $assetService;
    }

    public function index()
    {
        $data = $this->assetService->getDashboardData();

        // Mengembalikan tampilan dashboard sesuai acuan UI
        return view('asset::index', $data);
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
    public function store(Request $request) {}

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
    public function edit($id)
    {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
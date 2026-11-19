<?php

use Illuminate\Support\Facades\Route;
use Modules\Asset\Http\Controllers\AssetController;
use Modules\Asset\Http\Controllers\SettingController;
use Modules\Asset\Http\Controllers\AuthController;
use Modules\Asset\Http\Controllers\MasterDataController;
use Modules\Asset\Http\Controllers\AssetInventoryController;
use Modules\Asset\Http\Controllers\AssetTransactionController;
use Modules\Asset\Http\Controllers\AssetAuditController;
use Modules\Asset\Http\Controllers\AssetReportController;
use Modules\Asset\Http\Controllers\InstitutionKopController;

// Rute Login (Guest)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rute Utama yang Membutuhkan Autentikasi
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama (Bisa diakses semua user terautentikasi atau diberi modul 'dashboard')
    Route::get('/', [AssetController::class, 'index'])->name('dashboard');

    // Rute Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==========================================
    // 1. Modul Pengaturan & Users (module:settings)
    // ==========================================
    Route::middleware(['module:settings'])->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/users', [SettingController::class, 'storeUser'])->name('settings.users.store');
        Route::get('/settings/users/{id}/edit', [SettingController::class, 'editUser'])->name('settings.users.edit');
        Route::put('/settings/users/{id}', [SettingController::class, 'updateUser'])->name('settings.users.update');
        Route::delete('/settings/users/{id}', [SettingController::class, 'deleteUser'])->name('settings.users.destroy');
    });

    // ==========================================
    // 2. Modul Master Data (module:master / settings)
    // ==========================================
    Route::middleware(['module:settings'])->prefix('master')->name('master.')->group(function () {
        // Departemen
        Route::get('/departments', [MasterDataController::class, 'departmentIndex'])->name('department.index');
        Route::post('/departments', [MasterDataController::class, 'storeDepartment'])->name('department.store');
        Route::delete('/departments/{id}', [MasterDataController::class, 'destroyDepartment'])->name('department.delete');

        // Lokasi
        Route::get('/locations', [MasterDataController::class, 'locationIndex'])->name('location.index');
        Route::post('/locations', [MasterDataController::class, 'storeLocation'])->name('location.store');
        Route::delete('/locations/{id}', [MasterDataController::class, 'destroyLocation'])->name('location.delete');

        // Ruangan
        Route::get('/rooms', [MasterDataController::class, 'roomIndex'])->name('room.index');
        Route::post('/rooms', [MasterDataController::class, 'storeRoom'])->name('room.store');
        Route::delete('/rooms/{id}', [MasterDataController::class, 'destroyRoom'])->name('room.delete');

        // Status Barang
        Route::get('/status-barang', [MasterDataController::class, 'statusBarangIndex'])->name('status-barang.index');
        Route::post('/status-barang', [MasterDataController::class, 'storeStatusBarang'])->name('status-barang.store');
        Route::delete('/status-barang/{id}', [MasterDataController::class, 'destroyStatusBarang'])->name('status-barang.delete');

        // Sumber Dana
        Route::get('/sumber-dana', [MasterDataController::class, 'sumberDanaIndex'])->name('sumber-dana.index');
        Route::post('/sumber-dana', [MasterDataController::class, 'storeSumberDana'])->name('sumber-dana.store');
        Route::delete('/sumber-dana/{id}', [MasterDataController::class, 'destroySumberDana'])->name('sumber-dana.delete');

        // KOP Institusi
        Route::get('/kop', [MasterDataController::class, 'kopIndex'])->name('kop.index');
        Route::put('/kop', [MasterDataController::class, 'updateKop'])->name('kop.update');
    });

    // ==========================================
    // 3. Modul Data Aset / Inventaris (module:assets)
    // ==========================================
    Route::middleware(['module:assets'])->group(function () {
        Route::get('/inventory', [AssetInventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/create', [AssetInventoryController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [AssetInventoryController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{id}', [AssetInventoryController::class, 'show'])->name('inventory.show');
        Route::get('/inventory/{id}/edit', [AssetInventoryController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{id}', [AssetInventoryController::class, 'update'])->name('inventory.update');
        Route::get('/inventory/{id}/barcode', [AssetInventoryController::class, 'barcode'])->name('inventory.barcode');
        Route::delete('/inventory/{id}', [AssetInventoryController::class, 'destroy'])->name('inventory.destroy');
        Route::get('/bmn-items/search', [AssetInventoryController::class, 'searchBmnItems'])->name('inventory.bmn-search');
    });

    // ==========================================
    // 4. Modul Transaksi / Operasional (module:transactions)
    // ==========================================
    Route::middleware(['module:transactions'])->prefix('transactions')->name('transactions.')->group(function () {
        // Index Utama Transaksi & Operasional
        Route::get('/', [AssetTransactionController::class, 'index'])->name('index');

        // 1. Mutasi / Perpindahan Aset
        Route::get('/mutation/create', [AssetTransactionController::class, 'createMutation'])->name('mutation.create');
        Route::post('/mutation', [AssetTransactionController::class, 'storeMutation'])->name('mutation.store');

        // 2. Peminjaman & Pengembalian (Check-out / Check-in)
        Route::get('/loan/create', [AssetTransactionController::class, 'createLoan'])->name('loan.create');
        Route::post('/loan', [AssetTransactionController::class, 'storeLoan'])->name('loan.store');
        Route::post('/loan/{loan}/return', [AssetTransactionController::class, 'returnLoan'])->name('loan.return');

        // 3. Perawatan & Perbaikan (Maintenance)
        Route::get('/maintenance/create', [AssetTransactionController::class, 'createMaintenance'])->name('maintenance.create');
        Route::post('/maintenance', [AssetTransactionController::class, 'storeMaintenance'])->name('maintenance.store');
    });

    // ==========================================
    // 5. Modul Audit / Stock Opname (module:stock_opname)
    // ==========================================
    Route::middleware(['module:stock_opname'])->prefix('audits')->name('audits.')->group(function () {
        Route::get('/', [AssetAuditController::class, 'index'])->name('index');
        
        // 1. Sesi Audit
        Route::get('/create', [AssetAuditController::class, 'createSession'])->name('create');
        Route::post('/', [AssetAuditController::class, 'storeSession'])->name('store');
        Route::get('/{id}/scan', [AssetAuditController::class, 'scanPage'])->name('scan');
        Route::post('/{id}/scan', [AssetAuditController::class, 'processScan'])->name('process-scan');

        // 3. Laporan Selisih (Discrepancy)
        Route::get('/{id}/report', [AssetAuditController::class, 'discrepancyReport'])->name('report');
    });

    // ==========================================
    // 6. Modul Laporan (module:reports)
    // ==========================================
    Route::middleware(['module:reports'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [AssetReportController::class, 'index'])->name('index');
        Route::get('/position', [AssetReportController::class, 'position'])->name('position');
        Route::get('/room', [AssetReportController::class, 'roomReport'])->name('room');
        Route::get('/depreciation', [AssetReportController::class, 'depreciation'])->name('depreciation');
        Route::get('/maintenance', [AssetReportController::class, 'maintenance'])->name('maintenance');
        Route::get('/disposal', [AssetReportController::class, 'disposal'])->name('disposal');
    });

});
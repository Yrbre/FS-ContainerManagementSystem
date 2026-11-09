<?php

use Whoops\RunInterface;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Console\UserController;
use App\Http\Controllers\Console\AccessController;
use App\Http\Controllers\Console\BannerController;
use App\Http\Controllers\Console\ReportController;
use App\Http\Controllers\Console\ProductController;
use App\Http\Controllers\Console\CategoryController;
use App\Http\Controllers\Console\DashboardController;
use App\Http\Controllers\Console\Auth\LoginController;
use App\Http\Controllers\Console\InspectionController;
use App\Http\Controllers\Console\Master\UnitController;
use App\Http\Controllers\Console\Master\ConfigController;
use App\Http\Controllers\Console\TransactionController;
use App\Http\Controllers\Console\Master\AdminController;
use App\Http\Controllers\Console\Master\VendorController;
use App\Http\Controllers\Console\ProductReviewController;
use App\Http\Controllers\Console\Master\CompanyController;
use App\Http\Controllers\Console\ContainerRepairController;
use App\Http\Controllers\Console\Master\ContractController;
use App\Http\Controllers\Console\Master\LocationController;
use App\Http\Controllers\Console\Master\ContainerController;
use App\Http\Controllers\Console\DelegationToVendorController;
use App\Http\Controllers\Console\DelegationFromVendorController;
use App\Http\Controllers\Console\Master\ContractDetailController;
use App\Http\Controllers\Console\ContainerDailyActivityController;
use App\Http\Controllers\Console\Report\BastReportController;
use App\Http\Controllers\Console\Report\ContainerDashboardController;
use App\Http\Controllers\Console\Report\ContainerStatusReportController;
use App\Http\Controllers\Console\Report\ContainerRecordController;
use App\Http\Controllers\Console\ContainerScrapController;
use App\Http\Controllers\TestController;

Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest:admin')->name('login');
Route::post('login', [LoginController::class, 'authenticated'])->name('auth.login');

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Change Password
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('{admin}/change-password', [AccessController::class, 'profilePassword'])->name('change.password');
        Route::put('{admin}/change-password/update', [AccessController::class, 'changePassword'])->name('change.password.update');
    });

    // Unit Management
    Route::prefix('unit')->name('unit.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager']);
        Route::get('show/{unit}', [UnitController::class, 'show'])->name('show')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager']);
        Route::get('create', [UnitController::class, 'create'])->name('create')
            ->middleware(['role:Administrator']);
        Route::post('store', [UnitController::class, 'store'])->name('store')
            ->middleware(['role:Administrator']);
        Route::get('edit/{unit}', [UnitController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator']);
        Route::put('{unit}', [UnitController::class, 'update'])->name('update')
            ->middleware(['role:Administrator']);
        Route::delete('{unit}', [UnitController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator']);
    });

    // Config Management
    Route::prefix('config')->name('config.')->group(function () {
        Route::get('/', [ConfigController::class, 'index'])->name('index')
            ->middleware(['role:Administrator']);
        Route::get('show/{config}', [ConfigController::class, 'show'])->name('show')
            ->middleware(['role:Administrator']);
        Route::get('create', [ConfigController::class, 'create'])->name('create')
            ->middleware(['role:Administrator']);
        Route::post('store', [ConfigController::class, 'store'])->name('store')
            ->middleware(['role:Administrator']);
        Route::get('edit/{config}', [ConfigController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator']);
        Route::put('{config}', [ConfigController::class, 'update'])->name('update')
            ->middleware(['role:Administrator']);
        Route::delete('{config}', [ConfigController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator']);
        Route::get('start_session', [ConfigController::class, 'start_session'])->name('start')
            ->middleware(['role:Administrator']);
        Route::get('terminate_session', [ConfigController::class, 'terminate_session'])->name('terminate')
            ->middleware(['role:Administrator']);
    });

    // Location Management
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager']);
        Route::get('show/{location}', [LocationController::class, 'show'])->name('show');
        Route::get('create', [LocationController::class, 'create'])->name('create');
        Route::post('store', [LocationController::class, 'store'])->name('store');
        Route::get('edit/{location}', [LocationController::class, 'edit'])->name('edit');
        Route::put('{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('{location}', [LocationController::class, 'destroy'])->name('destroy');
    });


    // Container Management
    Route::prefix('containers')->name('container.')->group(function () {
        Route::get('/', [ContainerController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Purchasing,Site Manager']);
        Route::get('create', [ContainerController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('store', [ContainerController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Supervisor']);
        Route::get('show/{container}', [ContainerController::class, 'show'])->name('show')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Purchasing,Site Manager']);
        Route::get('edit/{container}', [ContainerController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{container}', [ContainerController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Supervisor']);
        Route::delete('{container}', [ContainerController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Supervisor']);
    });

    // Vendor Management 
    Route::prefix('vendors')->name('vendor.')->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Purchasing,Site Manager']);
        Route::get('show/{vendor}', [VendorController::class, 'show'])->name('show')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Purchasing,Site Manager']);
        Route::get('create', [VendorController::class, 'create'])->name('create')
            ->middleware(['role:Administrator']);
        Route::post('store', [VendorController::class, 'store'])->name('store')
            ->middleware(['role:Administrator']);
        Route::get('edit/{vendor}', [VendorController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator']);
        Route::put('{vendor}', [VendorController::class, 'update'])->name('update')
            ->middleware(['role:Administrator']);
        Route::delete('{vendor}', [VendorController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator']);
    });

    // Contract Management 

    Route::prefix('contracts')->name('contract.')->group(function () {
        Route::get('/', [ContractController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Supervisor,Manager,Finance Staff,Purchasing,Site Manager']);
        Route::get('create', [ContractController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('store', [ContractController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Supervisor']);
        Route::get('edit/{contract}', [ContractController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{contract}', [ContractController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Supervisor']);
        Route::delete('{contract}', [ContractController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Supervisor']);

        // Contract Detail
        Route::get('detail/{contract}', [ContractDetailController::class, 'index'])->name('detail.index')
            ->middleware(['role:Administrator,Supervisor,Manager,Finance Staff,Purchasing,Site Manager']);
        Route::get('detail/{contract}/create', [ContractDetailController::class, 'create'])->name('detail.create')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('detail/store/{contract}', [ContractDetailController::class, 'store'])->name('detail.store')
            ->middleware(['role:Administrator,Supervisor']);
        Route::get('detail/edit/{contractDetail}', [ContractDetailController::class, 'edit'])->name('detail.edit')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('detail/{contractDetail}', [ContractDetailController::class, 'update'])->name('detail.update')
            ->middleware(['role:Administrator,Supervisor']);
        Route::delete('detail/{contractDetail}', [ContractDetailController::class, 'destroy'])->name('detail.destroy')
            ->middleware(['role:Administrator,Supervisor']);
    });

    // Inspection
    Route::prefix('inspections')->name('inspection.')->group(function () {
        Route::get('/', [InspectionController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('/create', [InspectionController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/store', [InspectionController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Checker']);
        Route::get('/{inspection}/detail', [InspectionController::class, 'detail'])->name('detail')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::delete('/detail/{inspectionDetail}/destroy', [InspectionController::class, 'detailDestroy'])->name('detail.destroy');
        Route::post('/{inspection}/post', [InspectionController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Checker']);
        Route::delete('/{inspection}/destroy', [InspectionController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Checker']);
        Route::get('/{inspection}/edit', [InspectionController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Checker']);
        Route::put('/{inspection}/update', [InspectionController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Checker']);
        Route::post('{inspection}/approve', [InspectionController::class, 'approve'])->name('approve')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('{inspection}/reject', [InspectionController::class, 'reject'])->name('reject')
            ->middleware(['role:Administrator,Supervisor']);
    });

    //  Comapany Management
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager']);
        Route::get('show/{company}', [CompanyController::class, 'show'])->name('show')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager']);
        Route::get('create', [CompanyController::class, 'create'])->name('create')
            ->middleware(['role:Administrator']);
        Route::post('store', [CompanyController::class, 'store'])->name('store')
            ->middleware(['role:Administrator']);
        Route::get('edit/{company}', [CompanyController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator']);
        Route::put('{company}', [CompanyController::class, 'update'])->name('update')
            ->middleware(['role:Administrator']);
        Route::delete('{company}', [CompanyController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator']);
    });

    // Admin Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Supervisor']);
        Route::get('show/{admin}', [AdminController::class, 'show'])->name('show')
            ->middleware(['role:Administrator,Supervisor']);
        Route::get('create', [AdminController::class, 'create'])->name('create')
            ->middleware(['role:Administrator']);
        Route::post('store', [AdminController::class, 'store'])->name('store')
            ->middleware(['role:Administrator']);
        Route::get('edit/{admin}', [AdminController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator']);
        Route::put('{admin}', [AdminController::class, 'update'])->name('update')
            ->middleware(['role:Administrator']);
        Route::delete('{admin}', [AdminController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator']);
    });

    // Container Daily Activity
    Route::prefix('container-daily-activities')->name('container-daily-activity.')->group(function () {
        Route::get('/', [ContainerDailyActivityController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('/create', [ContainerDailyActivityController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/store', [ContainerDailyActivityController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Checker']);
        Route::get('/{container_daily_activity}/detail', [ContainerDailyActivityController::class, 'detail'])->name('detail')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::post('{container_daily_activity}/post', [ContainerDailyActivityController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Checker']);
        Route::get('/{container_daily_activity}/edit', [ContainerDailyActivityController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Checker']);
        Route::put('/{container_daily_activity}/update', [ContainerDailyActivityController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Checker']);
        Route::delete('/{container_daily_activity}/destroy', [ContainerDailyActivityController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/{container_daily_activity}/detail/upload', [ContainerDailyActivityController::class, 'upload'])->name('upload')
            ->middleware(['role:Administrator,Checker']);
    });

    // Container Delegation To Vendor Management
    Route::prefix('delegation-to-vendors')->name('delegation-to-vendor.')->group(function () {
        Route::get('/', [DelegationToVendorController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Finance,Site Manager']);
        Route::get('/create', [DelegationToVendorController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/store', [DelegationToVendorController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Checker']);
        Route::prefix('{container_delegation}/detail')->group(function () {
            Route::get('/', [DelegationToVendorController::class, 'detail'])->name('detail')
                ->middleware(['role:Administrator,Checker,Supervisor,Manager,Finance,Site Manager']);
            Route::delete('/{container_delegation_detail}', [DelegationToVendorController::class, 'detailDelete'])->name('detail.delete')
                ->middleware(['role:Administrator,Checker']);

            Route::get('/{container_delegation_detail}/sub-detail', [DelegationToVendorController::class, 'subDetail'])->name('sub-detail.index')
                ->middleware(['role:Administrator,Checker,Supervisor,Manager,Finance,Site Manager']);
            Route::delete('/{container_delegation_detail}/sub-detail/{container_delegation_sub_detail}/destroy', [DelegationToVendorController::class, 'subDetailDestroy'])->name('sub-detail.destroy')
                ->middleware(['role:Administrator,Checker']);
            Route::post('{container_delegation_detail}/sub-detail/{container_delegation_sub_detail}/duplicate', [DelegationToVendorController::class, 'duplicateSubDetail'])->name('sub-detail.duplicate')
                ->middleware(['role:Administrator,Checker,Supervisor']);
        });

        Route::get('{container_delegation}/edit', [DelegationToVendorController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Checker,Supervisor']);
        Route::put('{container_delegation}/update', [DelegationToVendorController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Checker,Supervisor']);
        Route::delete('{container_delegation}/destroy', [DelegationToVendorController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Checker']);
        Route::post('{container_delegation}/post', [DelegationToVendorController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Checker']);
        Route::put('{container_delegation}/approve', [DelegationToVendorController::class, 'approve'])->name('approve')
            ->middleware(['role:Administrator,Supervisor,Manager,Finance']);
        Route::put('{container_delegation}/reject', [DelegationToVendorController::class, 'reject'])->name('reject')
            ->middleware(['role:Administrator,Supervisor,Manager,Finance']);
        Route::put('{container_delegation}/unapprove', [DelegationToVendorController::class, 'unapprove'])->name('unapprove')
            ->middleware(['role:Administrator,Supervisor']);
    });

    // Container Repair Management
    Route::prefix('container-repairs')->name('container-repair.')->group(function () {
        Route::get('/', [ContainerRepairController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('/create', [ContainerRepairController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/store', [ContainerRepairController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Checker']);
        Route::get('{container_repair}/detail', [ContainerRepairController::class, 'show'])->name('detail')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('{container_repair}/edit', [ContainerRepairController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Checker']);
        Route::put('{container_repair}/update', [ContainerRepairController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Checker']);
        Route::delete('{container_repair}/destroy', [ContainerRepairController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Checker']);
        Route::post('{container_repair}/post', [ContainerRepairController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Checker']);
        Route::put('{container_repair}/approve', [ContainerRepairController::class, 'approve'])->name('approve')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{container_repair}/reject', [ContainerRepairController::class, 'reject'])->name('reject')
            ->middleware(['role:Administrator,Supervisor']);
    });

    // Container Scrap Management
    Route::prefix('container-scraps')->name('container-scrap.')->group(function () {
        Route::get('/', [ContainerScrapController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('/create', [ContainerScrapController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('/store', [ContainerScrapController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Supervisor']);
        Route::prefix('{container_scrap}/detail')->group(function () {
            Route::get('/', [ContainerScrapController::class, 'detail'])->name('detail')
                ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
            Route::delete('/{container_scrap_detail}/destroy', [ContainerScrapController::class, 'detailDestroy'])->name('detail.destroy')
                ->middleware(['role:Administrator,Supervisor']);
        });
        Route::get('{container_scrap}/detail', [ContainerScrapController::class, 'detail'])->name('detail')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('{container_scrap}/edit', [ContainerScrapController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{container_scrap}/update', [ContainerScrapController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Supervisor']);
        Route::delete('{container_scrap}/destroy', [ContainerScrapController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Supervisor']);
        Route::post('{container_scrap}/post', [ContainerScrapController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{container_scrap}/approve', [ContainerScrapController::class, 'approve'])->name('approve')
            ->middleware(['role:Administrator,Manager']);
        Route::put('{container_scrap}/reject', [ContainerScrapController::class, 'reject'])->name('reject')
            ->middleware(['role:Administrator,Manager']);
    });

    // Container Delegation From Vendor Management
    Route::prefix('delegation-from-vendors')->name('delegation-from-vendor.')->group(function () {
        Route::get('/', [DelegationFromVendorController::class, 'index'])->name('index')
            ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
        Route::get('/create', [DelegationFromVendorController::class, 'create'])->name('create')
            ->middleware(['role:Administrator,Checker']);
        Route::post('/store', [DelegationFromVendorController::class, 'store'])->name('store')
            ->middleware(['role:Administrator,Checker']);
        Route::prefix('{container_delegation_from_vendor}/detail')->group(function () {
            Route::get('/', [DelegationFromVendorController::class, 'detail'])->name('detail')
                ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
            Route::delete('/{ct_from_vendor_detail}/destroy', [DelegationFromVendorController::class, 'detailDestroy'])->name('detail.destroy')
                ->middleware(['role:Administrator,Checker']);
            Route::get('/{ct_from_vendor_detail}/sub-detail', [DelegationFromVendorController::class, 'subDetail'])->name('sub-detail.index')
                ->middleware(['role:Administrator,Checker,Supervisor,Manager,Site Manager']);
            Route::post('{ct_from_vendor_detail}/sub-detail/{container_delegation_sub_detail}/duplicate', [DelegationFromVendorController::class, 'duplicateSubDetail'])->name('sub-detail.duplicate')
                ->middleware(['role:Administrator,Supervisor']);
        });


        Route::get('{container_delegation_from_vendor}/edit', [DelegationFromVendorController::class, 'edit'])->name('edit')
            ->middleware(['role:Administrator,Checker']);
        Route::put('{container_delegation_from_vendor}/update', [DelegationFromVendorController::class, 'update'])->name('update')
            ->middleware(['role:Administrator,Checker']);
        Route::delete('{container_delegation_from_vendor}/destroy', [DelegationFromVendorController::class, 'destroy'])->name('destroy')
            ->middleware(['role:Administrator,Checker']);
        Route::post('{container_delegation_from_vendor}/post', [DelegationFromVendorController::class, 'posted'])->name('posted')
            ->middleware(['role:Administrator,Checker']);
        Route::put('{container_delegation_from_vendor}/approve', [DelegationFromVendorController::class, 'approve'])->name('approve')
            ->middleware(['role:Administrator,Supervisor']);
        Route::put('{container_delegation_from_vendor}/reject', [DelegationFromVendorController::class, 'reject'])->name('reject')
            ->middleware(['role:Administrator,Supervisor']);

        // Update Progress
        Route::put('{container_delegation_from_vendor}/update-progress', [DelegationFromVendorController::class, 'updateProgress'])->name('update.progress');
    });

    // Report Management

    Route::prefix('reports')->name('report.')->group(function () {
        Route::get('/', [ContainerDashboardController::class, 'index'])->name('container-dashboard');
        Route::get('/container-report', [ContainerStatusReportController::class, 'index'])->name('container-status-report');
        Route::get('/container-record', [ContainerRecordController::class, 'index'])->name('container-record');
    });

    // BAST Report
    Route::prefix('bast-reports')->name('bast.')->group(function () {
        // Maintenance
        Route::get('/maintenance', [BastReportController::class, 'maintenance'])->name('maintenance');
        // Upgrade
        Route::get('/upgrade', [BastReportController::class, 'upgrade'])->name('upgrade');
        Route::get('/inspection', [BastReportController::class, 'inspection'])->name('inspection');
    });

    // DownloadUserManual
    Route::get('/donwload-user-manual', [DashboardController::class, 'downloadUserManual'])->name('download.user-manual');


});

Route::get('/test', [TestController::class, 'index']);
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\CommonSupplyController;
use App\Http\Controllers\CommonSupplyTransactionController;
use App\Http\Controllers\CommonSupplyCustomTransactionController;
use App\Http\Controllers\CommonSupplyRequestSentController;
use App\Http\Controllers\CommonSupplyRequestSharedController;
use App\Http\Controllers\CommonSupplyRequestReceivedController;
use App\Http\Controllers\CommonSupplyRequestAssessmentController;
use App\Http\Controllers\CommonSupplyRequestIssuanceController;
use App\Http\Controllers\CommonSupplyRequestIssuedController;
use App\Http\Controllers\CommonSupplyReportController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AllRegisteredController;
use App\Http\Controllers\ActiveController;
use App\Http\Controllers\InactiveController;
use App\Http\Controllers\LockedController;
use App\Http\Controllers\SystemMessageController;
use App\Http\Controllers\CenterCodeController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\SemiExpendableController;
use App\Http\Controllers\SemiExpendableTransactionController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTransactionController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\MonthlyReportController;
use App\Livewire\Admin\TopSupplyItemsLivewire;

// ------------------------------------------------------------------------------------------------------------------
    Route::get('/', function () {
        return view('welcome');
    })->middleware('check.unavailable');

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
        'check.unavailable',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    Route::middleware(['auth','check.unavailable'])->group(function () {
        Route::get('/home',[AccountController::class,'index']);

        Route::get('/custom-category',[CategoryController::class,'index']);
        Route::get('/custom-unit',[UnitController::class,'index']);
        Route::get('/custom-signature',[SignatureController::class,'index']);
        Route::get('/custom-office',[OfficeController::class,'index']);
        Route::get('/custom-position',[PositionController::class,'index']);
        Route::get('/custom-center',[CenterCodeController::class,'index']);
        Route::get('/custom-division',[DivisionController::class,'index']);
        Route::get('/custom-entity',[EntityController::class,'index']);
        Route::get('/custom-fund',[FundController::class,'index']);

        Route::get('/masterlist-cs',[CommonSupplyController::class,'index']);
        Route::get('/masterlist-sep',[SemiExpendableController::class,'index']);
        Route::get('/masterlist-ppe',[PropertyController::class,'index']);

        Route::get('/transaction-cs',[CommonSupplyTransactionController::class,'index']);
        Route::get('/transaction-custom-cs',[CommonSupplyCustomTransactionController::class,'index']);
        Route::get('/transaction-sep',[SemiExpendableTransactionController::class,'index']);
        Route::get('/transaction-ppe',[PropertyTransactionController::class,'index']);

        Route::get('/request-sent',[CommonSupplyRequestSentController::class,'index']);
        Route::get('/request-shared',[CommonSupplyRequestSharedController::class,'index']);
        Route::get('/request-received',[CommonSupplyRequestReceivedController::class,'index']);
        Route::get('/request-assessment',[CommonSupplyRequestAssessmentController::class,'index']);
        Route::get('/request-issuance',[CommonSupplyRequestIssuanceController::class,'index']);
        Route::get('/request-issued',[CommonSupplyRequestIssuedController::class,'index']);

        Route::get('/report-cs',[CommonSupplyReportController::class,'index']);

        Route::get('/users-superadmin',[SuperadminController::class,'index']);
        Route::get('/users-administrator',[AdministratorController::class,'index']);
        Route::get('/users-user',[UserController::class,'index']);
        Route::get('/users-all',[AllRegisteredController::class,'index']);
        Route::get('/users-active',[ActiveController::class,'index']);
        Route::get('/users-inactive',[InactiveController::class,'index']);
        Route::get('/users-locked',[LockedController::class,'index']);

        Route::get('/sysmsg',[SystemMessageController::class,'index']);

        Route::get('/report/ris/{code}', [\App\Http\Controllers\RISController::class, 'view'])->name('ris.pdf');

        

        Route::get('/logout',function(){
            return redirect()->route('dashboard');
        });

        Route::post('logout', function () {
            Auth::logout();
            return redirect()->route('login');
        })->name('logout');
    });

    Route::get('/monthly-report-supplies', function () {
        return view('admin.monthly-report');
    })->name('reports.monthly');

    Route::get('/top-supply-items', function () {
        return view('admin.top-supply-items');
    })->name('reports.monthly');
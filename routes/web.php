<?php

use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventLoginWhenAuthenticated;
use App\Http\Controllers\Printdriver;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\Invoices\Edit;

//  Logout
Route::get('/logout', function () {
    Auth::guard('account')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

//  Public routes (login only if not authenticated)
Route::middleware([PreventLoginWhenAuthenticated::class])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/', fn() => redirect()->route('login'));
});

// 🔒 Authenticated routes
Route::middleware(['auth:account'])->group(function () {

    //  Root route → role based
    Route::get('/', function () {
        $user = Auth::guard('account')->user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard'); // Admin → dashboard
        }
        return redirect()->route('selling.create'); // Normal user → selling
    })->name('home');

    //  Admin-only routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', fn() => view('dashboards.create'))->name('dashboard');

        // Invoices edit
        Route::get('/invoices/edit/{id}', [Edit::class, 'index'])->name('invoices.edit');

        // Resource views
        Route::view('/drivers', 'drivers.create')->name('driver.create');
        Route::view('/definitions', 'definitions.create')->name('definitions.create');
        Route::view('/changetypeitem', 'changetypeitem.create')->name('changetypeitem.create');
        Route::view('/userpayment', 'userpayment.create')->name('userpayment.create');
        Route::view('/types', 'types.create')->name('types.create');
        Route::view('/products', 'products.create')->name('products.create');
        Route::view('/expenses', 'expenses.create')->name('expenses.create');
        Route::view('/accounts', 'accounts.create')->name('accounts.create');
        Route::view('/Invoices', 'Invoices.create')->name('add_Invoices.create');
        Route::view('/companys', 'companys.create')->name('companys.create');
        Route::view('/Invoices/show', 'Invoices.show.show_Invoices')->name('show_Invoices.create');
        Route::view('/offers', 'offers.create')->name('offers.create');
        Route::view('/offers/edit', 'offers.edit')->name('offers.edit');
        Route::view('/returnproducts', 'returnproducts.create')->name('returnproducts.create');
        Route::view('/dashboards', 'dashboards.create')->name('dashboards.create');
        Route::view('/getAPI', 'getAPI.create')->name('getAPI.create');
        Route::view('/APIApproved', 'getAPI.approved')->name('getAPI.approved');
        Route::view('/accounting', 'accounting.create')->name('accounting.create');
        Route::view('/accounting/createbuy', 'accounting.createbuyproduct')->name('accounting.createbuyproduct');
        Route::view('/drivers/invoices_control', 'drivers.invoices_control.create')->name('invoice_control.create');
        Route::view('/returnsell', 'returnsell.create')->name('returnsell.create');
        Route::view('/accountdrivers', 'accountdrivers.create')->name('accountdrivers.create');
        // Backup
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [BackupController::class, 'backup'])->name('backup');
        Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
    });

    //  Normal users
    Route::view('/selling', 'selling.create')->name('selling.create');


    //  Printing
    Route::get('/print/invoice/{id}', [PrintController::class, 'printSingle'])->name('print.single');
    Route::get('/print/driver-invoices', [Printdriver::class, 'printInvoices'])->name('print.driver-invoices');
    Route::get('/print/invoices', [PrintController::class, 'printInvoices'])->name('print.invoices');
    Route::get('/multiprint/invoices', fn() => view('print.multiprintinvoice.create'))->name('print.create');

    Route::get('/receipt/print', function () {
        if (!session()->has('receiptData')) {
            return redirect()->route('home');
        }
        $data = session('receiptData');
        return view('receipts.sale-receipt', $data);
    })->name('receipt.print');
});

//  Catch-all
Route::any('{any}', function () {
    if (Auth::guard('account')->check()) {
        $user = Auth::guard('account')->user();
        return $user->role === 'admin'
            ? redirect()->route('dashboard')
            : redirect()->route('selling.create');
    }
    return redirect()->route('login');
})->where('any', '.*');

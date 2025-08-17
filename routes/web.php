<?php

use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventLoginWhenAuthenticated;
use App\Http\Controllers\Printdriver;
use App\Http\Controllers\PrintController;

// Route::get('/print/invoice/{id}', [PrintController::class, 'printSingle'])
//     ->name('print.single');

// Route::get('/print/driver-invoices', [Printdriver::class, 'printInvoices'])
//     ->name('print.driver-invoices');
// Route::get('/print/invoices', [PrintController::class, 'printInvoices'])
//     ->name('print.invoices');

// Route::get('/multiprint/invoices', function () {
//     return view('print.multiprintinvoice.create');
// })
//     ->name('print.create');

// Route::get('/receipt/print', function() {
//     if (!session()->has('receiptData')) {
//         return redirect('/');
//     }
    
//     $data = session('receiptData');
//     return view('receipts.sale-receipt', $data);
// })->name('receipt.print');
// Route::get('/', function () {
//     return view('layouts.index');
// });

// Route::get('/drivers', function () {
//     return view('drivers.create');
// })->name('driver.create');
// Route::get('/drivers/invoices_control', function () {
//     return view('drivers.invoices_control.create');
// })->name('invoice_control.create');


// Route::get('/definitions', function () {
//     return view('definitions.create');
// })->name('definitions.create');

// Route::get('/types', function () {
//     return view('types.create');
// })->name('types.create');

// Route::get('/products', function () {
//     return view('products.create');
// })->name('products.create');

// Route::get('/expenses', function () {
//     return view('expenses.create');
// })->name('expenses.create');
// Route::get('/accounts', function () {
//     return view('accounts.create');
// })->name('accounts.create');

// Route::get('/Invoices', function () {
//     return view('Invoices.create');
// })->name('add_Invoices.create');
// Route::get('/companys', function () {
//     return view('companys.create');
// })->name('companys.create');
// Route::get('/Invoices/show', function () {
//     return view('Invoices.show.show_Invoices');
// })->name('show_Invoices.create');
// Route::get('/selling', function () {
//     return view('selling.create');
// })->name('selling.create');

// Route::get('/offers',function(){
// return view('offers.create');
// })->name('offers.create');

// Route::get('/offers/edit',function(){
// return view('offers.edit');
// })->name('offers.edit');


// Route::get('/returnproducts',function(){
// return view('returnproducts.create');
// })->name('returnproducts.create');


// Route::get('/',function(){
// return view('dashboards.create');
// })->name('dashboards.create');


// Route::get('/getAPI',function(){
// return view('getAPI.create');
// })->name('getAPI.create');

// Route::get('/returnsell', function () {
//     return view('returnsell.create');
// })->name('returnsell.create');


// Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
// Route::post('/backup', [BackupController::class, 'backup'])->name('backup');
// Route::post('/restore', [BackupController::class, 'restore'])->name('restore');


// Route::get('/', Login::class)->name('login');
// // Public routes
// Route::middleware([PreventLoginWhenAuthenticated::class])->group(function () {
//     Route::get('/', Login::class)->name('login');
// });

// Public routes
Route::get('/logout', function () {
    Auth::guard('account')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

// Public route: login
Route::middleware([PreventLoginWhenAuthenticated::class])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

// Authenticated routes
Route::middleware(['auth:account'])->group(function () {

    // Dashboard
    Route::get('/index', fn() => view('dashboards.create'))->name('dashboard');

    // Redirect root to dashboard if logged in
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Admin-only routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        // Keep admin routes here
    });

    // Printing routes
    Route::get('/print/invoice/{id}', [PrintController::class, 'printSingle'])->name('print.single');
    Route::get('/print/driver-invoices', [Printdriver::class, 'printInvoices'])->name('print.driver-invoices');
    Route::get('/print/invoices', [PrintController::class, 'printInvoices'])->name('print.invoices');
    Route::get('/multiprint/invoices', fn() => view('print.multiprintinvoice.create'))->name('print.create');

    Route::get('/receipt/print', function() {
        if (!session()->has('receiptData')) {
            return redirect()->route('dashboard');
        }
        $data = session('receiptData');
        return view('receipts.sale-receipt', $data);
    })->name('receipt.print');

    // Resource views
    Route::view('/drivers', 'drivers.create')->name('driver.create');
    Route::view('/drivers/invoices_control', 'drivers.invoices_control.create')->name('invoice_control.create');
    Route::view('/definitions', 'definitions.create')->name('definitions.create');
    Route::view('/types', 'types.create')->name('types.create');
    Route::view('/products', 'products.create')->name('products.create');
    Route::view('/expenses', 'expenses.create')->name('expenses.create');
    Route::view('/accounts', 'accounts.create')->name('accounts.create');
    Route::view('/Invoices', 'Invoices.create')->name('add_Invoices.create');
    Route::view('/companys', 'companys.create')->name('companys.create');
    Route::view('/Invoices/show', 'Invoices.show.show_Invoices')->name('show_Invoices.create');
    Route::view('/selling', 'selling.create')->name('selling.create');
    Route::view('/offers', 'offers.create')->name('offers.create');
    Route::view('/offers/edit', 'offers.edit')->name('offers.edit');
    Route::view('/returnproducts', 'returnproducts.create')->name('returnproducts.create');
    Route::view('/dashboards', 'dashboards.create')->name('dashboards.create');
    Route::view('/getAPI', 'getAPI.create')->name('getAPI.create');
    Route::view('/returnsell', 'returnsell.create')->name('returnsell.create');

    // Backup routes
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [BackupController::class, 'backup'])->name('backup');
    Route::post('/restore', [BackupController::class, 'restore'])->name('restore');
});

// Catch-all route for authenticated or guest users
Route::any('{any}', function () {
    if (Auth::guard('account')->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->where('any', '.*');
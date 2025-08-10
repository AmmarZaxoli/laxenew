<?php

use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventLoginWhenAuthenticated;
use App\Http\Controllers\Printdriver;
use App\Http\Controllers\PrintController;

Route::get('/print/driver-invoices', [Printdriver::class, 'printInvoices'])
    ->name('print.driver-invoices');
Route::get('/print/invoices', [PrintController::class, 'printInvoices'])
    ->name('print.invoices');
// Route::get('/', Login::class)->name('login');
// // Public routes
// Route::middleware([PreventLoginWhenAuthenticated::class])->group(function () {
//     Route::get('/', Login::class)->name('login');
// });

// // Public routes

// Route::get('/logout', function () {
//     Auth::guard('account')->logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect()->route('login')
//         ->withHeaders([
//             'Cache-Control' => 'no-cache, no-store, must-revalidate',
//             'Pragma' => 'no-cache',
//             'Expires' => '0'
//         ]);
// })->name('logout');

// // Authenticated routes
// Route::middleware(['auth:account'])->group(function () {
//     Route::get('/index', fn() => view('layouts.index'))->name('dashboard');

//     // Admin-only routes
//     Route::middleware([AdminMiddleware::class])->group(function () {
//         Route::get('/drivers', fn() => view('drivers.create'))->name('driver.create');
//         Route::get('/expenses', fn() => view('expenses.create'))->name('expenses.create');
//     });

//     Route::get('/types', fn() => view('types.create'))->name('types.create');
//     Route::get('/definitions', fn() => view('definitions.create'))->name('definitions.create');
//     Route::get('/products', fn() => view('products.create'))->name('products.create');
//     Route::get('/accounts', fn() => view('accounts.create'))->name('accounts.create');
//     Route::get('/add_Invoices', fn() => view('add_Invoices.create'))->name('add_Invoices.create');
// });
// Route::any('{any}', function () {
//     if (Auth::guard('account')->check()) {
//         return redirect()->route('dashboard');
//     }
//     return redirect('/');
// })->where('any', '.*');

// // Catch-all route for unauthorized access
// Route::fallback(function () {
//     return redirect('/');
// });

Route::get('/receipt/print', function() {
    if (!session()->has('receiptData')) {
        return redirect('/');
    }
    
    $data = session('receiptData');
    return view('receipts.sale-receipt', $data);
})->name('receipt.print');
Route::get('/', function () {
    return view('layouts.index');
});

Route::get('/drivers', function () {
    return view('drivers.create');
})->name('driver.create');
Route::get('/drivers/invoices_control', function () {
    return view('drivers.invoices_control.create');
})->name('invoice_control.create');


Route::get('/definitions', function () {
    return view('definitions.create');
})->name('definitions.create');

Route::get('/types', function () {
    return view('types.create');
})->name('types.create');

Route::get('/products', function () {
    return view('products.create');
})->name('products.create');

Route::get('/expenses', function () {
    return view('expenses.create');
})->name('expenses.create');
Route::get('/accounts', function () {
    return view('accounts.create');
})->name('accounts.create');

Route::get('/Invoices', function () {
    return view('Invoices.create');
})->name('add_Invoices.create');
Route::get('/companys', function () {
    return view('companys.create');
})->name('companys.create');
Route::get('/Invoices/show', function () {
    return view('Invoices.show.show_Invoices');
})->name('show_Invoices.create');
Route::get('/selling', function () {
    return view('selling.create');
})->name('selling.create');

Route::get('/offers',function(){
return view('offers.create');
})->name('offers.create');

Route::get('/offers/edit',function(){
return view('offers.edit');
})->name('offers.edit');


Route::get('/returnproducts',function(){
return view('returnproducts.create');
})->name('returnproducts.create');


Route::get('/',function(){
return view('dashboards.create');
})->name('dashboards.create');


Route::get('/getAPI',function(){
return view('getAPI.create');
})->name('getAPI.create');

Route::get('/returnsell', function () {
    return view('returnsell.create');
})->name('returnsell.create');






Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup', [BackupController::class, 'backup'])->name('backup');
Route::post('/restore', [BackupController::class, 'restore'])->name('restore');



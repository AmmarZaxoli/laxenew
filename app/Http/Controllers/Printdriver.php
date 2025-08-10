<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell_invoice;
use App\Models\Driver;
use Carbon\Carbon;

class Printdriver extends Controller
{

public function printInvoices(Request $request)
{
    $invoiceIds = array_filter(explode(',', $request->invoiceIds));
    $driverName = $request->driverName; // Get the driver name from request

    $invoices = Sell_invoice::with(['customer.driver', 'sell'])
        ->whereIn('num_invoice_sell', $invoiceIds)
        ->get()
        ->filter(fn($invoice) => $invoice && $invoice->customer && $invoice->sell);

    $data = [
        'driver_name' => $driverName, // Use the explicitly passed driver name
        'date' => now()->format('Y-m-d'),
        'invoices' => $invoices->map(function ($invoice) {
            return [
                'invoice_number' => $invoice->num_invoice_sell,
                'address' => $invoice->customer->address ?? '—',
                'mobile' => $invoice->customer->mobile ?? '—',
                'taxi_price' => $invoice->sell->taxi_price ?? 0,
                'total' => $invoice->sell->total_price_afterDiscount_invoice ?? 0,
                'grand_total' => 
                    ($invoice->sell->taxi_price ?? 0) + 
                    ($invoice->sell->total_price_afterDiscount_invoice ?? 0),
            ];
        })->toArray(),
        'total_taxi_price' => $invoices->sum(fn($i) => $i->sell->taxi_price ?? 0),
        'total_invoice_total' => $invoices->sum(fn($i) => $i->sell->total_price_afterDiscount_invoice ?? 0),
    ];

    return view('print.printdrivers', compact('data'));
}
}

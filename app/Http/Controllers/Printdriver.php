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
    $driverName = $request->driverName ?? '—'; // ضمان وجود اسم

    if (empty($invoiceIds)) {
        abort(404, 'No invoices specified.');
    }

    $invoices = Sell_invoice::with(['customer.driver', 'sell'])
        ->whereIn('num_invoice_sell', $invoiceIds)
        ->whereHas('customer')
        ->whereHas('sell')
        ->get();

    if ($invoices->isEmpty()) {
        abort(404, 'No invoices found.');
    }

    $data = [
        'driver_name' => $driverName,
        'date' => now()->format('Y-m-d'),
        'driverInvoices' => $invoices->map(function ($invoice) {
            // إذا كانت علاقة sell مجموعة نأخذ أول عنصر أو نحسب المجموع حسب حاجتك
            $sell = is_iterable($invoice->sell) ? $invoice->sell->first() : $invoice->sell;

            return [
                'invoice_number' => $invoice->num_invoice_sell,
                'address' => $invoice->customer->address ?? '—',
                'mobile' => $invoice->customer->mobile ?? '—',
                'taxi_price' => $sell->taxi_price ?? 0,
                'total' => $sell->total_price_afterDiscount_invoice ?? 0,
                'grand_total' =>
                    ($sell->taxi_price ?? 0) +
                    ($sell->total_price_afterDiscount_invoice ?? 0),
            ];
        })->toArray(),
        'total_taxi_price' => $invoices->sum(function ($i) {
            $sell = is_iterable($i->sell) ? $i->sell->first() : $i->sell;
            return $sell->taxi_price ?? 0;
        }),
        'total_invoice_total' => $invoices->sum(function ($i) {
            $sell = is_iterable($i->sell) ? $i->sell->first() : $i->sell;
            return $sell->total_price_afterDiscount_invoice ?? 0;
        }),
    ];

    return view('print.printdrivers', compact('data'));
}

}

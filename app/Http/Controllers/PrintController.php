<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell_invoice;

class PrintController extends Controller
{
    public function printInvoices(Request $request)
    {
        $invoiceIds = array_filter(explode(',', $request->invoiceIds));

        $invoices = Sell_invoice::with([
                'customer.driver',
                'sell',
                'sellingProducts.product',
            ])
            ->whereIn('num_invoice_sell', $invoiceIds)
            ->get()
            ->filter(fn($invoice) => $invoice && $invoice->customer && $invoice->sell);

        $firstInvoice = $invoices->first();

        $data = [
            'driver_name' => optional(optional($firstInvoice)->customer)->driver->nameDriver ?? 'Multiple Invoices',
            'date' => now()->format('Y-m-d'),
            'invoices' => $invoices->map(function ($invoice) {
                return [
                    'invoice_number' => $invoice->num_invoice_sell,
                    'address' => $invoice->customer->address ?? '—',
                    'mobile' => $invoice->customer->mobile ?? '—',
                    'taxi_price' => optional($invoice->sell)->taxi_price ?? 0,
                    'total' => optional($invoice->sell)->total_price_afterDiscount_invoice ?? 0,
                    'grand_total' =>
                        (optional($invoice->sell)->taxi_price ?? 0) +
                        (optional($invoice->sell)->total_price_afterDiscount_invoice ?? 0),
                    'products' => $invoice->sellingProducts->map(function ($item) {
                        return [
                            'name' => $item->product->definition->name ?? '—',
                            'code' => $item->product->definition->code ?? '—',
                            'qty' => $item->quantity ?? 0,
                            'price' => $item->price ?? 0,
                            'total' => ($item->quantity ?? 0) * ($item->price ?? 0),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
            'total_taxi_price' => $invoices->sum(fn($i) => optional($i->sell)->taxi_price ?? 0),
            'total_invoice_total' => $invoices->sum(fn($i) => optional($i->sell)->total_price_afterDiscount_invoice ?? 0),
        ];

        return view('print.invoices', compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell_invoice;

class PrintController extends Controller
{
    public function printInvoices(Request $request)
    {
        $invoiceIds = array_filter(explode(',', $request->invoiceIds));

        if (empty($invoiceIds)) {
            return back()->with('error', 'لم يتم تحديد أي فاتورة');
        }

        $invoices = Sell_invoice::with([
            'customer.driver',
            'sell',
            'sellingProducts.product.definition',
        ])
            ->whereIn('num_invoice_sell', $invoiceIds)
            ->orderByRaw("FIELD(num_invoice_sell, " . implode(',', $invoiceIds) . ")")
            ->get()
            ->filter(fn($invoice) => $invoice && $invoice->customer && $invoice->sell);

        if ($invoices->isEmpty()) {
            return back()->with('error', 'لا توجد فواتير مطابقة');
        }

        $drivers = $invoices->pluck('customer.driver.nameDriver')->unique()->filter();
        $driverName = $drivers->count() === 1 ? $drivers->first() : 'عدة سواق';

        // Prepare paginated invoices
        $itemsPerPage = 8; // Products per page
        $preparedInvoices = [];

        foreach ($invoices as $invoice) {
            $products = $invoice->sellingProducts->map(function ($item) {
                return [
                    'name'  => $item->product->definition->name ?? '—',
                    'code'  => $item->product->definition->code ?? '—',
                    'qty'   => $item->quantity ?? 0,
                    'price' => $item->price ?? 0,
                    'total' => ($item->quantity ?? 0) * ($item->price ?? 0),
                ];
            });

            $chunks = $products->chunk($itemsPerPage);
            $pageCount = $chunks->count();

            foreach ($chunks as $pageIndex => $chunk) {
                $preparedInvoices[] = [
                    'invoice_number' => $invoice->num_invoice_sell,
                    'address'        => $invoice->customer->address ?? '—',
                    'mobile'         => $invoice->customer->mobile ?? '—',
                    'taxi_price'     => $invoice->sell->taxi_price ?? 0,
                    'total'          => $invoice->sell->total_price_afterDiscount_invoice ?? 0,
                    'grand_total'    => ($invoice->sell->taxi_price ?? 0) + 
                                        ($invoice->sell->total_price_afterDiscount_invoice ?? 0),
                    'products'       => $chunk->toArray(),
                    'show_header'    => true, // Always show header
                    'show_footer'    => $pageIndex === $pageCount - 1, // Footer only on last page
                ];
            }
        }

        $data = [
            'driver_name' => $driverName,
            'date'        => now()->format('Y-m-d'),
            'invoices'    => $preparedInvoices,
        ];

        return view('print.invoices', compact('data'));
    }
}
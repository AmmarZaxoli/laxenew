<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell_invoice;
use Milon\Barcode\DNS1D;


class PrintController extends Controller
{

    public function printSingle($id)
    {

        $itemsPerPage = 7; // max products per page

        $invoice = Sell_invoice::with(['customer.driver', 'products', 'offersell', 'sell'])
            ->findOrFail($id);

        if ($invoice->customer) {
            $invoice->customer->update(['print' => 1]);
        }
        $barcodeGenerator = new DNS1D();
        $barcodePNG = $barcodeGenerator->getBarcodePNG($invoice->num_invoice_sell, 'C39');

        // Prepare products
        $products = $invoice->products->map(function ($p) {
            $qty = $p->pivot->qty ?? $p->quantity ?? 1;
            $price = $p->pivot->price ?? $p->price;
            return [
                'name'  => $p->name,
                'code'  => $p->code,
                'qty'   => $qty,
                'price' => $price,
                'total' => $qty * $price,
                'type'  => 'product'
            ];
        });

        // Prepare offers
        $offers = $invoice->offersell->map(function ($o) {
            $qty = $o->quantity ?? 1;
            $price = $o->price ?? 0;
            return [
                'name'  => $o->nameoffer,
                'code'  => $o->code,
                'qty'   => $qty,
                'price' => $price,
                'total' => $qty * $price,
                'type'  => 'offer'
            ];
        });

        // Merge products + offers
        $allItems = $products->concat($offers);

        // Split into chunks of $itemsPerPage
        $chunks = $allItems->chunk($itemsPerPage);
        $pageCount = $chunks->count();

        // Totals
        $total = $allItems->sum('total');
        $discount = $invoice->sell->discount ?? 0;
        $taxi_price = $invoice->customer->driver->taxiprice ?? 0;
        $total_price_afterDiscount_invoice = ($total + $taxi_price) - $discount;

        $preparedInvoices = [];
        foreach ($chunks as $pageIndex => $chunk) {
            $preparedInvoices[] = [
                'barcodePNG'  => $barcodePNG,  // ← add this

                'invoice_number' => $invoice->num_invoice_sell, // ← add this
                'address'   => $invoice->customer->address ?? '',
                'mobile'    => $invoice->customer->mobile ?? '',
                'products'  => $chunk,
                'total'     => $total,
                'discount'  => $discount,
                'taxi_price' => $taxi_price,
                'total_price_afterDiscount_invoice' => $total_price_afterDiscount_invoice,
                'show_header' => true, // always show header
                'show_footer' => $pageIndex === $pageCount - 1, // only on last page
            ];
        }

        $data = [
            'driver_name' => $invoice->customer->driver->nameDriver ?? '',
            'invoices'    => $preparedInvoices
            
        ];

        return view('print.invoices', [
            'data' => $data,
            'invoice' => $invoice,
        ]);
    }




    public function printInvoices(Request $request)
    {
        $invoiceIds = array_filter(explode(',', $request->invoiceIds));

        if (empty($invoiceIds)) {
            return back()->with('error', 'لم يتم تحديد أي فاتورة');
        }

        $invoices = Sell_invoice::with([
            'customer.driver',
            'sell',
            'products',       // main products
            'offersell',      // offers
        ])
            ->whereIn('num_invoice_sell', $invoiceIds)
            ->orderByRaw("FIELD(num_invoice_sell, " . implode(',', $invoiceIds) . ")")
            ->get()
            ->filter(fn($invoice) => $invoice && $invoice->customer && $invoice->sell);

        if ($invoices->isEmpty()) {
            return back()->with('error', 'لا توجد فواتير مطابقة');
        }

        // Determine driver name
        // $drivers = $invoices->pluck('customer.driver.nameDriver')->unique()->filter();
        // $driverName = $drivers->count() === 1 ? $drivers->first() : 'عدة سواق';

        $itemsPerPage = 7; // Products per page
        $preparedInvoices = [];
        $barcodeGenerator = new DNS1D();

        foreach ($invoices as $invoice) {

            $barcodePNG = $barcodeGenerator->getBarcodePNG($invoice->num_invoice_sell, 'C39');

            // Prepare products
            $products = $invoice->products->map(function ($p) {
                $qty = $p->pivot->qty ?? $p->quantity ?? 1;
                $price = $p->pivot->price ?? $p->price ?? 0;
                return [
                    'name'  => $p->name ?? '—',
                    'code'  => $p->code ?? '—',
                    'qty'   => $qty,
                    'price' => $price,
                    'total' => $qty * $price,
                    'type'  => 'product',
                ];
            });

            // Prepare offers
            $offers = $invoice->offersell->map(function ($o) {
                $qty = $o->quantity ?? 1;
                $price = $o->price ?? 0;
                return [
                    'name'  => $o->nameoffer ?? '—',
                    'code'  => $o->code ?? '—',
                    'qty'   => $qty,
                    'price' => $price,
                    'total' => $qty * $price,
                    'type'  => 'offer',
                ];
            });

            // Merge products + offers
            $allItems = $products->concat($offers);
            $chunks = $allItems->chunk($itemsPerPage);
            $pageCount = $chunks->count();

            // Totals
            $total = $allItems->sum('total');
            $discount = $invoice->sell->discount ?? 0;
            $taxi_price = $invoice->customer->driver->taxiprice ?? 0;
            $total_price_afterDiscount_invoice = ($total + $taxi_price) - $discount;

            foreach ($chunks as $pageIndex => $chunk) {
                $preparedInvoices[] = [
                    'barcodePNG'  => $barcodePNG,
                    'invoice_number' => $invoice->num_invoice_sell,
                    'address'   => $invoice->customer->address ?? '—',
                    'driver_name' => $invoice->customer->driver->nameDriver ?? '',
                    'mobile'    => $invoice->customer->mobile ?? '—',
                    'products'  => $chunk->toArray(),
                    'total'     => $total,
                    'discount'  => $discount,
                    'taxi_price' => $taxi_price,
                    'total_price_afterDiscount_invoice' => $total_price_afterDiscount_invoice,
                    'show_header' => true,
                    'show_footer' => $pageIndex === $pageCount - 1, // only last page
                ];
            }
        }
        // جلب أسماء السواقين
        $drivers = $invoices->pluck('customer.driver.nameDriver')->unique()->filter();
        $driverName = $drivers->count() === 1 ? $drivers->first() : 'عدة سواق';
        $data = [
            'date'        => now()->format('Y-m-d'),
            'driver_name' => $driverName, 

            'invoices'    => $preparedInvoices,
        ];

        return view('print.multiprint', compact('data'));
    }
}

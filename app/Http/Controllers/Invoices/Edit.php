<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Buy_invoice;
use Illuminate\Http\Request;
use App\Models\Sub_Buy_Products_invoice;

class Edit extends Controller
{
    public function index($id)
    {
        // Fetch the invoice by ID
        $invoice = Buy_invoice::findOrFail($id);

        // Fetch related products from Sub_Buy_Products_invoice
        $products = Sub_Buy_Products_invoice::where('num_invoice_id', $invoice->id)->get();

        // Pass both invoice and products to the view
        return view('invoices.edit', compact('invoice', 'products'));
    }
}

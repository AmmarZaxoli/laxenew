<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellingProduct extends Model
{
    protected $table = 'selling_products';

    protected $fillable = [
        'name',
        'code',
        'barcode',
        'quantity',
        'price',
        'total_price',
        'type_id',
        'product_id',
        'sub_buy_invoice_product_id',
        'sell_invoice_id',
    ];

    public function sellInvoice()
    {
        return $this->belongsTo(Sell_Invoice::class, 'sell_invoice_id');
    }

    // Relation to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relation to SubBuyInvoiceProduct
    public function subBuyInvoiceProduct()
    {
        return $this->belongsTo(Sub_Buy_Products_invoice::class, 'sub_buy_invoice_product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Buy_Products_invoice extends Model
{
    protected $table = 'sub_buy_products_invoices';

    protected $fillable = [
        'product_id',
        'name',
        'barcode',
        'code',
        'type_id',
        'datecreate',
        'quantity',
        'buy_price',
        'sell_price',
        'profit',
        'dateex',
        'q_sold',
        'num_invoice_id',
        'buy_product_invoice_id',
    ];

    public function getAvailableAttribute()
    {
        return $this->quantity - $this->q_sold;
    }


    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function buy_invoice()
    {
        return $this->belongsTo(Buy_invoice::class, 'num_invoice_id');
    }

    public function buy_products_invoice()
    {
        return $this->belongsTo(Buy_Products_invoice::class, 'buy_product_invoice_id');
    }
}

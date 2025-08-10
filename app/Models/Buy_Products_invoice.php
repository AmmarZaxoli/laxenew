<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy_Products_invoice extends Model
{
    use HasFactory;

    protected $table = 'buy_products_invoices';

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
    ];
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function buy_invoice()
    {
        return $this->belongsTo(Buy_invoice::class, 'num_invoice_id');
    }

    public function sub_buy_products_invoices()
    {
        return $this->hasMany(Sub_Buy_Products_invoice::class, 'buy_product_invoice_id');
    }
}

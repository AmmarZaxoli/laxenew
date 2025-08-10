<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sellinfo extends Model
{
    protected $table = 'sells';

    protected $fillable = [
        'taxi_price',
        'total_Price_invoice',
        'discount',
        'total_price_afterDiscount_invoice',
        'cash',
        'user',
        'sell_invoice_id',
    ];

    // Each Sell belongs to a SellInvoice
    public function invoice()
    {
        return $this->belongsTo(Sell_Invoice::class, 'sell_invoice_id');
    }
}

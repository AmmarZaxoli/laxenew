<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seling_product_info extends Model
{
    protected $table = 'seling_product_infos';

    protected $fillable = [
        'product_id',
        'quantity_sold',
        'buy_price',
        'total_sell',
        'profit',
        'sub_id',
        'sell_invoice_id',
    ];
    public function sellInvoice()
    {
        return $this->belongsTo(Sell_invoice::class, 'sell_invoice_id');
    }
}

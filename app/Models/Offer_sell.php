<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer_sell extends Model
{
    protected $table = 'offer_sells';
    protected $fillable = ['nameoffer', 'code', 'quantity', 'price', 'sell_invoice_id','offer_sell_id'];

    public function sellInvoice()
    {
        return $this->belongsTo(Sell_invoice::class, 'sell_invoice_id','id');
    }
}

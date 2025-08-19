<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymentinvoce extends Model
{
    protected $table = "paymentinvoces";


    protected $fillable = ['date_payment', 'cashpayment', 'invoce_id'];

    public function buy_invoice()
    {
        return $this->belongsTo(Buy_invoice::class, 'invoce_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = "customers";
    protected $fillable = [
        'mobile',
        'address',
        'date_sell',
        'driver_id',
        'profit_invoice',
        'profit_invoice_after_discount',
        'sell_invoice_id',
        'note',
        'waypayment',
        'buywith',
        'block',
    ];

    public function sellInvoice()
    {
        return $this->belongsTo(Sell_invoice::class, 'sell_invoice_id');
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function sellinfo()
    {
        // Assuming 'sell_invoice_id' is the foreign key in customers table pointing to sellinfo table
        return $this->belongsTo(SellInfo::class, 'sell_invoice_id');
    }
}

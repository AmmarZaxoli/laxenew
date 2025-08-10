<?php

namespace App\Models;

use App\Models\Sell_invoice;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';

    protected $fillable = [
        'nameDriver',
        'mobile',
        'numcar',
        'taxiprice',
        'address'
    ];

    public function invoices()
    {
        return $this->hasManyThrough(
            Sell_invoice::class,  // final model we want
            Customer::class,      // intermediate model
            'driver_id',          // Foreign key on customers table
            'id',                 // Foreign key on sell_invoices table (usually id of invoice)
            'id',                 // Local key on drivers table
            'sell_invoice_id' ,
                // Local key on customers table pointing to sell_invoice
        );
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}

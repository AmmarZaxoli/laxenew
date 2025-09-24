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
// Driver.php
public function sellinfos()
{
    // Driver -> Customer -> Sell_invoice -> Sellinfo
    return $this->hasManyThrough(
        \App\Models\Sellinfo::class,  // final model
        \App\Models\Customer::class,  // intermediate
        'driver_id',                   // foreign key on Customer
        'sell_invoice_id',             // foreign key on Sellinfo pointing to Sell_invoice
        'id',                          // local key on Driver
        'sell_invoice_id'              // local key on Customer pointing to Sell_invoice
    );
}

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}

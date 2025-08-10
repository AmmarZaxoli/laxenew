<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sell_invoice extends Model
{
    protected $table = "sell_invoices";
    protected $fillable = [
        'num_invoice_sell',
        'total_price',
        'selling',
        'date_sell',
    ];
    protected $casts = [
        'date_sell' => 'datetime',
    ];

    // Relationship: One invoice has one customer
    public function products()
    {
        return $this->hasMany(SellingProduct::class, 'sell_invoice_id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'sell_invoice_id', 'id');
    }



    public function sell()
    {
        return $this->hasOne(Sellinfo::class, 'sell_invoice_id', 'id');
    }


    public function offersell()
    {
        return $this->hasMany(Offer_sell::class, 'sell_invoice_id', 'id');
    }
    public function sellingProducts()
    {
        return $this->hasMany(SellingProduct::class, 'sell_invoice_id');
    }
}

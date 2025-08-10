<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [

        'quantity',
        'price_sell',
        'definition_id',
    ];
public function latestSubInvoice()
{
    return $this->hasOne(Sub_Buy_Products_invoice::class, 'product_id')->latestOfMany();
}


    public function buy_Products_invoice()
    {

        return $this->belongsTo(Buy_Products_invoice::class,);
    }
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function definition()
    {
        return $this->belongsTo(Definition::class, 'definition_id');
    }
}

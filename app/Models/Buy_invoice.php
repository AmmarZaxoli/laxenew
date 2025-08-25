<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy_invoice extends Model
{
    protected $table = "buy_invoices";
    protected $fillable = ['num_invoice', 'name_invoice', 'datecreate', 'total_price', 'discount', 'cash', 'afterDiscountTotalPrice', 'residual', 'note'];
    protected $casts = [
        'datecreate' => 'datetime',
    ];
    public function products()
    {
        return $this->hasMany(Buy_Products_invoice::class, 'num_invoice_id');
    }
    public function payments()
    {
        return $this->hasMany(Paymentinvoce::class, 'invoce_id');
    }
}

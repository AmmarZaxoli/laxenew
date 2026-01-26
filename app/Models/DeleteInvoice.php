<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeleteInvoice extends Model
{
    protected $fillable = [
        'num_invoice_sell',
        'totalprice',
        'customermobile',
        'address',
        'user',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(DeleteItemInvoice::class, 'sell_invoice_id');
    }
}

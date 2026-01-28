<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeleteInvoice extends Model
{
    protected $fillable = [
        'id_delete_invoices',
        'totalprice',
        'discount',
        'customermobile',
        'address',
        'user',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(DeleteItemInvoice::class, 'id_delete_invoices');
    }
}

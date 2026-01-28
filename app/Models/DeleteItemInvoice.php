<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeleteItemInvoice extends Model
{
    protected $fillable = [
        'id_delete_invoices',
        'product_id',
        'quantity',
        'price',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(DeleteInvoice::class, 'id');
    }

    // OPTIONAL (only if you have products table)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    
}

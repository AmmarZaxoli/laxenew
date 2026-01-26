<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeleteItemInvoice extends Model
{
    protected $fillable = [
        'sell_invoice_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(DeleteInvoice::class, 'sell_invoice_id');
    }

    // OPTIONAL (only if you have products table)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

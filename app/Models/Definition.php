<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Definition extends Model
{
    use HasFactory;

    protected $table = 'definitions';

    protected $fillable = [
        'name',
        'code',
        'barcode',
        'type_id',
        'madin',
        'image',
        'delivery_type',
        'is_active'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}

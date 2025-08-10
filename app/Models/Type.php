<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type  extends Model
{
    use HasFactory;
    protected $table = 'types';

    protected $fillable = ['typename'];

    public function definitions()
    {
        return $this->hasMany(Definition::class, 'type_id');
    }
}

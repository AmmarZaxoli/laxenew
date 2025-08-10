<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;





class Sub_Offer extends Model
{
        protected $table = 'sub_offers';

        protected $fillable = [
                'offer_id',
                'product_id',
                'quantity',
        ];

        public function offer()
        {
                return $this->belongsTo(Offer::class);
        }
        public function product()
        {
                return $this->belongsTo(Product::class);
        }
}

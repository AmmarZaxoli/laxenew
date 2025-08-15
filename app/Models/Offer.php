<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
  protected $table = 'offers';
  protected $fillable = ['nameoffer', 'code', 'price','delivery'];
  public function subOffers()
  {
    return $this->hasMany(Sub_Offer::class);
  }
 public function products()
    {
        return $this->belongsToMany(Product::class, 'sub_offers', 'offer_id', 'product_id')
                   ->withPivot('quantity');
    }
}

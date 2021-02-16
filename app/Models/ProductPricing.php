<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    protected $table = 'product_pricing';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'product_id', 'tag', 'description', 'price', 'currency', 'duration', 'blackout', 'blackout_msg'];

    function getCurrency(){
        return $this->hasOne('App\Models\Currency','id','currency');
    }

    function getTag() {
        return $this->hasOne('App\Models\CategoryTag','id','tag');
    }

    function getTagg($tag_id) {
      return CategoryTag::find($tag_id);
    }

    function getCurr($currency_id) {
      return Currency::find($currency_id);
    }
}

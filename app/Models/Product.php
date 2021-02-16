<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CategoryTag;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'title', 'category', 'country', 'city', 'location', 'start_time', 'end_time', 'supplier'];

    function getDescription(){
        return $this->hasMany('App\Models\ProductDescription','product_id','id');
    }

    function getFirstImage() {
        return $this->hasOne('App\Models\ProductGallery','product_id','id')->latest();
    }

    function getGallery(){
        return $this->hasMany('App\Models\ProductGallery','product_id','id');
    }

    function getPrice(){
        return $this->hasMany('App\Models\ProductPricing','product_id','id');
    }

    function getCategory() {
        return $this->hasOne('App\Models\Category','id','category');
    }

    function getCountry() {
        return $this->hasOne('App\Models\Country','id','country');
    }

    function getCity() {
        return $this->hasOne('App\Models\City','id','city');
    }
}

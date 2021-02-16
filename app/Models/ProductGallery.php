<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = 'product_gallery';
    protected $fillable = ['id', 'product_id', 'path', 'extension'];
    protected $primaryKey = 'id';
}

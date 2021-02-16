<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryTemplate extends Model
{
    //
    protected $table = 'itinerary_template';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'group_id', 'title', 'product_id', 'date_num', 'start_time', 'end_time', 'adults_num', 'children_num', 'created_by'];
}

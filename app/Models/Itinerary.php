<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $table = 'itinerary';
    protected $primaryKey = 'id';

    protected $fillable = ["id", "title", "reference_number", "enquiry_id", "from_email", "to_email", "attach_file", "email_template", "created_id", "updated_id", "account_id", "travel_number", "budget", "currency", "from_date", "to_date", "adult_number", "children_number", "single_count", "double_count", "twin_count", "triple_count", "family_count", "is_assigned", "assigned_user", "note", "status"];
    
    public function get_enquiry() {
        return $this->hasOne('App\Models\Enquiry', 'id', 'enquiry_id');
    }

    public function get_account() {
        return $this->hasOne('App\Models\Account', 'id', 'account_id');
    }
}

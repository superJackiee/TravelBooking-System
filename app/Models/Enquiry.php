<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'enquiry';
    protected $primaryKey = 'id';

    public function get_account() {
        //dd($this->hasOne('App\Models\Account', 'id', 'account_id'));
        return $this->hasOne('App\Models\Account', 'id', 'account_id');
    }

    public function get_created_by() {
        return $this->hasOne('App\Models\Account', 'user_id', 'created_id');
    }

    public function get_updated_by() {
        return $this->hasOne('App\Models\Account', 'user_id', 'updated_id');
    }
}

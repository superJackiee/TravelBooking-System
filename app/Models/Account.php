<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'id';

    public function get_account_type() {
        return $this->hasOne('App\Models\AccountType', 'id', 'account_type');
    }

    public function get_user_info() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function get_country() {
        return $this->hasOne('App\Models\Country', 'id', 'main_country');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    //
    protected $table = 'receivers';

    protected $fillable = [
      'name', 'phone_no', 'address', 'gps', 'cnic', 'tehsil', 'help', 'checked', 'needs',
    ];

    protected $attributes = [
      'help' => false, 'checked' => false, 'needs' => null, 'invalid' => false, 'gps' => 'N/A',
    ];
    protected $hidden = [
        'cnic',
    ];

//  This fixed the need to json decode goods in front-end, check if it works in backend and then you can get rid of using json_decode there
    protected $casts = [

    ];

    public function getNeedsAttribute($value)
    {
        return json_decode($value);
    }

    public function deliveries() {
        return $this->hasMany('App\Models\Delivery', 'receiver_id', 'id');
    }
//    A relationship to get only latest delivery
//    Only to be used in Cron for now
    public function latestDelivery()
    {
        return $this->hasOne('\App\Models\Delivery')->latest();
    }
}

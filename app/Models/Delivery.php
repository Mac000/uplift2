<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $fillable = [
        'user_id', 'receiver_id', 'cost', 'goods', 'image', 'days', 'members',
    ];

    protected $hidden = [
        'updated_at'
    ];

//  This fixed the need to json decode goods in front-end, check if it works in backend and then you can get rid of using json_decode there
    protected $casts = [
    ];

//    protected $dispatchesEvents = [
//        'created' => UserSaved::class,
//    ];

    public function getGoodsAttribute($value)
    {
        return json_decode($value);
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo('App\Models\Receiver', 'receiver_id', 'id');
    }
}

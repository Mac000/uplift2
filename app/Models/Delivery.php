<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $fillable = [
        'user_id', 'cost', 'receiver', 'address', 'phone_no', 'gps', 'goods', 'cnic', 'image', 'tehsil',
    ];

    protected $hidden = [
        'updated_at', 'cnic',
    ];

    protected $casts = [
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->where('receiver', $value)->firstOrFail();
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

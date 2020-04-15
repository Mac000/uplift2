<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ration extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'rations'
    ];

    public function getRationsAttribute($value)
    {
        return json_decode($value);
    }
}

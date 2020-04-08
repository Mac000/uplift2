<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded =[

    ];

    protected $hidden = [
        'created_at', 'updated_at', 'id',
    ];

    protected $casts = [
//        'itemsjson' => 'array',
    ];
    protected $attributes = [

    ];
}

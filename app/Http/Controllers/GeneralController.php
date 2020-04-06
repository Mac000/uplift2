<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function homepage() {

        $people = Delivery::distinct()->count('receiver');
        $people_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->distinct()->count();

        $cost = Delivery::sum('cost');
        $cost_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->sum('cost');

        return view('pages.homepage', [
            'people' => $people,
            'cost' => $cost,
            'people_15' => $people_15,
            'cost_15' => $cost_15,
            ]);
    }
    public function individualData(Request $request) {
        $name = $request['name'];

        $data = Delivery::with(['user' => function($q)
        {
            $q->select('name', 'id');
        }])->where('receiver', $name)->get();
        $created = (bool)$data;
        abort_unless($created, 500, "Failed to fetch Record");
        return $data;
    }
}

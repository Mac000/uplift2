<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Item;
use App\Models\Receiver;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function homepage()
    {

        $people = Delivery::distinct()->count('receiver_id');
        $people_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->distinct()->count('receiver_id');

        $cost = Delivery::sum('cost');
        $cost_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->sum('cost');

        return view('pages.homepage', [
            'people' => $people,
            'cost' => $cost,
            'people_15' => $people_15,
            'cost_15' => $cost_15,
        ]);
    }

    public function individualData(Request $request)
    {
        $name = $request['name'];
        $ids_collection = Receiver::select('id')->where('name', $name)->get();
        /*
         * Getting receiver if to use in below query to fetch all the deliveries of receiver.
         */
        foreach ($ids_collection as $ids) {
            $data = Delivery::with(['user' => function ($q) {
                $q->select('name', 'id');
            }])->with(['receiver' => function ($query) {
                $query->select('id', 'needs', 'name', 'phone_no', 'address', 'gps', 'tehsil');
            }])->where('receiver_id', $ids->id)->get();
        }
//        Consider removing this check, since if its returned empty, front-end will display not found alert
//        $created = (bool)$data;
//        abort_unless($created, 500, "Failed to fetch Record");

//        This is a new hack against the issue of failing when no record was found and $data was undefined.
        if (!isset($data)) {
            $data = [];
            return $data;
        }
        return $data;
    }

    public function allStats()
    {

        $users = User::select('id', 'name', 'tehsil')->paginate(10);
//        $users_stats = collect();
        $stats = collect();
        $array = [];
        foreach ($users as $user) {
            /*
             * Ok, Here's deal, Create a collection of these 4 attributes.
             * Put that collection of 4 attributes into one main collection which should be returned to backend
             * Now, For every user, there will be one key in stats collection which will correspond to the inner collection of stats
             *
             */

            $users_stats = collect();
            $people = Delivery::distinct()->where('user_id', $user->id)->count('receiver_id');
            $users_stats->push($people);

            $people_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->where('user_id', $user->id)
                ->distinct()->count('receiver_id');
            $users_stats->push($people_15);

            $cost = Delivery::where('user_id', $user->id)->sum('cost');
            $users_stats->push($cost);

            $cost_15 = Delivery::where('created_at', '<=', Carbon::now()->subDays(15))->where('user_id', $user->id)->sum('cost');
            $users_stats->push($cost_15);
            $stats->push($users_stats);
        }
        return view('pages.all_stats', [
            'users' => $users,
            'users_stats' => $stats,
        ]);
    }

    public function postItem(Request $request)
    {
        $data = $request->validate([
            'itemsjson' => 'string',
            'members' => 'numeric',
            'days' => 'numeric',
        ]);

        Item::create([
            'items' => $data['itemsjson'],
            'itemsjson' => json_encode($data['itemsjson']),
            'members' => $data['members'],
            'days' => $data['days'],
        ]);
        return redirect()->back();
    }

}

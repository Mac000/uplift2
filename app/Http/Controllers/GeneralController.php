<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Item;
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

    public function postItem(Request $request) {
        $data = $request->validate([
            'itemsjson' => 'string',
            'members' => 'numeric',
            'days' => 'numeric',
        ]);
//        dd($data);
//        dd(json_encode($data['itemsjson']));
        Item::create([
            'items' => $data['itemsjson'],
            'itemsjson' => json_encode($data['itemsjson']),
            'members' => $data['members'],
            'days' => $data['days'],
        ]);
        return redirect()->back();
    }


    public function getItem() {
        /*
         * Query the data from DB
         * Get the items/goods column
         * decode it (assuming its json column and is encoded while storing
         * explode the column into array based on comma to get item/quantity pair
         * create a collection to store the data as key value pair
         * use a while loop and use two indexes, one to correspond to even indexes 0,2,4 to serve as key
         * Second to correspond to odd indexes 1,3,5 to serve as value.
         * strip the stray quotes and commas
         * Push to the collection
         * Compare the collection against a predefined essentials collection
         * While comparing, multiply quantity of essentials with given days and family members to get the right amount
         */

//        Side note: Try using Regex to fix some of idiot user cases like the on in find(2)
//        $items = Item::first();
        $items = Item::find(2);
        $days = $items->days;
        $members = $items->members;
        $items_json = $items->itemsjson;
        $items_json_array = explode(",", $items_json);
        dd($items_json_array);
        $items_json_array = explode(" ", $items_json);
//        dd($days);
//        dd($members);
        $combined = collect();
        $key_iterator = 0;
        $value_iterator = 1;
        while ($key_iterator < sizeof($items_json_array)) {
            $items_json_array[$key_iterator] = str_replace(",", "", $items_json_array[$key_iterator]);
            $items_json_array[$key_iterator] = str_replace('"', "", $items_json_array[$key_iterator]);
            $items_json_array[$key_iterator] = strtolower($items_json_array[$key_iterator]);

            $items_json_array[$value_iterator] = str_replace(",", "", $items_json_array[$value_iterator]);
            $items_json_array[$value_iterator] = str_replace('"', "", $items_json_array[$value_iterator]);
            $items_json_array[$value_iterator] = strtolower($items_json_array[$value_iterator]);
            $combined->put($items_json_array[$key_iterator], $items_json_array[$value_iterator]);

            $key_iterator = $key_iterator + 2;
            $value_iterator = $value_iterator + 2;
        }
//        dd($combined);

        $essentials = collect([
            'flour' => '10kg',
            'oil' => '1ltr',
            'chicken' => '2kg',
            'sugar' => '5kg',
            'ghee' => '1kg',
            'rice' => '2kg',
        ]);
        $units = collect([
            'flour' => 'Kg',
            'oil' => 'Ltr',
            'chicken' => 'Kg',
            'sugar' => 'Kg',
            'ghee' => 'Kg',
            'rice' => 'Kg',
        ]);

        $needs = collect();

        $essentials_keys_only = $essentials->keys();
        $units_keys_only = $units->keys();
        $combined_keys_only = $combined->keys();
        $essentials_length = count($essentials);
//        dd($essentials_keys_only);
        $i = 0;
        foreach ($essentials as $essential) {
//            If the item does not exist, then just skip and increment $i
            if ($combined->has($essentials_keys_only[$i])) {
                $combined_item = $combined->get($essentials_keys_only[$i]);
                $combined_item = preg_replace('/[^0-9]/', '', $combined_item);
                $essential_item = $essentials->get($essentials_keys_only[$i]);
                $essential_item = preg_replace('/[^0-9]/', '', $essential_item);
            //  Multiplying essential quantity to determine needed supplies for a given family and for given days
                $essential_item = ($essential_item * $members) * $days;
                if ($combined_item < $essential_item) {
                    $difference = $essential_item - $combined_item;
            //  Appending unit to item quantity
                    $difference = $difference. $units->get($units_keys_only[$i]);
                    $needs->put($essentials_keys_only[$i], $difference);
                }
            }
            $i++;
        }
//        dd($needs);

        return view('pages.dashboard.get')->with('items', $needs);
    }
}

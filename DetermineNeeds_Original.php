<?php

namespace App\Console\Commands;

use App\Models\Receiver;
use Illuminate\Console\Command;

class DetermineNeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'determine:needs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Determines who needs help and update the database records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $receiver_collection = Receiver::with('deliveries')->where([
            'help'=> false, 'checked' => false,
        ])->get();

        if (!$receiver_collection->isEmpty()) {
            foreach ($receiver_collection as $receiver) {
                // There should only be latest delivery, no point in processing other deliveries. fix the query
                foreach ($receiver->deliveries as $delivery) {
                    $days = $delivery->days;
                    $members = $delivery->members;
                    $items_json = $delivery->goods;

                    $items_json_array = explode(",", $items_json);
                    $items_json_array = explode(" ", $items_json);

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
                        // even indexes = items, odd indexes = quantity
                        $key_iterator = $key_iterator + 2;
                        $value_iterator = $value_iterator + 2;
                    }

                    $essentials = collect([
                        'flour' => '1kg',
                        'oil' => '1ltr',
                        'chicken' => '1kg',
                        'sugar' => '1kg',
                        'ghee' => '1kg',
                        'rice' => '1kg',
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
                    $i = 0;

                    foreach ($essentials as $essential) {
//            If the essential item does not exist, then just skip and increment $i
                        if ($combined->has($essentials_keys_only[$i])) {
                            $combined_item = $combined->get($essentials_keys_only[$i]);
                            // Get the quantity of Receiver item by removing any non-numeric character
                            $combined_item = preg_replace('/[^0-9]/', '', $combined_item);
                            $essential_item = $essentials->get($essentials_keys_only[$i]);
                            // Get the quantity of Essential item by removing any non-numeric character
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
                    $receiver->checked = true;
                    if (!$needs->isEmpty()) {
                        $receiver->help = true;
//                            dd(json_encode($needs));
//                            $receiver->needs = json_encode($needs);
                        $receiver->needs = $needs;
                    }
                    $receiver->save();
                }
            }
        }
    }
}

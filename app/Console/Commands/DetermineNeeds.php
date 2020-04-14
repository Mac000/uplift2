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

//        $receiver_collection = Receiver::with('deliveries')->where([
//            'help'=> false, 'checked' => false,
//        ])->chunk(100, function ($receiver_collection) {

        $receiver_collection = Receiver::with(['latestDelivery'])->where([
            'help'=> false, 'checked' => false,
        ])->chunk(100, function ($receiver_collection) {
                if (!$receiver_collection->isEmpty()) {
                    foreach ($receiver_collection as $receiver) {
                    // There should only be latest delivery, no point in processing other deliveries. fix the query
                        foreach ($receiver->deliveries as $delivery) {
                            $days = $delivery->days;
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
                                'flour' => '350g',
                                'oil' => '70ml',
                                'daal' => '50g',
                                'tea' => '10g',
                                'sugar' => '50g',
                                'milk' => '40g',
                                'rice' => '170g',
                                'salt' => '35g',
                                'redChilli' => '10g',
                                'haldi' => '10g',
                            ]);
                            $units = collect([
                                'flour' => 'Kg',
                                'oil' => 'Ltr',
                                'daal' => 'Kg',
                                'tea' => 'Kg',
                                'sugar' => 'Kg',
                                'milk' => 'Kg',
                                'rice' => 'Kg',
                                'salt' => 'Kg',
                                'redChilli' => 'Lg',
                                'haldi' => 'Kg',
                            ]);

                            $needs = collect();
                            $essentials_keys_only = $essentials->keys();
                            $units_keys_only = $units->keys();
                            $i = 0;

                            foreach ($essentials as $essential) {
                            //  If the essential item does not exist, then just skip and increment $i
                                if ($combined->has($essentials_keys_only[$i])) {
                                    $combined_item = $combined->get($essentials_keys_only[$i]);
                                // Get the quantity of Receiver item by removing any non-numeric character
                                    $combined_item = preg_replace('/[^0-9]/', '', $combined_item);
                                    $essential_item = $essentials->get($essentials_keys_only[$i]);
                                // Get the quantity of Essential item by removing any non-numeric character
                                    $essential_item = preg_replace('/[^0-9]/', '', $essential_item);
                                //  Multiplying essential quantity to determine needed supplies for a given family and for given days
                                    $essential_item = ($essential_item * $days);

                                    if ($combined_item < $essential_item) {
                                    //  Divide by 1000 since all units we have are "g" and "ml"
                                        $difference = ($essential_item - $combined_item) / 1000;
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
        });
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Receiver;
use Carbon\Carbon;
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
     * This command now deals with Precisely determining if someone needs new supplies,
     * If Someone does not need help, it sets the proper attributes,
     * If Someone needs help, it sets the proper attributes
     */

    public function handle()
    {
        $receiver_collection = Receiver::with(['latestDelivery'])->where([
            'help' => false, 'checked' => false,
        ])->chunk(100, function ($receiver_collection) {
            if (!$receiver_collection->isEmpty()) {
                foreach ($receiver_collection as $receiver) {
                    //  As the concern is only with latest delivery so storing latest delivery in $delivery to save shitload of replacements
                    //  If receiver latest delivery is not null, There could be scenarios where receiver doesn't have a delivery
                    if ($receiver->latestDelivery !== NULL) {
                        $delivery = $receiver->latestDelivery;
                        $days = $delivery->days;
                        $members = $delivery->members;
                        $items_json = $delivery->goods;

                        // New code
                        $today = Carbon::now();
                        $today = $today->day;
                        $delivery_date = $delivery->created_at;
                        $delivery_date = Carbon::parse($delivery_date)->day;

                        // If $needs_delivery >= 1, Receiver has run out of supplies

                        $needs_delivery = $today - ($delivery_date+$days);
                        if ($needs_delivery >= 1) {
                            $receiver->checked = true;
                            $receiver->help = true;
                            $receiver->save();
                            return;
                        }

                        $items_json_array = explode(",", $items_json);
                        //  This is to determine if provided goods list was valid or not
                        $items_split_by_comma = $items_json_array;
                        $items_json_array = explode(" ", $items_json);

                        $combined = collect();
                        $key_iterator = 0;
                        $value_iterator = 1;

                        // Size of $items_json_array must be double than $items_json since each item and quantity will be split into array element
                        if ( (sizeof($items_split_by_comma) * 2) === sizeof($items_json_array) ) {
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
                                    $essential_item = ($essential_item * $days * $members);

                                    if ($combined_item < $essential_item) {
                                        //  Divide by 1000 since all units we have are "g" and "ml"
                                        $difference = ($essential_item - $combined_item) / 1000;
                                        //  Appending unit to item quantity
                                        $difference = $difference . $units->get($units_keys_only[$i]);
                                        $needs->put($essentials_keys_only[$i], $difference);
                                    }
                                }
                                $i++;
                            }
                            // If the $needs is empty then set the Receiver attributes to show Help is not needed

                            if ($needs->isEmpty()) {
                                $receiver->help = false;
                                $receiver->needs = NULL;
                                $receiver->save();
                            }
                            // $needs is not empty then set the attributes

                            $receiver->checked = true;
                            $receiver->help = true;
                            $receiver->needs = $needs;
                            $receiver->save();
                        }
                        else {
                            $receiver->invalid = true;
                            $receiver->save();
                        }
                    }
                }
            }
        });
    }
}

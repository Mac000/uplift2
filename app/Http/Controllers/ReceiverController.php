<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Receiver;
use Illuminate\Http\Request;

class ReceiverController extends Controller
{
//    public function determineHelp(\App\Models\Receiver $receiver) {

    public function determineHelp(Receiver $receiver) {
//        $needs = json_decode($receiver->needs);
        $needs = $receiver->needs;
        $invalid = $receiver->invalid;
        /*
         * Tricky hack to make it empty array if needs is null. This will make it work with @empty directive of @forelse
         */

        if ($needs === NULL) {
            $needs = [];
        }
        return view('pages.dashboard.needsHelp')->with('needs', $needs)->with('invalid', $invalid);
    }

    public function viewReceiverData(Receiver $receiver) {
        $data = Delivery::with(['user' => function($q) {
            $q->select('name', 'id');
        }])->with(['receiver' => function ($query) {
            $query->select('name', 'id', 'gps', 'address', 'phone_no');
        }])->where('receiver_id', $receiver->id)->paginate(5);

        return view('pages.dashboard.receiver')->with('data', $data);
    }
}

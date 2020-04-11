<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Receiver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use App\Helpers\validateFile;
use App\Jobs\SetChecked;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DeliveryController extends Controller
{
    public function viewDeliveries() {

    /*  Select only user name from relationship, its compulsory to select the foreign key  */
        // Warn: This will only show deliveries that belong to the current authenticated user
        $deliveries = Delivery::with(['user' => function($q)
        {
            $q->select('name', 'id');
        }])->with(['receiver' => function ($query) {
           $query->select('id', 'name', 'phone_no', 'gps', 'address', 'tehsil');
        }])->where('user_id', Auth::id())->paginate(5);
        return view('pages.dashboard.deliveries')->with('deliveries', [$deliveries]);
    }

    public function newDelivery(Request $request) {
        $user_id = Auth::id();

        $validated = $request->validate([
            'receiver' => 'required|string|max:40',
            'address' => 'required|string|max:100',
            'phone_no' => 'required|digits:11',
            'gps' => 'required|string|max:30',
            'goods' => 'required|string|max:255',
            'cost' => 'numeric|max:15000',
            'cnic' => 'required|digits:13',
            'evidence' => 'required|max:1024|mimes:jpeg,png',
            'tehsil' => 'required|string|max:40',
            'members' => 'required|numeric|max:30',
            'days' => 'required|numeric|max:30',
        ]);

    //  Calling Validate File Upload function
        $validateFile = new validateFile();
        $asset_path = $validateFile->validateFileUpload($request);

        $uploaded = (bool)$asset_path;
        /*  Abort if file upload Fails   */
        if ($uploaded === false) {
            abort(500, "Failed to save Evidence");
        }
        /*
         * Abort if Receiver exists,
         * If does not exist, Create a receiver and create Delivery
         */
        $receiver = Receiver::where('phone_no', $validated['phone_no'])->first();
        if ($receiver !== NULL) {
            abort(500, 'Receiver exists, Please use "Deliver to existing person" form');
        }
        if ($receiver === NULL) {
            $receiver = Receiver::create([
                'name' => $validated['receiver'],
                'phone_no' => $validated['phone_no'],
                'address' => $validated['address'],
                'gps' => $validated['gps'],
                'tehsil' => $validated['tehsil'],
                'cnic' => Crypt::encryptString($validated['cnic']),
            ]);
        }

        $delivery = Delivery::create([
            'user_id' => $user_id,
            'receiver_id' =>$receiver->id,
            'goods'    => json_encode($validated['goods']),
            'cost'     => $validated['cost'],
            'image' => $asset_path,
            'members' => $validated['members'],
            'days' => $validated['days'],
        ]);

        $created = (bool)$delivery;
        // Make a queue to make the receiver available to be processed once the supplies duration has ended
        // Refer to Your phone for details
        if ($created === true) {

            $delayedTill = (integer)$delivery->days;
            $delayedTill = $delayedTill * (24*60);

            $created_at = Carbon::parse($delivery->created_at);
            $created_at = ($created_at->day) * (24*60);

            $delayedTill = $delayedTill + $created_at;
            setChecked::dispatch($receiver->id)->onConnection('database')->delay($delayedTill);
        }
        /*  Abort if Record creation fails   */
        if ($created === false) {
            abort(500, "Failed to create Record");
        }
        Session::flash('success', "Record created successfully!");
        return \Redirect::back();
    }

    public function existingDelivery(Request $request) {

        $validated = $request->validate([
            'receiver' => 'required|string|max:40',
            'phone_no' => 'required|digits:11',
            'goods' => 'required|string|max:255',
            'cost' => 'numeric|max:15000',
            'evidence' => 'required|max:1024|mimes:jpeg,png',
            'members' => 'required|numeric|max:30',
            'days' => 'required|numeric|max:30',
        ]);
        $validateFile = new validateFile();
        $asset_path = $validateFile->validateFileUpload($request);
        $uploaded = (bool)$asset_path;
        /*  Abort if file upload Fails   */
        if ($uploaded === false) {
            abort(500, "Failed to save Evidence");
        }

        $existing_receiver = Receiver::where('phone_no', $validated['phone_no'])->first();
        if ($existing_receiver === NULL) {
            abort(500, "Invalid Existing Receiver Data");
        }

        $delivery = Delivery::create([
            'user_id' => Auth::id(),
            'receiver_id' =>$existing_receiver->id,
            'goods'    => json_encode($validated['goods']),
            'cost'     => $validated['cost'],
            'image' => $asset_path,
            'members' => $validated['members'],
            'days' => $validated['days'],
        ]);

        $created = (bool)$delivery;
        // Make a queue to make the receiver available to be processed once the supplies duration has ended
        // Refer to Your phone for details
        if ($created === true) {

            $delayedTill = (integer)$delivery->days;
            $delayedTill = $delayedTill * (24*60);

            $created_at = Carbon::parse($delivery->created_at);
            $created_at = ($created_at->day) * (24*60);

            $delayedTill = $delayedTill + $created_at;
            setChecked::dispatch($existing_receiver->id)->onConnection('database')->delay($delayedTill);
        }
        /*  Abort if Record creation fails   */
        if ($created === false) {
            abort(500, "Failed to create Record");
        }
        /* Set Help attribute to false of existing receiver after the delivery has been created. Check ur phone for details */
        $existing_receiver->help = false;
        $existing_receiver->save();
        Session::flash('success', "Record created successfully!");
        return \Redirect::back();
    }
}
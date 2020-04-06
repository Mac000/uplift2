<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DeliveryController extends Controller
{
    public function index() {
        /* Select only user name from relationship, its compulsory to select the foreign key */
        $deliveries = Delivery::with(['user' => function($q)
        {
            $q->select('name', 'id');
        }])->paginate(5);
        return view('pages.dashboard.deliveries')->with('deliveries', [$deliveries]);
    }
    public function store(Request $request) {

        $user_id = Auth::id();
        $file = $request->hasFile('evidence');
        abort_unless($file, 500, "Could not detect uploaded Evidence");

        if ( ! ($request->file('evidence')->isValid()) ) {
            //  Aborting if file is not valid
            abort(500, "invalid file, please try again");
        }
        $validated = $request->validate([
            'receiver' => 'required|string|max:40',
            'address' => 'required|string|max:100',
            'phone_no' => 'required|digits:11',
            'gps' => 'required|string|max:30',
            'goods' => 'required|string|max:255',
            'cost' => 'numeric|max:15000',
            'cnic' => 'required|digits:13',
            'evidence' => 'required|max:1024|mimes:jpeg,png',
            'tehsil' => 'required|string|max:40'
        ]);
//        Evidence Handling
        $extension = $request->file('evidence')->extension();
        $today = Carbon::today()->toDateString();
        //  Access user last uploaded file on today, if null, Initialize to 1
        $last_file_number = Delivery::where([
           ['user_id', $user_id],
           ['created_at', '>=', Carbon::today()]
        ])->latest()->first();
        if ($last_file_number === NULL) {
            $last_file_number = 1;
        }
        else {
            /*
             * Exploding an array until we get the file name ONLY
             */

            $last_file_number = explode("/", $last_file_number->image);

            // Splitting into array and grabbing the file name
            $last_file_number = end($last_file_number);

            // Splitting file name into name and extension
            $last_file_number = explode(".", $last_file_number);

            $last_file_number = current($last_file_number);
            // Splitting file to get the last part of file which indicates number of file
            $last_file_number = explode("_", $last_file_number);

            // Incrementing file number to be used for new file upload
            $last_file_number = end($last_file_number) +1;
        }
        $file_name = $user_id.'_'.$today.'_'.$last_file_number.'.'.$extension;
        $uploaded = $request->file('evidence')->storeAs('/public', $file_name);
        $asset_path = 'storage/'.$file_name;
        $evidence_url = asset($file_name);
        $delivery = Delivery::create([
            'user_id' => $user_id,
            'receiver' => $validated['receiver'],
            'address' => $validated['address'],
            'phone_no' => $validated['phone_no'],
            'gps'      => $validated['gps'],
            'goods'    => $validated['goods'],
            'cost'     => $validated['cost'],
            'image' => $asset_path,
            'cnic' => Crypt::encryptString($validated['cnic']),
            'tehsil' => $validated['tehsil'],
        ]);
        $uploaded = (bool)$delivery;
        $created = (bool)$delivery;

    /*  Abort if file upload or record creation fails   */
        if ($uploaded === false || $created === false) {
            abort(500, "Failed to create Record");
        }
        Session::flash('success', "Record created successfully!");
        return \Redirect::back();
    }
    public function viewReceiverData(Delivery $receiver) {
        $data = Delivery::with(['user' => function($q)
        {
            $q->select('name', 'id');
        }])->where('receiver', $receiver->receiver)->paginate(5);
        return view('pages.dashboard.receiver')->with('data', $data);
    }
}
<?php
namespace App\Helpers;

use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class validateFile {

    public function validateFileUpload($request) {
        $user_id = Auth::id();
        $file = $request->hasFile('evidence');
        abort_unless($file, 500, "Could not detect uploaded Evidence");

        if ( ! ($request->file('evidence')->isValid()) ) {
            //  Aborting if file is not valid
            abort(500, "invalid file, please try again");
        }

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

        return $asset_path;
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Receiver;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function myReceivers() {
//        $receivers = Delivery::distinct()->select('receiver')->where('user_id', Auth::id())->get();
        $receivers = Delivery::with('receiver')->distinct()->select( 'receiver_id')->where('user_id', Auth::id())->get();
        return view('pages.dashboard.myReceivers')->with('receivers', $receivers);
    }

    public function dashboard() {
        $user_id =Auth::id();
//        $people = Delivery::distinct()->where('user_id', $user_id )->count('receiver');
        $people = Delivery::distinct()->where('user_id', $user_id)->count('receiver_id');
        $people_15 = Delivery::where([
            ['created_at', '<=', Carbon::now()->subDays(15)],
            ['user_id', $user_id],
        ])->distinct()->count('receiver_id');

        $cost = Delivery::where('user_id', $user_id)->sum('cost');
        $cost_15 = Delivery::where([
            ['created_at', '<=', Carbon::now()->subDays(15)],
            ['user_id', $user_id],
        ])->sum('cost');

        return view('pages.dashboard.dashboard', [
            'people' => $people,
            'cost' => $cost,
            'people_15' => $people_15,
            'cost_15' => $cost_15,
        ]);
    }
    public function updatePhone(Request $request) {
        $validated = $request->validate([
            'phone_no' => 'required|unique:users|digits:11',
            'verify_password' => 'required|string|max:20',
        ]);

        $user = User::find(Auth::id());
        $check = Hash::check($validated['verify_password'], $user->password);
        abort_unless($check, 500, "Incorrect Password, please try again");
        $user->phone_no = $validated['phone_no'];
        $user->save();
        Session::flash('success', "Phone Number Updated successfully!");
        return redirect('/dashboard/settings');
    }
    public function updatePassword(Request $request) {
        $validated = $request->validate([
            'new_password' => 'required|string|max:20',
            'current_password' => 'required|string|max:20',
        ]);
        $user = User::find(Auth::id());
        $check = Hash::check($validated['current_password'], $user->password);
        abort_unless($check, 500, "Incorrect Password, please try again");
        $user->password = Hash::make($validated['new_password']);
        $user->save();
        Session::flash('success', "Password Updated successfully!");
        return redirect('/dashboard/settings');
    }
}

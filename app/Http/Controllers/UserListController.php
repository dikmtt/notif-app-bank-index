<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;

class UserListController extends Controller
{
    public function view() {
        $users = User::select('*')->get();
        return view('userlist', ['user' => $users]);
    }

    public function edituser($user_id) {
        $user = User::select('*')->where('id', $user_id)->get();
        return view('edituser', ['user' => $user]);
    }

    public function updateuser(Request $request) {
        $user = User::select('*')->where('id', $request->user_id)
                ->update(['name' => $request->name,
                        'email' => $request->email,
                        'role' => $request->role]);
        return redirect()->route('userlist');
    }

    public function deleteuser($user_id) {
        $user = User::select('*')->where('id', $user_id)->delete();
        return redirect()->route('userlist');
    }

    public function banuser($user_id) {
        if(Auth::user()->id == $user_id) {
            Session::flash('error', 'You cannot block yourself!');
            return redirect()->route('userlist');
        }
        else {
            $user = User::select('*')->where('id', $user_id)
                ->update(['active' => 0]);
            return redirect()->route('userlist');
        }
    }

    public function unbanuser($user_id) {
        $user = User::select('*')->where('id', $user_id)
            ->update(['active' => 1]);
        return redirect()->route('userlist');
    }
}

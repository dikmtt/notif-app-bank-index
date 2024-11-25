<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Telegram\Bot\Laravel\Facades\Telegram;

class LoginController extends Controller
{
    public function login() {
        if(Auth::check()) {
            return redirect('home');
        } else {
            return view('login');
        }
    }

    public function loginprocess(Request $req) {
        $data = [
            'email' => $req->input('email'),
            'password' => $req->input('password')
        ];

        if(Auth::Attempt($data)) {
            return redirect('home');
        } else {
            Session::flash('error', 'Auth failed');
            return redirect('/');
        }
    }

    public function logoutprocess() {
        Auth::logout();
        return redirect('/');
    }

    public function edit() {
        $user = Auth::user();
        return view('edituserself', ['user' => $user]);
    }

    public function update(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if($request->profile_picture != null) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $imageName);
            $imageNameInDB = 'images/'.$imageName;
        } else {
            $imageNameInDB = null;
        }
        $user->update(['name' => $request->name,
                        'email' => $request->email,
                        'bio' => $request->bio,
                        'profile_picture' => $imageNameInDB]);
        return redirect('settings');
    }
}

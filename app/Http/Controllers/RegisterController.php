<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class RegisterController extends Controller
{
    public function register() {
        return view('register');
    }

    public function newuseradmin() {
        return view('createnewuser');
    }

    public function registerprocess(Request $request) {
        if($request->password == $request->password2) {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'active' => 1
            ]);
            Session::flash('message', 'Registrasi berhasil');
            return redirect('/');
        } else {
            Session::flash('error', 'Passwords do not match');
            return redirect('/');
        }
    }

    public function newuserprocess(Request $request) {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'active' => 1
        ]);
        Session::flash('message', 'User baru berhasil ditambahkan');
        return redirect('userlist');
    }

    public function forgotpass() {
        return view('forgotpass');
    }

    public function forgotpass2(Request $request) {
        if(User::where('email', $request->email)->exists()) {
            return view('forgotpass2', ["email" => $request->email]);
        } else {
            Session::flash('error', 'User with that email is not found!');
            return redirect('forgotpass');
        }
    }

    public function changepass(Request $request) {
        if($request->password == $request->passwordReenter) {
            $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);
            return redirect('/');
        } else {
            Session::flash('error', 'Passwords do not match!');
            return view('forgotpass2', ["email" => $request->email]);
        }
    }
}

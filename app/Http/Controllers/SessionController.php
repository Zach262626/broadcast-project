<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function index() {
        return view('auth.signup');
    }
    public function login() {
        return view('auth.login');
    }

    public function create(Request $request) {
        $atr = [
            'name' => $request['username'],
            'email' => Str::random(10),
            'password' => Str::random(10),
        ];
        //create the user
        $user = User::create($atr);
        //log in
        Auth::login($user);
        //redirect
        return redirect('/');
    }
    public function store(Request $request) {
        $user = User::where('name',$request['username'])->get();
        if (count($user)>0) {
            Auth::login($user[0]);
        }
        request()->session()->regenerate();
        return redirect('/');
    }
    public function destroy() {
        Auth::logout();

        return redirect('/');
     }
}
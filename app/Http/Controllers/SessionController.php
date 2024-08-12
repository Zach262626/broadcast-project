<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /**
     * Display sing-up page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('auth.signup');
    }
    /**
     * Display log-in page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
        return view('auth.login');
    }
    /**
     * Creates a new user
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $user = User::where('name', $request['username'])->get();
        if (count($user) == 0) {
            $atr = [
                'name' => $request['username'],
            ];
            //create the user
            $user = User::create($atr);
            //log in
            Auth::login($user);
        }
        //redirect
        return redirect('/');
    }
    /**
     * Authorize existing user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = User::where('name', $request['username'])->get();
        if (count($user) > 0) {
            Auth::login($user[0]);
        }
        request()->session()->regenerate();
        return redirect('/');
    }
    /**
     * Logout authorized user
     *
     * @param Request $request
     * @return void
     */
    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}

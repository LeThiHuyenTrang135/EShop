<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function checkLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => 2, //tai khoan khach hang
        ];

        $remember = $request->remember;

        if (Auth::attempt($credentials, $remember)){
            return redirect(''); //trangchu
        } else {
            return back()->with('notifications', 'ERROR: Email or password is wrong');
        }
    }

    public function logout()
    {
        Auth::logout();

        return back();
    }
}

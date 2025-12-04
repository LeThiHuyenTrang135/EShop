<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderServiceInterface;
use App\Services\User\UserServiceInterface;
use App\Utilities\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $userService;
    private $orderService;

    public function __construct(UserServiceInterface $userService,
                                OrderServiceInterface $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }
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

         return redirect('/');
    }

     public function Register()
    {
        return view('front.account.register');
    }

    public function postRegister(Request $request)
    {
        if($request->password != $request->password_confirmation){
            return back()->with('notification', 'ERROR: Confire password does not match');

        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => Constant::user_level_client,
        ];

        $this->userService->create($data);

        return redirect('account/login')->with('notification', 'Register Success Please login');
    }

    public function myOrderIndex()
    {

        $orders = $this->orderService->getOrderByUserId(Auth::id());

        return view('front.account.my-order.index', compact('orders'));
    }

    public function myOrderShow($id)
    {
        $order = $this->orderService->find($id);

        return view('front.account.my-order.show', compact('order'));
    }
}

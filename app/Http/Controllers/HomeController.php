<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
   public function home(){

       return view('login');
   }

    public function postLogin(HttpRequest $request){

        $email_login = $request['email_login'];
        $password = $request['password'];

        if (Auth::attempt(['email_login' => $email_login, 'password' => $password]))
        {
            $user = Auth::user();

            if($user->user_type_code_abbr == 'ADMIN'){

                Log::info('here');
                // Authentication passed...
                \Session::flash('success', '登入成功' );
                return redirect()->route('main');
            }

        }

        \Session::flash('error', '帳號密碼錯誤！' );

        return redirect()->back()->withInput();

    }
}

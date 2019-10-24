<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request as HttpRequest;

class CompanyController extends Controller
{
    public function login()
    {
        return view('company.login');
    }

    public function postLogin(HttpRequest $request){

        $email_login = $request['email_login'];
        $password = $request['password'];

        if (Auth::attempt(['email_login' => $email_login, 'password' => $password]))
        {
            $user = Auth::user();

            if($user->user_type_code_abbr == 'CPN'){

                // Authentication passed...
                \Session::flash('success', '登入成功' );
                return redirect()->route('cpn.admin.main');
            }

        }

        \Session::flash('error', '帳號密碼錯誤！' );

        return redirect()->back()->withInput();

    }
}

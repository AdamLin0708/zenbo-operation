<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;

class HomeController extends BackendController
{
    public function main(){
        return view('admin.main');
    }

    public function memberLists(){

        $members = Db::table('usr_user')
            ->select('user_id', 'email_login', 'age', 'gender', 'created_at')
            ->where('user_type_code_abbr', 'ZAPP')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = compact('members');

        return view('admin.memberLists', $data);
    }


}

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

        Log::info('ok');
        return view('admin.main');
    }

}

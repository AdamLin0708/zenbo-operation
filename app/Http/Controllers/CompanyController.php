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


}

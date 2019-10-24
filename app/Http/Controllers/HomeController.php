<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function home(){

        $lectures = DB::table('lct_lecture')
            ->select('lecture_id', 'lecture_hour_type_abbr', 'lecture_hour', 'lecture_name', 'lecture_description',
                'hourly_rate', 'total_price')
            ->get();

        $city_ids = DB::table('lookup_city')->lists('name', 'city_id');
        $district_ids = DB::table('lookup_district')->select('city_id', 'district_id', 'name')->get();
        $district_ids = collect($district_ids)->groupBy('city_id');

        $data = compact('lectures', 'city_ids', 'district_ids');

        return view('home', $data);
   }
}

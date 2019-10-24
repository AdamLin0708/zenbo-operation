<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class BackendController extends Controller
{
    public $user_identity_info;
    public $TEACHER;

    public function __construct()
    {
        $user_id = Auth::user()->user_id;

        $user = DB::table('usr_user')->where('user_id', $user_id)->first();

        $user_identity_info = new \stdClass();
        $user_identity_info->user_id = $user_id;
        $user_identity_info->user_type_code_abbr = $user->user_type_code_abbr;
        $this->user_identity_info = $user_identity_info;

        $teacher = DB::table('tch_teacher_lv')->where('user_id', $user_id)->first();
        $this->TEACHER = $teacher;

        View::share('USER_ID', $this->user_identity_info->user_id);
        View::share('USER_TYPE_CODE_ABBR', $this->user_identity_info->user_type_code_abbr);
    }

    public function main() {
        return view('main');
    }
}

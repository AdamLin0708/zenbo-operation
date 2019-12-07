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

    public function videoAnswerLists($user_id){
        $lists = DB::table('vd_user_video_quiz')
            ->where("user_id", $user_id)
            ->get();

        $output = array();
        foreach ($lists as $list){
            $output[$list->video_specific_id] = array();

            $output[$list->video_specific_id]['total_quiz_num'] = 0;
            $output[$list->video_specific_id]['correct_quiz'] = 0;
        }

        foreach ($lists as $list){
            $output[$list->video_specific_id]['total_quiz_num'] += 1;

            if($list->correct_flag) {
                $output[$list->video_specific_id]['correct_quiz'] += 1;
            }
        }

        $data = compact('output');

        return view('videoAnswerLists', $data);
    }


}

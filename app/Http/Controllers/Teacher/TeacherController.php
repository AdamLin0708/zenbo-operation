<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repo\LectureRepo;
use Illuminate\Http\Request as HttpRequest;
use App\Repo\Contract;
use App\Repo\TeacherRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class TeacherController extends BackendController
{
    public function main(){
        //講座佈告欄

        //講師可承接的講座
        $teacher_lecture_ids = DB::table('tch_teacher_lecture')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->where('active_status_code_abbr', 'VALID')
            ->lists('lecture_id');

        $lecture_requests = DB::table('lct_lecture_request_lv')
            ->where('lecture_payment_status_code_abbr', 'PAID')
            ->whereIn('lecture_id', $teacher_lecture_ids)
            ->whereNull('current_teacher_id')
            ->get();

        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('lecture_requests', 'teacher_id');

        return view('admin.teacher.main', $data);
    }

    public function logout(){
        Auth::logout();

        \Session::flash('success', '您已成功登出！' );

        return redirect()->route('tch.login');
    }

    public function editProfile(){

        $teacher = $this->TEACHER;

        $lectures = DB::table('lct_lecture')->select('lecture_id', 'lecture_name')->get();
        $teacher_lectures = DB::table('tch_teacher_lecture_lv')
            ->where('teacher_id', $teacher->teacher_id)
            ->where('active_status_code_abbr', '!=', 'REMOVED')
            ->lists('lecture_id');

        $data = compact('teacher', 'lectures', 'teacher_lectures');

        return view('admin.teacher.profile', $data);
    }

    public function updateProfile(){

        $request = Request::all();

        $teacher_surname = $request['teacher_surname'];
        $teacher_first_name = $request['teacher_first_name'];
        $gender = $request['gender'];
        $birthday = empty($request['birthday']) ? null : $request['birthday'];
        $job_company_name_1 = $request['job_company_name_1'];
        $job_title_1 = $request['job_title_1'];
        $job_start_date_1 = empty($request['job_start_date_1']) ? null : $request['job_start_date_1'];
        $job_end_date_1 = empty($request['job_end_date_1']) ? null : $request['job_end_date_1'];

        //判斷姓名格式
        if(!(TeacherRepo::is_valid_name_string($teacher_first_name)) || !(TeacherRepo::is_valid_name_string($teacher_surname))){
            \Session::flash('error', '請輸入正確的姓名格式！' );
            return redirect()->back()->withInput();
        }
        if(!TeacherRepo::is_valid_surname_first_name($teacher_surname, $teacher_first_name)){
            \Session::flash('error', '請輸入正確的姓名格式！' );
            return redirect()->back()->withInput();
        }

        //可承接講座至少一個
        if(!isset($request['tch_lectures'])){
            \Session::flash('error', '請至少選擇一個可承接之講座！' );
            return redirect()->back()->withInput();
        }

        DB::table('tch_teacher_profile')->where('teacher_id', $this->TEACHER->teacher_id)->update([
            'surname' => $teacher_surname,
            'first_name' => $teacher_first_name,
            'gender' => $gender,
            'birthday' => $birthday,
            'job_company_name_1' => $job_company_name_1,
            'job_title_1' => $job_title_1,
            'job_start_date_1' => $job_start_date_1,
            'job_end_date_1' => $job_end_date_1,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);


        //原先的tch_lectures
        $old_tch_lectures = DB::table('tch_teacher_lecture')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->where('active_status_code_abbr', '!=', 'REMOVED')
            ->lists('lecture_id');
        $tch_lectures = $request['tch_lectures'];

        //需要變成remove的lecture
        $need_remove_lectures = array_diff($old_tch_lectures, $tch_lectures);
        foreach ($need_remove_lectures as $key => $lecture_id){
            DB::table('tch_teacher_lecture')
                ->where('teacher_id', $this->TEACHER->teacher_id)
                ->where('active_status_code_abbr', '!=', 'REMOVED')
                ->where('lecture_id', $lecture_id)
                ->update([
                    'active_status_code_abbr' => 'REMOVED',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->user_identity_info->user_id
                ]);
        }

        //需要新增的lecture
        $need_insert_lectures = array_diff($tch_lectures, $old_tch_lectures);
        foreach ($need_insert_lectures as $key => $lecture_id){
            DB::table('tch_teacher_lecture')
                ->insert([
                    'teacher_id' => $this->TEACHER->teacher_id,
                    'lecture_id' => $lecture_id,
                    'active_status_code_abbr' => 'INVALID',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->user_identity_info->user_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->user_identity_info->user_id
                ]);
        }


        \Session::flash('success', '更新成功！' );
        return redirect()->back();
    }

    public function requestDetail($lecture_request_id){

        $lecture_request = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();
        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('lecture_request', 'teacher_id');

        return view('admin.teacher.lecture.requestDetail', $data);
    }

    public function acceptLectureRequestByAjax(){
        $request = Request::all();
        $teacher_id = $request['teacher_id'];
        $lecture_request_id = $request['lecture_request_id'];

        //先讓預約單承接成功
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_teacher_id' => $teacher_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        $current_lecture_request = DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->first();
        $current_lecture_request_service = DB::table('lct_lecture_request_service')->where('lecture_request_service_id', $current_lecture_request->current_lecture_request_service_id)->first();

        //創立一筆訂單
        $newLectureOrderId = DB::table('lct_lecture_order')->insertGetId([
            'lecture_request_id' => $lecture_request_id,
            'company_id' => $current_lecture_request->company_id,
            'informal_company_id' => $current_lecture_request->informal_company_id,
            'teacher_id' => $teacher_id,
            'lecture_order_status_code_abbr' => 'CONFIRMED',
            'lecture_address_id' => $current_lecture_request_service->lecture_address_id,
            'lecture_request_service_id' => $current_lecture_request->current_lecture_request_service_id,
            'lecture_order_number' => LectureRepo::genOrderNumber(),
            'total_price' => $current_lecture_request->total_price,
            'created_by' => $this->user_identity_info->user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //更新預約單對到之訂單id
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_lecture_order_id' => $newLectureOrderId,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        $output = '您已成功承接此預約單，請至訂單列表作查詢';
        return \GuzzleHttp\json_encode($output);
    }


}

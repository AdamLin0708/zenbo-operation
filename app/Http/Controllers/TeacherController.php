<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use App\Repo\Contract;
use App\Repo\TeacherRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class TeacherController extends Controller
{
    public function register(){

        $lectures = DB::table('lct_lecture')
            ->select('lecture_id', 'lecture_hour_type_abbr', 'lecture_hour', 'lecture_description',
                'hourly_rate', 'lecture_name')->get();

        $data = compact('lectures');

        return view('teacher.register', $data);
    }

    public function registerPost(){

        $request = Request::all();
        $teacher_surname = $request['teacher_surname'];
        $teacher_first_name = $request['teacher_first_name'];
        $teacher_phone = $request['teacher_phone'];
        $password = $request['password'];
        $password_confirmed = $request['password_confirmed'];

        if(!(TeacherRepo::is_valid_name_string($teacher_first_name)) || !(TeacherRepo::is_valid_name_string($teacher_surname))){
            \Session::flash('error', '請輸入正確的姓名格式' );
            return redirect()->back()->withInput();
        }
        if(!TeacherRepo::is_valid_surname_first_name($teacher_surname, $teacher_first_name)){
            \Session::flash('error', '請輸入正確的姓名格式' );
            return redirect()->back()->withInput();
        }

        if(!isset($request['lecture_ids'])){
            \Session::flash('error', '請至少選擇一項可承接之講座' );
            return redirect()->back()->withInput();
        }

        if(self::checkIfPhoneExist($teacher_phone)){
            \Session::flash('error', '此手機號碼已被使用過，請重新輸入' );
            return redirect()->back()->withInput();
        }

        if($password != $password_confirmed){
            \Session::flash('error', '密碼不一致，請重新輸入' );
            return redirect()->back()->withInput();
        }

        $lecture_ids = $request['lecture_ids'];

        $password_encrypted = \Hash::make($password);

        $user_type_code_abbr = 'TCH';

        //新增teacher

        $newUserId = DB::table('usr_user')->insertGetId([
            'user_type_code_abbr' => $user_type_code_abbr,
            'login_phone_number' => $teacher_phone,
            'password_encrypted' => $password_encrypted,
            'effective_start_date' =>  date('Y-m-d'),
            'created_by' => -1000,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //新增tch_teacher
        $newTeacherId = DB::table('tch_teacher')->insertGetId([
            'user_id' => $newUserId,
            'teacher_status_code_abbr' => 'INVALID',
            'teacher_category_code_abbr' => 'EXTERNAL',
            'created_by' => -1000,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //新增tch_teacher_profile
        DB::table('tch_teacher_profile')->insert([
            'teacher_id' => $newTeacherId,
            'first_name' => $teacher_first_name,
            'surname' => $teacher_surname,
            'created_by' => -1000,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //新增tch_teacher_contract
        $contract = Contract::getCurrentU2TContract();
        DB::table('tch_teacher_contract')->insert([
            'contract_template_u2t_id' => $contract->contract_template_u2t_id,
            'teacher_id' => $newTeacherId,
            'signed_datetime' => date('Y-m-d H:i:s'),
            'created_by' => -1000,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //新增可承接之講座
        foreach ($lecture_ids as $lecture_id){
            DB::table('tch_teacher_lecture')->insert([
                'teacher_id' => $newTeacherId,
                'lecture_id' => $lecture_id,
                'active_status_code_abbr' => 'INVALID',
                'created_by' => -1000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => -1000,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return view('teacher.registerSuccess');

    }

    public function getU2TContractByAjax(){

        $result = json_encode('測試合約');

        return $result;
    }

    public function login(){
        return view('teacher.login');
    }

    public function postLogin(HttpRequest $request){


        $login_phone_number = $request['login_phone_number'];
        $password = $request['password'];

        if (Auth::attempt(['login_phone_number' => $login_phone_number, 'password' => $password]))
        {
            $user = Auth::user();

            if($user->user_type_code_abbr == 'TCH'){

                $teacher_id = DB::table('tch_teacher')
                    ->where('user_id', $user->user_id)
                    ->pluck('teacher_id');
                
                // Authentication passed...
                \Session::flash('success', '登入成功' );
                return redirect()->route('tch.admin.main');
            }

        }

        \Session::flash('error', '帳號密碼錯誤' );

        return redirect()->back()->withInput();
    }

    private function checkIfPhoneExist($phone_number){

        $check = DB::table('usr_user')->where('login_phone_number', $phone_number)
            ->first();

        if(empty($check)){
            return false;
        }

        return true;
    }
}

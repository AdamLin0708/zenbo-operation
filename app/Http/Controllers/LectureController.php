<?php

namespace App\Http\Controllers;

use App\Entity\lct\LectureRequest;
use App\Entity\lct\LectureRequestService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repo\Contract;
use App\Repo\LectureRepo;
use App\Repo\SmsManager;
use App\Utility\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request as HttpRequest;


class LectureController extends Controller
{
    public function createRequest(HttpRequest $request){

        $lecture_id = $request['lecture_id'];
        $lecture_date = $request['lecture_date'];
        $lecture_start_time = $request['lecture_start_time'];
        $lecture_city = $request['lecture_city'];
        $lecture_district = $request['lecture_district'];
        $lecture_address = $request['lecture_address'];
        $company_name = $request['company_name'];
        $company_tax_number = $request['company_tax_number'];
        $company_city = $request['company_city'];
        $company_district = $request['company_district'];
        $company_address = $request['company_address'];
        $contact_surname = $request['contact_surname'];
        $contact_first_name = $request['contact_first_name'];
        $contact_phone = $request['contact_phone'];
        $contact_email = $request['contact_email'];
        $check_if_register = $request['check_if_register'];
        $company_password = $request['company_password'];
        $company_password_confirmed = $request['company_password_confirmed'];
        $payment_gateway = $request['payment_gateway'];
        $u2b_contract = $request['u2b_contract'];
        $lecture_request_question = $request['lecture_request_question'];

        //看看是否需要建立Company帳號
        if(isset($check_if_register)){

            //先建立組織資料
            $validator = Validator::make($request->input(), [
                'contact_email' => 'required|email|unique:usr_user,email_login',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //判斷兩次密碼是否一樣
            if($company_password != $company_password_confirmed){
                \Session::flash('error', '密碼不一致，請確認！' );
                return redirect()->back()->withInput();
            }

            //
            if(!(LectureRepo::is_valid_name_string($contact_first_name)) || !(LectureRepo::is_valid_name_string($contact_surname))){
                \Session::flash('error', '請輸入正確的姓名格式' );
                return redirect()->back()->withInput();
            }
            if(!LectureRepo::is_valid_surname_first_name($contact_surname, $contact_first_name)){
                \Session::flash('error', '請輸入正確的姓名格式' );
                return redirect()->back()->withInput();
            }

            $password_encrypted = \Hash::make($company_password);

            $user_type_code_abbr = 'CPN';

            $existEmails = DB::table('usr_user')->lists('email_login');

            if(!in_array($contact_email, $existEmails)){
                //新增usr_user record

                $newUserId = DB::table('usr_user')->insertGetId([
                    'user_type_code_abbr' => $user_type_code_abbr,
                    'email_login' => $contact_email,
                    'password_encrypted' => $password_encrypted,
                    'effective_start_date' =>  date('Y-m-d'),
                    'created_by' => -1000,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                //新增loc address
                $company_city_info = DB::table('lookup_city')->where('city_id', $company_city)->first();
                $company_district_info = DB::table('lookup_district')->where('district_id', $company_district)->first();
                $contact_address_id = DB::table('loc_address')->insertGetId([
                    'address_type_code_abbr' => 'CPN_CONTACT_ADDRESS',
                    'city_id' => $company_city_info->city_id,
                    'district_id' => $company_district_info->district_id,
                    'city_name' => $company_city_info->name,
                    'zipcode' => $company_district_info->zipcode,
                    'district_name' => $company_district_info->name,
                    'address_1' => $company_address,
                    'created_by' => -1000,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                //新增loc phone
                $contact_phone_id = DB::table('loc_phone')->insertGetId([
                    'phone_type_code_abbr' => 'MOBILE',
                    'phone_number' => $contact_phone,
                    'created_by' => -1000,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                //新增cpn_company
                $newCompany_id = DB::table('cpn_company')->insertGetId([
                    'name' => $company_name,
                    'company_tax_number' => $company_tax_number,
                    'company_status_code_abbr' => 'VALID',
                    'contact_email' => $contact_email,
                    'contact_address_id' => $contact_address_id,
                    'contact_phone_id' => $contact_phone_id,
                    'created_by' => -1000,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                //建立cpn_company_employee
                $newCompany_employee_id = DB::table('cpn_company_employee')->insertGetId([
                    'user_id' => $newUserId,
                    'company_id' => $newCompany_id,
                    'surname' => $contact_surname,
                    'first_name' => $contact_first_name,
                    'created_by' => -1000,
                    'created_at' =>  date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                //回寫company_employee_id
                DB::table('cpn_company')->where('company_id', $newCompany_id)->update([
                    'create_company_employee_id' => $newCompany_employee_id,
                ]);

                //新增cpn_company_contract
                $contract = Contract::getCurrentU2BContract(1);
                DB::table('cpn_company_contract')->insert([
                    'contract_template_u2b_id' => $contract->contract_template_u2b_id,
                    'company_id' => $newCompany_id,
                    'signed_datetime' => date('Y-m-d H:i:s'),
                    'created_by' => -1000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            }

        } else {
            $check_dummy_company = DB::table('cpn_company')->where('company_id', -1000)->first();

            //還沒有建立過dummy 建立cpn_company中的dummy
            if(empty($check_dummy_company)){
                DB::table('cpn_company')->insert([
                    'company_id' => -1000,
                    'company_status_code_abbr' => 'VALID',
                    'created_by' => -1000,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_by' => -1000,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            //建立informal_company
            $informal_company_id = DB::table('cpn_informal_company')->insertGetId([
                'company_id' => -1000,
                'company_tax_number' => $company_tax_number,
                'name' => $company_name,
                'contact_email' => $contact_email,
                'contact_surname' => $contact_surname,
                'contact_first_name' => $contact_first_name,
                'contact_phone' => $contact_phone,
                'contact_city' => $company_city,
                'contact_district' => $company_district,
                'contact_address' => $company_address,
                'created_by' => -1000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => -1000,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            //建立informal_company u2b contract
            //新增cpn_company_contract
            $contract = Contract::getCurrentU2BContract(0);
            DB::table('cpn_company_contract')->insert([
                'contract_template_u2b_id' => $contract->contract_template_u2b_id,
                'informal_company_id' => $informal_company_id,
                'signed_datetime' => date('Y-m-d H:i:s'),
                'created_by' => -1000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => -1000,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        //拿取講座資訊
        $lectureInfo = DB::table('lct_lecture')->where('lecture_id', $lecture_id)->first();

        //建立講座預約單
        $lectureRequest = new LectureRequest();
        $lectureRequest->lecture_id = $lecture_id;
        $lectureRequest->lecture_request_status_code_abbr = 'NEW';
        $lectureRequest->lecture_payment_status_code_abbr = 'UNPAID';
        $lectureRequest->lecture_payment_gateway_code_abbr = $payment_gateway;
        $lectureRequest->lecture_request_number = LectureRepo::genRequestNumber();
        $lectureRequest->total_price = $lectureInfo->total_price;
        $lectureRequest->lecture_request_question = $lecture_request_question;

        if(isset($check_if_register)){
            $lectureRequest->company_id = $newCompany_id;
        } else {
            $lectureRequest->company_id = -1000;
            $lectureRequest->informal_company_id = $informal_company_id;
        }

        $lectureRequest->whocol(-1000, date('Y-m-d H:i:s'), -1000, date('Y-m-d H:i:s'));
        $lectureRequest->save();


        //新增講座服務相關

        //新增loc address
        $lecture_city_info = DB::table('lookup_city')->where('city_id', $lecture_city)->first();
        $lecture_district_info = DB::table('lookup_district')->where('district_id', $lecture_district)->first();
        $lecture_address_id = DB::table('loc_address')->insertGetId([
            'address_type_code_abbr' => 'LCT_LECTURE_ADDRESS',
            'city_id' => $lecture_city_info->city_id,
            'district_id' => $lecture_district_info->district_id,
            'city_name' => $lecture_city_info->name,
            'zipcode' => $lecture_district_info->zipcode,
            'district_name' => $lecture_district_info->name,
            'address_1' => $lecture_address,
            'created_by' => -1000,
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //講座時間
        $lecture_start_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->format('Y-m-d H:i:s');
        $lecture_end_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->addHours($lectureInfo->lecture_hour)->format('Y-m-d H:i:s');

        $lectureRequestService = new LectureRequestService();
        $lectureRequestService->lecture_request_id = $lectureRequest->lecture_id;
        $lectureRequestService->lecture_start_datetime = $lecture_start_datetime;
        $lectureRequestService->lecture_end_datetime = $lecture_end_datetime;
        $lectureRequestService->lecture_address_id = $lecture_address_id;
        $lectureRequestService->whocol(-1000, date('Y-m-d H:i:s'), -1000, date('Y-m-d H:i:s'));
        $lectureRequestService->save();

        $lectureRequest->current_lecture_request_service_id = $lectureRequestService->lecture_request_service_id;
        $lectureRequest->whocol(null, null, -1000, date('Y-m-d H:i:s'));
        $lectureRequest->save();

        $newLectureRequest = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lectureRequest->lecture_request_id)->first();

        if( !LectureRepo::checkIsCreatedByInformalCompany($newLectureRequest) ) {
            $company_info = DB::table('cpn_company_ov')->where('company_id', $newLectureRequest->company_id)->first();
        } else {
            $company_info = DB::table('cpn_informal_company_ov')->where('informal_company_id', $newLectureRequest->informal_company_id)->first();
        }

        if(isset($check_if_register)){
            Mail::setNewLectureRequestMail($newLectureRequest, $newUserId);
        }
        else{
            Mail::setNewLectureRequestMail($newLectureRequest, null);
        }


        \Session::flash('success', '建立成功！' );
        $data = compact('newLectureRequest', 'company_info');
        return view('createLectureRequestSuccess', $data);


    }

    public function searchRequest(){
        return view('searchLectureRequest');
    }

    public function searchRequestPost(){
        $request = Request::all();

        $lecture_request_number = $request['lecture_request_number'];
        $contact_phone = $request['contact_phone'];

        //先找訂單
        $lecture_order = DB::table('lct_lecture_order_lv')
            ->where('lecture_order_number', $lecture_request_number)
            ->where(function ($query) use ($contact_phone){
                $query->where('company_contact_phone', $contact_phone)
                    ->orWhere('informal_company_contact_phone', $contact_phone);
            })
            ->first();

        //再找看看預約單
        $lecture_request = DB::table('lct_lecture_request_lv')
            ->where('lecture_request_number', $lecture_request_number)
            ->where(function ($query) use ($contact_phone){
                $query->where('company_contact_phone', $contact_phone)
                    ->orWhere('informal_company_contact_phone', $contact_phone);
            })
            ->first();

        if(!empty($lecture_order)){
            $output = $lecture_order;
            $data = compact('lecture_order', 'output');
            return view('searchLectureRequestResult', $data);
        }

        if(!empty($lecture_request)){
            $output = $lecture_request;
            $data = compact('lecture_request', 'output');
            return view('searchLectureRequestResult', $data);
        }

        \Session::flash('error', '輸入錯誤，請重新確認預約單編號以及手機是否正確！' );
        return redirect()->back();
    }

    public function test(){
        
    }

    public function getU2BContractByAjax(){

        $request = Request::all();

        $company_name = $request['company_name'];
        $company_register_flag = $request['company_register_flag'];
        $contract = Contract::getCurrentU2BContract($company_register_flag);

        $contract->content = str_replace('%company_name', $company_name, $contract->content);

        $result = json_encode($contract);

        return $result;
    }


    public function cancelLectureRequestByAjax(){

        $request = Request::all();
        $lecture_request_id = $request['lecture_request_id'];

        //更改預約單狀態為取消
        $lectureRequest = LectureRequest::where('lecture_request_id', $lecture_request_id)->first();
        $lectureRequest->lecture_request_status_code_abbr = 'NO_PAID_CANCELED';
        $lectureRequest->whocol(-1000, date('Y-m-d H:i:s'), -1000, date('Y-m-d H:i:s'));
        $lectureRequest->save();


        $output = '您已修改預約單狀態，請確認';
        return \GuzzleHttp\json_encode($output);

    }

    public function getLectureRequestServiceDatetimeByAjax(){

        $request = Request::all();
        $lecture_request_id = $request['lecture_request_id'];

        $lecture_request = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();

        $output['data'] = $lecture_request;
        return \GuzzleHttp\json_encode($output);
    }

    public function rescheduleLectureRequestDatetimeByAjax(){

        $request = Request::all();

        $lecture_date = $request['lecture_date'];
        $lecture_start_time = $request['lecture_start_time'];
        $lecture_request_id = $request['lecture_request_id'];

        if(empty($lecture_date)){
            $output = '請填寫講座日期';
            return response()->json( ['error' => $output], 404 );
        }

        if(empty($lecture_start_time)){
            $output = '請填寫講座時間';
            return response()->json( ['error' => $output], 404 );
        }

        $oldLectureRequest = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();

        $new_lecture_start_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->format('Y-m-d H:i:s');
        $new_lecture_end_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->addHours($oldLectureRequest->lecture_hour)->format('Y-m-d H:i:s');


        //新增新的服務時間
        $newLectureRequestServiceID =   DB::table('lct_lecture_request_service')->insertGetId([
            'lecture_request_id' => $oldLectureRequest->lecture_request_id,
            'lecture_address_id' => $oldLectureRequest->lecture_address_id,
            'lecture_start_datetime' => $new_lecture_start_datetime,
            'lecture_end_datetime' => $new_lecture_end_datetime,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000
        ]);

        //更新lct_lecture_request的資訊
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_lecture_request_service_id' => $newLectureRequestServiceID,
            'lecture_request_status_code_abbr' => 'ORGANIZATION_PAID_RESCHEDULED',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000
        ]);

        $output = '重置講座時間成功，請確認';
        return \GuzzleHttp\json_encode($output);
    }

    public function getLectureOrderServiceDatetimeByAjax(){

        $request = Request::all();
        $lecture_order_id = $request['lecture_order_id'];

        Log::info($lecture_order_id);

        $lecture_order = DB::table('lct_lecture_order_lv')->where('lecture_order_id', $lecture_order_id)->first();

        $output['data'] = $lecture_order;

        return \GuzzleHttp\json_encode($output);
    }

    public function rescheduleLectureOrderDatetimeByAjax(){

        $request = Request::all();

        $lecture_date = $request['lecture_date'];
        $lecture_start_time = $request['lecture_start_time'];
        $lecture_order_id = $request['lecture_order_id'];
        $lecture_request_id = $request['lecture_request_id'];

        if(empty($lecture_date)){
            $output = '請填寫講座日期';
            return response()->json( ['error' => $output], 404 );
        }

        if(empty($lecture_start_time)){
            $output = '請填寫講座時間';
            return response()->json( ['error' => $output], 404 );
        }

        $oldLectureRequest = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();

        $new_lecture_start_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->format('Y-m-d H:i:s');
        $new_lecture_end_datetime = Carbon::createFromFormat('Y-m-d H:i', $lecture_date.' '.$lecture_start_time)->addHours($oldLectureRequest->lecture_hour)->format('Y-m-d H:i:s');

        //新增新的服務時間
        $newLectureRequestServiceID =   DB::table('lct_lecture_request_service')->insertGetId([
            'lecture_request_id' => $oldLectureRequest->lecture_request_id,
            'lecture_address_id' => $oldLectureRequest->lecture_address_id,
            'lecture_start_datetime' => $new_lecture_start_datetime,
            'lecture_end_datetime' => $new_lecture_end_datetime,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => -1000,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000
        ]);

        //更新lct_lecture_order的資訊
        DB::table('lct_lecture_order')->where('lecture_order_id', $lecture_order_id)->update([
            'lecture_order_status_code_abbr' => 'ORGANIZATION_CONFIRMED_RESCHEDULED',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000
        ]);

        $lecture_order = DB::table('lct_lecture_order_lv')->where('lecture_order_id', $lecture_order_id)->first();

        //更新lct_lecture_request的資訊
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_lecture_request_service_id' => $newLectureRequestServiceID,
            'lecture_request_status_code_abbr' => 'PAID',
            'current_lecture_order_id' => null,
            'current_teacher_id' => null,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => -1000
        ]);

        //發送簡訊通知講師，企業已經重置講座時間
        $toSendTeacherUserId = DB::table('tch_teacher_lv')->where('teacher_id', $oldLectureRequest->current_teacher_id)->pluck('user_id');

        $smsManager = new SmsManager();
        $responseContent = $smsManager->sendSmsRescheduleLectureOrderToTeacher($lecture_order, $toSendTeacherUserId);

        $newRequest = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();

        $output['message'] = '重置講座時間成功，訂單將重新張貼至佈告欄，並通知原先講師您已重置原先訂單時間。重置的預約單編號為 '.$newRequest->lecture_request_number.' , 請確認！';
        return \GuzzleHttp\json_encode($output);
    }
}

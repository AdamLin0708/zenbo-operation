<?php

namespace App\Http\Controllers\Company;

use App\Entity\lct\LectureRequest;
use App\Entity\lct\LectureRequestService;
use App\Http\Controllers\Controller;
use App\Repo\LectureRepo;
use App\Repo\SmsManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class OrderController extends BackendController
{
    public function lists(){

        //取出訂單
        $orderLists = DB::table('lct_lecture_order_lv')
                            ->where('company_id', $this->COMPANY->company_id)
                            ->orderBy('lecture_start_datetime')
                            ->get();


        $data = compact('orderLists');

        return view('admin.company.lecture.orderLists', $data);
    }

    public function detail($lecture_order_id){

        $lecture_order = DB::table('lct_lecture_order_lv')->where('lecture_order_id', $lecture_order_id)->first();

        $data = compact('lecture_order');

        return view('admin.company.lecture.orderDetail', $data);

    }

    public function requestLists(){

        //取出未付款預約單
        $requestLists = DB::table('lct_lecture_request_lv')
            ->where('company_id', $this->COMPANY->company_id)
            ->whereNull('current_lecture_order_id')
            ->whereNull('current_teacher_id')
            ->orderBy('lecture_start_datetime')
            ->get();


        $data = compact('requestLists');

        return view('admin.company.lecture.requestLists', $data);
    }

    public function requestDetail($lecture_request_id){

        $lecture_request = DB::table('lct_lecture_request_lv')->where('lecture_request_id', $lecture_request_id)->first();

        $data = compact('lecture_request');

        return view('admin.company.lecture.requestDetail', $data);
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
            'created_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        //更新lct_lecture_request的資訊
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_lecture_request_service_id' => $newLectureRequestServiceID,
            'lecture_request_status_code_abbr' => 'ORGANIZATION_PAID_RESCHEDULED',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        $output = '重置講座時間成功，請確認';
        return \GuzzleHttp\json_encode($output);
    }

    public function getLectureOrderServiceDatetimeByAjax(){

        $request = Request::all();
        $lecture_order_id = $request['lecture_order_id'];

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
            'created_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        //更新lct_lecture_order的資訊
        DB::table('lct_lecture_order')->where('lecture_order_id', $lecture_order_id)->update([
            'lecture_order_status_code_abbr' => 'ORGANIZATION_CONFIRMED_RESCHEDULED',
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        $lecture_order = DB::table('lct_lecture_order_lv')->where('lecture_order_id', $lecture_order_id)->first();

        //更新lct_lecture_request的資訊
        DB::table('lct_lecture_request')->where('lecture_request_id', $lecture_request_id)->update([
            'current_lecture_request_service_id' => $newLectureRequestServiceID,
            'lecture_request_status_code_abbr' => 'PAID',
            'current_lecture_order_id' => null,
            'current_teacher_id' => null,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        //發送簡訊通知講師，企業已經重置講座時間
        $toSendTeacherUserId = DB::table('tch_teacher_lv')->where('teacher_id', $oldLectureRequest->current_teacher_id)->pluck('user_id');

        $smsManager = new SmsManager();
        $responseContent = $smsManager->sendSmsRescheduleLectureOrderToTeacher($lecture_order, $toSendTeacherUserId);

        $output = '重置講座時間成功，訂單將重新張貼至佈告欄，並通知原先講師您已重置原先訂單時間。';
        return \GuzzleHttp\json_encode($output);
    }

    public function createLectureRequest(){

        $lectures = DB::table('lct_lecture')
            ->select('lecture_id', 'lecture_hour_type_abbr', 'lecture_hour', 'lecture_name', 'lecture_description',
                'hourly_rate')
            ->get();

        $city_ids = DB::table('lookup_city')->lists('name', 'city_id');
        $district_ids = DB::table('lookup_district')->select('city_id', 'district_id', 'name')->get();
        $district_ids = collect($district_ids)->groupBy('city_id');

        $data = compact('lectures', 'city_ids', 'district_ids');

        return view('admin.company.lecture.createRequest', $data);
    }

    public function postCreateLectureRequest(){

        $request = Request::all();

        $lecture_id = $request['lecture_id'];
        $lecture_date = $request['lecture_date'];
        $lecture_start_time = $request['lecture_start_time'];
        $lecture_city = $request['lecture_city'];
        $lecture_district = $request['lecture_district'];
        $lecture_address = $request['lecture_address'];
        $lecture_request_question = $request['lecture_request_question'];

        //拿取講座資訊
        $lectureInfo = DB::table('lct_lecture')->where('lecture_id', $lecture_id)->first();

        //建立講座預約單
        $lectureRequest = new LectureRequest();
        $lectureRequest->lecture_id = $lecture_id;
        $lectureRequest->lecture_request_status_code_abbr = 'NEW';
        $lectureRequest->lecture_payment_status_code_abbr = 'UNPAID';
        $lectureRequest->lecture_request_number = LectureRepo::genRequestNumber();
        $lectureRequest->total_price = $lectureInfo->lecture_hour * $lectureInfo->hourly_rate;
        $lectureRequest->lecture_request_question = $lecture_request_question;
        $lectureRequest->company_id = $this->COMPANY->company_id;
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

        $company_info = DB::table('cpn_company_ov')->where('company_id', $this->COMPANY->company_id)->first();


        \Session::flash('success', '建立成功！' );
        $data = compact('newLectureRequest', 'company_info');
        return view('admin.company.lecture.createRequestSuccess', $data);
    }
}

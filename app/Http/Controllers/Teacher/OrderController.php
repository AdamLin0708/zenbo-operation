<?php

namespace App\Http\Controllers\Teacher;

use App\Entity\lct\LectureOrder;
use App\Entity\lct\LectureRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class OrderController extends BackendController
{
    public function deliveredLists(){

        $orderLists = DB::table('lct_lecture_order_lv')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->where('lecture_order_status_code_abbr', 'DELIVERED')
            ->orderBy('lecture_start_datetime')
            ->get();

        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('orderLists', 'teacher_id');

        return view('admin.teacher.lecture.deliveredOrderLists', $data);
    }

    public function detail($lecture_order_id){
        $lecture_order = DB::table('lct_lecture_order_lv')->where('lecture_order_id', $lecture_order_id)->first();
        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('lecture_order', 'teacher_id');

        return view('admin.teacher.lecture.orderDetail', $data);
    }

    public function confirmedLists(){

        $orderLists = DB::table('lct_lecture_order_lv')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->where('lecture_order_status_code_abbr', 'CONFIRMED')
            ->orderBy('lecture_start_datetime')
            ->get();

        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('orderLists', 'teacher_id');

        return view('admin.teacher.lecture.confirmedOrderLists', $data);
    }

    public function inprogressLists(){

        $orderLists = DB::table('lct_lecture_order_lv')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->where('lecture_order_status_code_abbr', 'INPROGRESS')
            ->orderBy('lecture_start_datetime')
            ->get();

        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('orderLists', 'teacher_id');

        return view('admin.teacher.lecture.inprogressOrderLists', $data);
    }

    public function canceledLists(){

        $orderLists = DB::table('lct_lecture_order_lv')
            ->where('teacher_id', $this->TEACHER->teacher_id)
            ->whereNotIn('lecture_order_status_code_abbr', ['INPROGRESS', 'DELIVERED', 'CONFIRMED'])
            ->orderBy('lecture_start_datetime')
            ->get();

        $teacher_id = $this->TEACHER->teacher_id;

        $data = compact('orderLists', 'teacher_id');

        return view('admin.teacher.lecture.canceledOrderLists', $data);
    }

    public function orderCheckinByAjax(){
        $request = Request::all();
        $teacher_id = $request['teacher_id'];
        $lecture_order_id = $request['lecture_order_id'];

        //先更改訂單狀態承接成功
        $lectureOrder = LectureOrder::where('lecture_order_id', $lecture_order_id)->first();
        $lectureOrder->lecture_order_status_code_abbr = 'INPROGRESS';
        $lectureOrder->whocol(-1000, date('Y-m-d H:i:s'), -1000, date('Y-m-d H:i:s'));
        $lectureOrder->save();

        DB::table('lct_lecture_order_delivery')->insert([
            'lecture_order_id' => $lecture_order_id,
            'company_id' => $lectureOrder->company_id,
            'informal_company_id' => $lectureOrder->informal_company_id,
            'teacher_id' => $teacher_id,
            'checkin_datetime' => date('Y-m-d H:i:s'),
            'created_by' => $this->user_identity_info->user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $output = '您已成功簽到，請確認';
        return \GuzzleHttp\json_encode($output);
    }

    public function orderCheckoutByAjax(){
        $request = Request::all();
        $teacher_id = $request['teacher_id'];
        $lecture_order_id = $request['lecture_order_id'];

        //先更改訂單狀態承接成功
        $lectureOrder = LectureOrder::where('lecture_order_id', $lecture_order_id)->first();
        $lectureOrder->lecture_order_status_code_abbr = 'DELIVERED';
        $lectureOrder->whocol(-1000, date('Y-m-d H:i:s'), -1000, date('Y-m-d H:i:s'));
        $lectureOrder->save();

        DB::table('lct_lecture_order_delivery')->where('lecture_order_id', $lectureOrder->lecture_order_id)
            ->update([
                'checkout_datetime' => date('Y-m-d H:i:s'),
                'updated_by' => $this->user_identity_info->user_id,
                'updated_at' => date('Y-m-d H:i:s')
        ]);

        $output = '您已成功簽退，請確認';
        return \GuzzleHttp\json_encode($output);
    }


    public function cancelLectureOrderByAjax(){

        $request = Request::all();
        $lecture_order_id = $request['lecture_order_id'];

        $lecture_order = LectureOrder::where('lecture_order_id', $lecture_order_id)->first();

        $lecture_request = LectureRequest::where('lecture_request_id', $lecture_order->lecture_request_id)->first();
        $lecture_request->current_lecture_order_id = null;
        $lecture_request->current_teacher_id = null;
        $lecture_request->lecture_request_status_code_abbr = 'NEW';
        $lecture_request->whocol(null, null, -1000, date('Y-m-d H:i:s'));
        $lecture_request->save();

        $lecture_order->lecture_order_status_code_abbr = 'TEACHER_CANCELED';
        $lecture_order->whocol(null, null, -1000, date('Y-m-d H:i:s'));
        $lecture_order->save();


        $output = '已成功取消訂單，請確認';
        return \GuzzleHttp\json_encode($output);
    }

}

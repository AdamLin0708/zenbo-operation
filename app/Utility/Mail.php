<?php
/**
 * Created by PhpStorm.
 * User: Alvin
 * Date: 2016/7/18
 * Time: 下午 03:30
 */

namespace App\Utility;

use Mail as Mailling;
use App\Repo\LectureRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Mail
{

    /*------------- Lecture ---------------*/

    public static function setNewLectureRequestMail($request, $user_id = null){
        $mailingTitle = '新講座預約單建立';
        $mailingContent = '新預約單 '. $request->lecture_request_number .' 已建立，請確認後儘速付款！';
        $mailingTypeCodeAbbr = "LECTURE_REQUEST_CREATE";

        Mail::saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $user_id);


        Mailling::send(['html' => 'emails.sendMailTemplate'], ['mailingContent' => $mailingContent], function ($message) use ( $request,$mailingTitle) {
            $message->from('daily_report@ucarer.com.tw', '優照護系統');

            if( !LectureRepo::checkIsCreatedByInformalCompany($request) ) {
                $message->to( $request->company_contact_email);
            }
            else{
                $message->to( $request->informal_company_contact_email);
            }

            $message->subject($mailingTitle);
        });

    }

    public static function saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $user_id = null)
    {
        try {
            DB::table('sys_mailing_content')
                ->insert([
                    'mailing_title' => $mailingTitle,
                    'mailing_content' => $mailingContent,
                    'mailing_type_code_abbr' => $mailingTypeCodeAbbr,
                    'mailing_status' => 'UNSENT',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                ]);
        } catch (\Exception $e) {
            Log::error('Caught exception: '. $e->getMessage(). "\n");
        }
        return;

    }


    /*------------- 先前的code -------------*/

//    public static function setErrorBillingMail($patient, $billing_type, $is_otp_response, $transaction, $errorMsg, $response)
//    {
//        /*
//         * $billing_type 有兩種: BILLING_VALIDATION, ORDER_PAYMENT
//         * $is_otp_response 代表是否為驗證otp的階段
//         */
//
//        /*
//         * 組裝content
//         */
//        $patient_name = $patient->surname.$patient->first_name;
//        $action = '信用卡驗證';
//        $order_number = '無';
//        if($billing_type == 'ORDER_PAYMENT'){
//            $order = DB::table('ord_order')->where('order_id', $transaction->order_id)->first();
//            if(!is_null($order)){
//                $order_number = $order->order_number;
//            }
//            $action = '信用卡付款';
//        }
//        $now = date('Y-m-d H:i:s');
//        $payment_gateway_name = $transaction->trade_type_code_abbr;
//        $transaction_number = $transaction->transaction_number;
//        $response_log =   json_encode($response , JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
//        $stage = '送出信用卡資訊';
//        if($is_otp_response){
//            $stage = '驗證簡訊碼';
//        }
//        $mailingTitle = '[PAYMENT]會員 '.$patient_name. '-'. $action. '失敗 '. $now ;
//        $mailingContent = <<<EOF
//
//        會員: $patient_name \n
//        動作: $action \n
//        訂單編號: $order_number \n
//        時間: $now \n
//        階段: $stage \n
//        渠道: $payment_gateway_name \n
//        錯誤訊息: $errorMsg \n
//        交易編號: $transaction_number \n
//        備註: $response_log \n
//
//EOF;
//
//
//        $mailingTypeCodeAbbr = 'PAYMENT_ERROR_'.$billing_type;
//        $user_id = $patient->user_id;
//        Mail::saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $user_id);
//
//
//    }
//
//    public static function setNewPatientRegisterMail($patient, $user_id)
//    {
//
//        $mailingTitle = '新會員註冊';
//        $mailingContent = $patient->surname . $patient->first_name . '新註冊為會員';
//        $mailingTypeCodeAbbr = "PAPP_NEW_REGISTER";
//
//        Mail::saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $user_id);
//
//    }
//
//    public static function setNewOrderMail($order, $patient, $user_id)
//    {
//        $mailingTitle = '有新預約單建立';
//        $mailingContent = '會員:' . $patient->surname . $patient->first_name . '，建立了新的預約單，' . '訂單編號:' . $order->order_number;
//        $mailingTypeCodeAbbr = 'PAPP_NEW_ORDER';
//
//        Mail::saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $user_id);
//
//    }

//    public static function setEmergencyTriggerMail($caregiver, $order, $emergency_datetime){
//        //寄發信件給工作人員
//        $mailingTitle = "訂單編號-".$order->order_number."使用了緊急機制";
//        $mailingContent = "照護人員".$order->gvr_name." 在 ".$emergency_datetime." 使用了緊急機制"."<table><tr><td>訂單編號</td><td>".$order->order_number."</td></tr><tr><td>照護人員</td><td>".$order->gvr_name.
//            "</td></tr><tr><td>照護人員電話</td><td>".$order->gvr_phone_number."</td></tr><tr>".
//            "<td>服務時段</td><td>".$order->srv_start_datetime." - ".$order->srv_end_datetime."</td></tr><tr>".
//            "<td>服務地點</td><td>".$order->serve_city_name.$order->serve_district_name."</td></tr><tr>".
//            "<td>會員</td><td>".$order->request_patient_name."</td></tr><tr>".
//            "<td>會員電話</td><td>".$order->pt_phone_number."</td></tr><tr>".
//            "<td>緊急連絡人</td><td>".$order->emergency_name."</td></tr><tr>".
//            "<td>緊急連絡人電話</td><td>".$order->emergency_phone_number."</td></tr></table>";
//        $mailingTypeCodeAbbr = "CAPP_EMERGENCY";
//
//        Mail::saveMailToMailingContent($mailingTitle, $mailingContent, $mailingTypeCodeAbbr, $caregiver->caregiver_id);
//    }
}
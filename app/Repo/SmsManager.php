<?php namespace App\Repo;

use App\Entity\usr\User;
use GuzzleHttp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SmsManager
{
  private $account;
  private $pwd;
  private $smsApi;

  function __construct(){
    $this->account = env('SMS_ACCOUNT');
    $this->pwd = env('SMS_PASSWORD');
    $this->smsApi = env('SMS_ENDPOINT');
  }

  public function sendSms($phoneNumber, $message) {
    $client = new GuzzleHttp\Client();
    $message = mb_convert_encoding($message,"Big-5","auto");//fail


    $res = $client->request('GET', $this->smsApi,
      ['query' => ['username' => $this->account, 'password' => $this->pwd, 'dstaddr' => $phoneNumber, 'smbody' => $message, 'dlvtime' => 0]]);


    return $res;
  }

    public function sendSmsRescheduleLectureOrderToTeacher($lecture_order, $user_id){

        /*
         * 功能: 傳送講座訂單修改時間通知到user的手機內
         * input: $user_id
         * output: responseContent
         * assumption: 無
         */

        $user = DB::table('usr_user')->where('user_id', $user_id)->first();

        $phoneNumber = $user->login_phone_number;

        $message = '優健康照護講座通知：親愛的講師您好，由於企業方已更改講座時間，因此講座訂單（'.$lecture_order->lecture_order_number.'）已被取消，請至講座佈告欄重新承接！';

        $response = $this->sendSms($phoneNumber, $message);
        $responseContent = $this->reformatSmsApiResponseContent($response->getBody()->getContents());
        if($response->getStatusCode() == 200 && isset($responseContent['statuscode']) && $responseContent['statuscode'] == 1){
            return $responseContent;
        }else {
            return false;
        }

    }

  public function reformatSmsApiResponseContent($response){
      $responses = explode("\r\n",$response);

      foreach ($responses as $item){
          $tmp = explode("=", $item);
          if(isset($tmp[0]) && isset($tmp[1])){
              $key = $tmp[0];
              $value = $tmp[1];

              $result[$key] = $value;
          }
      }

      return $result;
  }



}
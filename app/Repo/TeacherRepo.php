<?php
/**
 * UCARER CONFIDENTIAL
 * Copyright 2015 優護平台股份有限公司 <http://www.ucarer.tw>
 * All Rights Reserved.
 */
namespace App\Repo;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class TeacherRepo
{

    public static function is_valid_surname_first_name($surname, $first_name){

        $length = strlen($surname);
        if(substr($first_name, 0, $length) === $surname){
            //名字有包含姓，例如 張 張小姐
            //Debugger::errorLog(null, 'is_valid_surname_first_name', $surname.'-'.$first_name);
            return false;
        }
        return true;

    }

    public static function is_valid_name_string($string){
        if(empty($string)){
            return false;
        }
        //ER=>0000713: 提醒會員注册要用實名
        //$standard = "/^([0-9A-Za-z\\p{Han}]+)$/u";
        $standard = "/^\p{Han}+$/u";
        $illegalWordings = [
            '先生',
            '小姐',
            '太太',
            '老師'
        ];
        if(!preg_match($standard, $string, $hereArray)) {
            return false;
        }

        foreach($illegalWordings as $wording){
            if(strpos($string, $wording) !== false){
                return false;
            }
        }

        return true;
    }

}
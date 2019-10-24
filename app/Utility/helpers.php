<?php

function custom_mime_content_type($filename) {

    $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $ext = strtolower(array_pop(explode('.',$filename)));

    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    }

}

function nullIfEmpty($input){
    if(empty($input)){
        return null;
    }
    return $input;
}
function datetimeFormat ($input){
    $weekMaps = [
        0 => '日',
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
    ];
    if(empty($input)){
        return '';
    }
    $output = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input);
    $output = $output->format('Y-m-d H:i'). '('.$weekMaps[$output->dayOfWeek].')';
    return $output;
}
function datetimeToDateFormat ($input){
    $weekMaps = [
        0 => '日',
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
    ];
    if(empty($input)){
        return '';
    }
    $output = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input);
    $output = $output->format('Y-m-d'). '('.$weekMaps[$output->dayOfWeek].')';
    return $output;
}
function datetimeToTimeFormat ($input){
    if(empty($input)){
        return '';
    }
    $output = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input);
    $output = $output->format('H:i');
    return $output;
}
function datetimeParseWeekdayAndTime ($input){
    $weekMaps = [
        0 => '日',
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
    ];
    if(empty($input)){
        return '';
    }
    $output = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input);
    $output_date = $output->format('Y-m-d'). '('.$weekMaps[$output->dayOfWeek].')';
    $output_time = $output->format('H:i');

    return [$output_date, $output_time];
}
function checkIfSpecialChar($title)
{
    $checkNum = false;

    $specialChar = [',',':',';','"'];

    for($i=0;$i<count($specialChar);$i++){
        if(strpos($title, $specialChar[$i])){
            $checkNum = true;
            break;
        }
    }

    return $checkNum;
}

function cusdateFormat ($input){
    $weekMaps = [
        0 => '日',
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
    ];
    if(empty($input)){
        return '';
    }
    $output = \Carbon\Carbon::createFromFormat('Y-m-d', $input);
    $output = $output->format('Y-m-d'). ' ('.$weekMaps[$output->dayOfWeek].')';
    return $output;
}
function cusDateStyle($input){
    if(empty($input)) return '';
    if (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input)->diffInDays(Carbon\Carbon::now(), true) > 14){
        return "style=\"color:red;\"";
    };
    return "";
}
function datetimeToDate ($input){
    if(empty($input)) return '';
    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $input)->format('Y-m-d');
}
function cus_money_format ($input){
    return money_format('%.0n', $input);
}
function integer_format ($input){
    return number_format($input);
}
function reversed_money_format ($input){
    return money_format('%.0n', $input * (-1));
}
function getStandardPriceByTypeAndSeniority($city_id, $caregiver_type_code_abbr, $seniority){
    $standard_price = \DB::table('standard_price')->where('city_id', $city_id)->where('caregiver_type_code_abbr', $caregiver_type_code_abbr)->first();
    if(is_null($standard_price)){
        return null;
    }
    if($seniority == 'SENIOR'){
        return $standard_price->senior_hourly_rate;
    }
    if($seniority == 'JUNIOR'){
        return $standard_price->junior_hourly_rate;
    }

    return $standard_price->hourly_rate;
}

function responseTimeFilter($input) {

    if( is_null($input)){
        return null;
    };

    switch(true) {
        case ($input < 30):
            $output = '0 ~ 30';
            break;
        case ($input < 60):
            $output = '30 ~ 60';
            break;
        case ($input < 90):
            $output = '60 ~ 90';
            break;
        default:
            $output = '90 ~ 120';
    }
    return $output;
}

function genPaymentDateIfSrvEndDatetimeValid($srv_end_datetime, $period){

    /*
     * 功能: 判斷該次服務時間是否在當期服務週期之內
     * input: srv_end_datetime, period
     * output: none
     * assumption: none
     */

    if(datetimeToDate($srv_end_datetime) >= $period->start_date && datetimeToDate($srv_end_datetime) <= $period->end_date){
        return true;
    }
    return false;
}

function priceFormatAmendent($price){
    $output = number_format($price);
    return $output;
}

function percentFloat($float){
    return sprintf("%.2f%%", $float * 100);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
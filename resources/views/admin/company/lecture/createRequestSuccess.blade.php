@extends('admin.company.dashboard')
@section('section')
    <div class="container-fluid text-center">
        <h1>感謝您建立講座預約單，以下是您建立的資訊</h1>
    </div>
    <div class="container-fluid text-center">
        <h2><a class="btn btn-xs btn-danger" href="{{ route('cpn.admin.orderLists') }}">點我查看訂單</a>，或等待3秒後將自動跳轉</h2>
    </div>
    <br><br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                <table class="table table-bordered">
                    <tr>
                        <th class="vertical-align">預約單編號</th>
                        <td>{{ $newLectureRequest->lecture_request_number }}</td>
                        <th class="vertical-align">預約單建立時間</th>
                        <td>{{ datetimeFormat($newLectureRequest->lecture_request_created_datetime) }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座產品</th>
                        <td class="vertical-align">{{ $newLectureRequest->lecture_name }}</td>
                        <th class="vertical-align">講座日期</th>
                        <td class="vertical-align">{{ datetimeToDateFormat($newLectureRequest->lecture_start_datetime) }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座時間</th>
                        <td class="vertical-align">{{ datetimeToTimeFormat($newLectureRequest->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($newLectureRequest->lecture_end_datetime) }}</td>
                        <th class="vertical-align">講座地點</th>
                        <td class="vertical-align">{{ $newLectureRequest->lecture_city_name . $newLectureRequest->lecture_district_name . $newLectureRequest->lecture_address}}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">企業名稱</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->company_name) ? $newLectureRequest->informal_company_name : $newLectureRequest->company_name }}</td>
                        <th class="vertical-align">統一編號</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->company_tax_number) ? $newLectureRequest->informal_company_tax_number : $newLectureRequest->company_tax_number }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">聯絡人姓名</th>
                        <td class="vertical-align">{{ $company_info->contact_surname . $company_info->contact_first_name }}</td>
                        <th class="vertical-align">聯絡人電話</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->informal_company_id) ? $company_info->phone_number : $company_info->contact_phone }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">聯絡人信箱</th>
                        <td class="vertical-align" colspan="3">{{ $company_info->contact_email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function Redirect()
        {

            var orderListsUrl = "<?php echo route('cpn.admin.orderLists')?>";
            window.location = orderListsUrl;
        }
        setTimeout('Redirect()', 3000);
    </script>
@endsection
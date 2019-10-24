@extends('admin.company.dashboard')
@section('page_heading','訂單相關 - 預約單列表')
@section('section')
    <div class="container-fluid">
        <div class="tab-content">
            <table class="table table-bordered" style="margin-top: 30px">
                <thead>
                <tr>
                    <th>#</th>
                    <th>預約單編號</th>
                    <th>預約單狀態</th>
                    <th>付款狀態</th>
                    <th>預約單日期</th>
                    <th>預約單時間</th>
                    <th>預約單費用</th>
                    <th>動作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requestLists as $key => $requestList)
                    <tr>
                        <td style="vertical-align: middle">{{ $key+1 }}</td>
                        <td style="vertical-align: middle">
                            {{ $requestList->lecture_request_number }}
                        </td>
                        <td style="vertical-align: middle">
                            {{ $requestList->lecture_request_status_name }}<br>
                        </td>
                        <td style="vertical-align: middle">
                            {{ $requestList->lecture_payment_status_name }}<br>
                        </td>
                        </td>
                        <td style="vertical-align: middle">
                            {{ datetimeToDateFormat($requestList->lecture_start_datetime) }}
                        </td>
                        <td style="vertical-align: middle">
                            {{ datetimeToTimeFormat($requestList->lecture_start_datetime) }} ~   {{ datetimeToTimeFormat($requestList->lecture_end_datetime) }}
                        </td>
                        <td style="vertical-align: middle">
                            {{ priceFormatAmendent($requestList->total_price) }} $NTD
                        </td>
                        <td style="vertical-align: middle">
                            <a href="{{ route('cpn.admin.requestDetail', $requestList->lecture_request_id) }}" class="btn btn-outline-info"><i class="fa fa-search"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
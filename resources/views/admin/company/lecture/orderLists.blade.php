@extends('admin.company.dashboard')
@section('page_heading','訂單相關 - 訂單列表')
@section('section')
    <div class="container-fluid">
        <div class="tab-content">
            <div id="orderLists" class="tab-pane in active">
                <table class="table table-bordered" style="margin-top: 30px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>訂單編號</th>
                            <th>訂單狀態</th>
                            <th>承接講師</th>
                            <th>訂單日期</th>
                            <th>訂單時間</th>
                            <th>訂單費用</th>
                            <th>動作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orderLists as $key => $orderList)
                        <tr>
                            <td style="vertical-align: middle">{{ $key+1 }}</td>
                            <td style="vertical-align: middle">
                                {{ $orderList->lecture_order_number }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $orderList->lecture_order_status_name }}<br>
                            </td>
                            <td style="vertical-align: middle">
                                {{ $orderList->teacher_surname . $orderList->teacher_first_name }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ datetimeToDateFormat($orderList->lecture_start_datetime) }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ datetimeToTimeFormat($orderList->lecture_start_datetime) }} ~   {{ datetimeToTimeFormat($orderList->lecture_end_datetime) }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ priceFormatAmendent($orderList->total_price) }} $NTD
                            </td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('cpn.admin.orderDetail', $orderList->lecture_order_id) }}" class="btn btn-outline-info" target="_blank"><i class="fa fa-search"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
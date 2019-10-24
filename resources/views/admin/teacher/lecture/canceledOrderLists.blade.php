@extends('admin.teacher.dashboard')
@section('page_heading', '取消之訂單列表')
@section('section')
    <div class="container-fluid">
        @foreach($orderLists as $list)
            <div class="card">
                <div class="card-header">講座訂單編號 - {{ $list->lecture_order_number }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            訂單狀態：{{ $list->lecture_order_status_name }}<br>
                            講座名稱：{{ $list->lecture_name }}<br>
                            講座日期：{{ datetimeToDateFormat($list->lecture_start_datetime) }}<br>
                            講座時間：{{ datetimeToTimeFormat($list->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($list->lecture_end_datetime) }}
                        </div>
                        <br>
                        <div class="col-md-12">
                            <a href="{{ route('tch.admin.orderDetail', $list->lecture_order_id) }}" class="btn btn-primary">查看</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('javascript')
@endsection
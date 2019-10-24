@extends('admin.teacher.dashboard')
@section('page_heading', '講座訂單細節')
@section('section')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @if($lecture_order->lecture_order_status_code_abbr == 'CONFIRMED')
                    <a href="{{ route('tch.admin.confirmedOrderLists') }}" class="btn btn-primary">返回確認單列表</a><br><br>
                @elseif($lecture_order->lecture_order_status_code_abbr == 'INPROGRESS')
                    <a href="{{ route('tch.admin.inprogressOrderLists') }}" class="btn btn-primary">返回進行中單列表</a><br><br>
                @elseif($lecture_order->lecture_order_status_code_abbr == 'DELIVERED')
                    <a href="{{ route('tch.admin.deliveredOrderLists') }}" class="btn btn-primary">返回完成單列表</a><br><br>
                @else
                    <a href="{{ route('tch.admin.canceledOrderLists') }}" class="btn btn-primary">返回取消之訂單列表</a><br><br>
                @endif

                <div class="card">
                    <div class="card-body">
                        講座預約單編號 - {{ $lecture_order->lecture_order_number }}<br>
                        訂單狀態：{{ $lecture_order->lecture_order_status_name }}<br>
                        講座名稱：{{ $lecture_order->lecture_name }}<br>
                        講座地點：{{ $lecture_order->lecture_city_name.$lecture_order->lecture_district_name.$lecture_order->lecture_address }}<br>
                        講座日期：{{ datetimeToDateFormat($lecture_order->lecture_start_datetime) }}<br>
                        講座時間：{{ datetimeToTimeFormat($lecture_order->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($lecture_order->lecture_end_datetime) }}<br>
                        講座費用：{{ priceFormatAmendent($lecture_order->total_price) }} $NTD<br>
                        主辦公司：{{ $lecture_order->company_name ? $lecture_order->company_name : $lecture_order->informal_company_name }}
                    </div>
                </div>

                <br>

                @if($lecture_order->lecture_order_status_code_abbr == 'CONFIRMED')
                    <button type="button" class="btn btn-danger cancel-lecture-order" data-lecture-order-id="{{ $lecture_order->lecture_order_id  }}">取消訂單</button>
                @endif

            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.cancel-lecture-order', function () {

                var lecture_order_id = $(this).data('lecture-order-id');

                var cancelLectureOrderByAjaxUrl = "<?php echo route('tch.admin.cancelLectureOrderByAjax')?>";

                var confirmedCancel = confirm('確定取消訂單?');

                if (confirmedCancel) {
                    $.ajax({
                        type: 'POST',
                        url: cancelLectureOrderByAjaxUrl,
                        data: {
                            'lecture_order_id': lecture_order_id
                        },
                        dataType: 'json',
                        success: function (results) {
                            alert(results);
                            window.location.reload();
                        },
                        error: function (results) {
                            alert(results.responseJSON.error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
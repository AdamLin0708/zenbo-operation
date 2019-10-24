@extends('layouts.scaffold')
@section('section')
@include('partial._company_navbar')
    <div class="container-fluid text-center section-with-top">
        <h2 class="h2-mobile">預約單查詢結果</h1>
    </div>
    <div class="container-fluid desktop-visible">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                <table class="table table-bordered">
                    <tr>
                        <th class="vertical-align">
                            @if(isset($lecture_order))
                                訂單編號
                            @else
                                預約單編號
                            @endif
                        </th>
                        <td>
                            @if(isset($lecture_order))
                                {{ $lecture_order->lecture_order_number }}
                            @else
                                {{ $lecture_request->lecture_request_number }}
                            @endif
                        </td>
                        <th class="vertical-align">建立時間</th>
                        <td>
                            @if(isset($lecture_order))
                                {{ $lecture_order->lecture_order_created_datetime }}
                            @else
                                {{ $lecture_request->lecture_request_created_datetime }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical-align">
                            @if(isset($lecture_order))
                                訂單狀態
                            @else
                                預約單狀態
                            @endif
                        </th>
                        <td>
                            @if(isset($lecture_order))
                                {{ $lecture_order->lecture_order_status_name }}
                            @else
                                {{ $lecture_request->lecture_request_status_name }}
                            @endif
                        </td>
                        <th class="vertical-align">付款狀態</th>
                        <td>
                            @if(isset($lecture_order))
                               已付款
                            @else
                                {{ $lecture_request->lecture_payment_status_name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座產品</th>
                        <td class="vertical-align">{{ $output->lecture_name }}</td>
                        <th class="vertical-align">講座日期</th>
                        <td class="vertical-align">{{ datetimeToDateFormat($output->lecture_start_datetime) }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座時間</th>
                        <td class="vertical-align">{{ datetimeToTimeFormat($output->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($output->lecture_end_datetime) }}</td>
                        <th class="vertical-align">講座地點</th>
                        <td class="vertical-align">{{ $output->lecture_city_name . $output->lecture_district_name . $output->lecture_address}}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">企業名稱</th>
                        <td class="vertical-align">{{ empty($output->company_name) ? $output->informal_company_name : $output->company_name }}</td>
                        <th class="vertical-align">統一編號</th>
                        <td class="vertical-align">{{ empty($output->company_tax_number) ? $output->informal_company_tax_number : $output->company_tax_number }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid mobile-visible">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                <table class="table table-bordered">
                    <tr>
                        <td class="vertical-align">
                            @if(isset($lecture_order))
                                <strong>訂單編號：</strong>{{ $lecture_order->lecture_order_number }}<br>
                            @else
                                <strong>預約單編號：</strong>{{ $lecture_request->lecture_request_number }}<br>
                            @endif
                            <strong>建立時間：</strong>
                                @if(isset($lecture_order))
                                    {{ $lecture_order->lecture_order_created_datetime }}<br>
                                @else
                                    {{ $lecture_request->lecture_request_created_datetime }}<br>
                                @endif
                            @if(isset($lecture_order))
                                <strong>訂單狀態：</strong>{{ $lecture_order->lecture_order_status_name }}<br>
                            @else
                                <strong>預約單狀態：</strong>{{ $lecture_request->lecture_request_status_name }}<br>
                            @endif
                            <strong>付款狀態：</strong>
                                @if(isset($lecture_order))
                                    已付款<br>
                                @else
                                    {{ $lecture_request->lecture_payment_status_name }}<br>
                                @endif
                            <strong>講座產品：</strong>{{ $output->lecture_name }}<br>
                            <strong>講座日期：</strong>{{ datetimeToDateFormat($output->lecture_start_datetime) }}<br>
                            <strong>講座時間：</strong>{{ datetimeToTimeFormat($output->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($output->lecture_end_datetime) }}<br>
                            <strong>講座地點：</strong>{{ $output->lecture_city_name . $output->lecture_district_name . $output->lecture_address}}<br>
                            <strong>企業名稱：</strong>{{ empty($output->company_name) ? $output->informal_company_name : $output->company_name }}<br>
                            <strong>統一編號：</strong>{{ empty($output->company_tax_number) ? $output->informal_company_tax_number : $output->company_tax_number }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                @if(isset($lecture_order))
                    @if($lecture_order->lecture_order_status_code_abbr == 'CONFIRMED')
                        <button type="button" class="btn btn-danger reschedule-lecture-order-datetime" data-lecture-order-id="{{ $lecture_order->lecture_order_id }}" data-lecture-request-id="{{ $lecture_order->lecture_request_id }}">重置訂單時間</button>
                    @endif
                @else
                    @if($lecture_request->lecture_payment_status_code_abbr == 'UNPAID')
                        @if($lecture_request->lecture_request_status_code_abbr == 'NEW')
                            <button type="button" class="btn btn-danger cancel-unpaid-request" data-lecture-request-id="{{ $lecture_request->lecture_request_id  }}">取消預約單</button>
                        @endif
                    @else
                        <button type="button" class="btn btn-danger reschedule-lecture-request-datetime" data-lecture-request-id="{{ $lecture_request->lecture_request_id }}">重置預約單時間</button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-rescheduleLectureRequest" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-left">修改講座時間</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#">
                        {!!csrf_field()!!}
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>講座日期</th>
                                <th>講座開始時間</th>
                            </tr>
                            </thead>
                            <tbody id="table-lecture-service-content-request">

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-primary btn-lg" id="reschedule-lecture-request-btn"/>確認
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-rescheduleLectureOrder" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-left">修改講座時間</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#">
                        {!!csrf_field()!!}
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>講座日期</th>
                                <th>講座開始時間</th>
                            </tr>
                            </thead>
                            <tbody id="table-lecture-service-content-order">

                            </tbody>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h4></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-primary btn-lg" id="reschedule-lecture-order-btn"/>確認
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.cancel-unpaid-request', function () {

                var lecture_request_id = $(this).data('lecture-request-id');

                var cancelLectureRequestByAjaxUrl = "<?php echo route('lct.cancelLectureRequestByAjax')?>";

                var confirmedCancel = confirm('確定取消預約單?');

                if (confirmedCancel) {
                    $.ajax({
                        type: 'POST',
                        url: cancelLectureRequestByAjaxUrl,
                        data: {
                            'lecture_request_id': lecture_request_id
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

        $(document).on('click', '.reschedule-lecture-request-datetime', function() {

            var lecture_request_id = $(this).data("lecture-request-id");
            var getLectureRequestServiceDatetimeByAjaxURL = "<?php echo route('lct.getLectureRequestServiceDatetimeByAjax')?>";

            $(this).button('loading');
            $('#modal-rescheduleLectureRequest').modal('show');

            $.ajax({
                type: 'GET',
                url: getLectureRequestServiceDatetimeByAjaxURL,
                data: {
                    'lecture_request_id': lecture_request_id
                },
                dataType: 'json',
                success: function(results){

                    $('.reschedule-lecture-request-datetime').button('reset');

                    $('#table-lecture-service-content-request').append(
                        "<tr>"+
                        "<td><input type='text' id='lecture_date_1' class='form-control' value="+results.data.lecture_date+"></td>"+
                        "<td><input type='text' id='lecture_start_time_1' class='form-control' value="+results.data.lecture_start_time+"></td>"+
                        "</tr>"
                    );

                    $( function() {

                        $('#lecture_date_1').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            minDate: 'today',
                            dateFormat: 'yy-mm-dd'
                        });

                        $('#lecture_start_time_1').datetimepicker({
                            pickDate: false,
                            format: 'HH:mm',
                        });

                    });
                },
                error: function (results) {
                    alert(results.responseJSON.error);
                    $('.reschedule-lecture-request-datetime').button('reset');
                }
            });

        });

        $('#modal-rescheduleLectureRequest').on('hidden.bs.modal', function (){
            $('#table-lecture-service-content-request').html('');
        });

        $('#reschedule-lecture-request-btn').click(function () {
            rescheduleLectureRequest();
        });

        function rescheduleLectureRequest() {

            var lecture_date = $('#lecture_date_1').val();
            var lecture_start_time = $('#lecture_start_time_1').val();
            var lecture_request_id = $(".reschedule-lecture-request-datetime").data("lecture-request-id");
            var rescheduleLectureRequestDatetimeByAjaxURL = "<?php echo route('lct.rescheduleLectureRequestDatetimeByAjax')?>";

            var confirmedReschedule = confirm('確定要重置講座預約單時間?');
            if(confirmedReschedule){
                $.ajax({
                    type: 'POST',
                    url: rescheduleLectureRequestDatetimeByAjaxURL,
                    data: {
                        'lecture_date': lecture_date,
                        'lecture_start_time' : lecture_start_time,
                        'lecture_request_id': lecture_request_id
                    },
                    dataType: 'json',
                    success: function(results){
                        alert(results);
                        window.location.reload();
                    },
                    error: function (results) {
                        console.log(results.responseJSON.error);
                        alert(results.responseJSON.error);
                    }
                });
            }
        }

        $(document).on('click', '.reschedule-lecture-order-datetime', function() {

            var lecture_order_id = $(this).data("lecture-order-id");
            var getLectureOrderServiceDatetimeByAjaxURL = "<?php echo route('lct.getLectureOrderServiceDatetimeByAjax')?>";

            $(this).button('loading');
            $('#modal-rescheduleLectureOrder').modal('show');

            $.ajax({
                type: 'GET',
                url: getLectureOrderServiceDatetimeByAjaxURL,
                data: {
                    'lecture_order_id': lecture_order_id
                },
                dataType: 'json',
                success: function(results){

                    $('.reschedule-lecture-order-datetime').button('reset');

                    $('#table-lecture-service-content-order').append(
                        "<tr>"+
                        "<td><input type='text' id='lecture_date_2' class='form-control' value="+results.data.lecture_date+"></td>"+
                        "<td><input type='text' id='lecture_start_time_2' class='form-control' value="+results.data.lecture_start_time+"></td>"+
                        "</tr>"
                    );

                    $( function() {

                        $('#lecture_date_2').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            minDate: 'today',
                            dateFormat: 'yy-mm-dd'
                        });

                        $('#lecture_start_time_2').datetimepicker({
                            pickDate: false,
                            format: 'HH:mm',
                        });

                    });
                },
                error: function (results) {
                    alert(results.responseJSON.error);
                    $('.reschedule-lecture-order-datetime').button('reset');
                }
            });

        });

        $('#modal-rescheduleLectureOrder').on('hidden.bs.modal', function (){
            $('#table-lecture-service-content-order').html('');
        });

        $('#reschedule-lecture-order-btn').click(function () {
            rescheduleLectureOrder();
        });

        function rescheduleLectureOrder() {

            var lecture_date = $('#lecture_date_2').val();
            var lecture_start_time = $('#lecture_start_time_2').val();
            var lecture_order_id = $(".reschedule-lecture-order-datetime").data("lecture-order-id");
            var lecture_request_id = $(".reschedule-lecture-order-datetime").data("lecture-request-id");
            var rescheduleLectureOrderDatetimeByAjaxURL = "<?php echo route('lct.rescheduleLectureOrderDatetimeByAjax')?>";
            var searchRequestURL = "<?php echo route('lct.searchRequest')?>";

            var confirmedReschedule = confirm('確定要重置講座訂單時間?');
            if(confirmedReschedule){
                $.ajax({
                    type: 'POST',
                    url: rescheduleLectureOrderDatetimeByAjaxURL,
                    data: {
                        'lecture_date': lecture_date,
                        'lecture_start_time' : lecture_start_time,
                        'lecture_order_id': lecture_order_id,
                        'lecture_request_id': lecture_request_id
                    },
                    dataType: 'json',
                    success: function(results){
                        alert(results.message);
                        window.location.href = searchRequestURL;
                    },
                    error: function (results) {
                        console.log(results.responseJSON.error);
                        alert(results.responseJSON.error);
                    }
                });
            }
        }

    </script>
@endsection
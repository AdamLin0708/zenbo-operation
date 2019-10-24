@extends('admin.company.dashboard')
@section('page_heading', '講座訂單細節')
@section('section')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('cpn.admin.orderLists') }}" class="btn btn-primary">返回訂單列表</a><br><br>
                <div class="card">
                    <div class="card-body">
                        講座預約單編號 - {{ $lecture_order->lecture_order_number }}<br>
                        訂單狀態：{{ $lecture_order->lecture_order_status_name }}<br>
                        講座名稱：{{ $lecture_order->lecture_name }}<br>
                        講座地點：{{ $lecture_order->lecture_city_name.$lecture_order->lecture_district_name.$lecture_order->lecture_address }}<br>
                        講座時間：{{ datetimeToDateFormat($lecture_order->lecture_start_datetime) }} {{ datetimeToTimeFormat($lecture_order->lecture_start_datetime) }}~ {{ datetimeToTimeFormat($lecture_order->lecture_end_datetime) }}<br>
                        講座費用：{{ priceFormatAmendent($lecture_order->total_price) }} $NTD<br>
                    </div>
                </div>

                <br>
                @if($lecture_order->lecture_order_status_code_abbr == 'CONFIRMED')
                    <button type="button" class="btn btn-danger reschedule-lecture-order-datetime" data-lecture-order-id="{{ $lecture_order->lecture_order_id }}" data-lecture-request-id="{{ $lecture_order->lecture_request_id }}">重置訂單時間</button>
                @endif
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
                            <tbody id="table-lecture-service-content">

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
        $(document).on('click', '.reschedule-lecture-order-datetime', function() {

            var lecture_order_id = $(this).data("lecture-order-id");
            var getLectureOrderServiceDatetimeByAjaxURL = "<?php echo route('cpn.admin.getLectureOrderServiceDatetimeByAjax')?>";

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

                    $('#table-lecture-service-content').append(
                        "<tr>"+
                        "<td><input type='text' id='lecture_date' class='form-control' value="+results.data.lecture_date+"></td>"+
                        "<td><input type='text' id='lecture_start_time' class='form-control' value="+results.data.lecture_start_time+"></td>"+
                        "</tr>"
                    );

                    $( function() {

                        $('#lecture_date').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            minDate: 'today',
                            dateFormat: 'yy-mm-dd'
                        });

                        $('#lecture_start_time').datetimepicker({
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
            $('#table-lecture-service-content').html('');
        });

        $('#reschedule-lecture-order-btn').click(function () {
            rescheduleLectureOrder();
        });

        function rescheduleLectureOrder() {

            var lecture_date = $('#lecture_date').val();
            var lecture_start_time = $('#lecture_start_time').val();
            var lecture_order_id = $(".reschedule-lecture-order-datetime").data("lecture-order-id");
            var lecture_request_id = $(".reschedule-lecture-order-datetime").data("lecture-request-id");
            var rescheduleLectureOrderDatetimeByAjaxURL = "<?php echo route('cpn.admin.rescheduleLectureOrderDatetimeByAjax')?>";

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


    </script>
@endsection
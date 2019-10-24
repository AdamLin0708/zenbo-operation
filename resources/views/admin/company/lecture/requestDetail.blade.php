@extends('admin.company.dashboard')
@section('page_heading', '講座預約單細節')
@section('section')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('cpn.admin.requestLists') }}" class="btn btn-primary">返回預約單列表</a><br><br>
                <div class="card">
                    <div class="card-body">
                        講座預約單編號 - {{ $lecture_request->lecture_request_number }}<br>
                        預約單狀態：{{ $lecture_request->lecture_request_status_name }}<br>
                        付款狀態：{{ $lecture_request->lecture_payment_status_name }}<br>
                        講座名稱：{{ $lecture_request->lecture_name }}<br>
                        講座地點：{{ $lecture_request->lecture_city_name.$lecture_request->lecture_district_name.$lecture_request->lecture_address }}<br>
                        講座時間：{{ datetimeToDateFormat($lecture_request->lecture_start_datetime) }} {{ datetimeToTimeFormat($lecture_request->lecture_start_datetime) }}~ {{ datetimeToTimeFormat($lecture_request->lecture_end_datetime) }}<br>
                        講座費用：{{ priceFormatAmendent($lecture_request->total_price) }} $NTD<br>
                    </div>
                </div>
                <br>
                @if($lecture_request->lecture_payment_status_code_abbr == 'UNPAID')
                    @if($lecture_request->lecture_request_status_code_abbr == 'NEW')
                        <button type="button" class="btn btn-danger cancel-unpaid-request" data-lecture-request-id="{{ $lecture_request->lecture_request_id  }}">取消預約單</button>
                    @endif
                @else
                    <button type="button" class="btn btn-danger reschedule-lecture-request-datetime" data-lecture-request-id="{{ $lecture_request->lecture_request_id }}">重置預約單時間</button>
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
                            <tbody id="table-lecture-service-content">

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
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.cancel-unpaid-request', function() {

                var lecture_request_id = $(this).data('lecture-request-id');

                var cancelLectureRequestByAjaxUrl = "<?php echo route('cpn.admin.cancelLectureRequestByAjax')?>";

                var confirmedCancel = confirm('確定取消預約單?');

                if(confirmedCancel){
                    $.ajax({
                        type: 'POST',
                        url: cancelLectureRequestByAjaxUrl,
                        data: {
                            'lecture_request_id': lecture_request_id
                        },
                        dataType: 'json',
                        success: function(results){
                            alert(results);
                            window.location.reload();
                        },
                        error: function (results) {
                            alert(results.responseJSON.error);
                        }
                    });
                }
            });

            $(document).on('click', '.reschedule-lecture-request-datetime', function() {

                var lecture_request_id = $(this).data("lecture-request-id");
                var getLectureRequestServiceDatetimeByAjaxURL = "<?php echo route('cpn.admin.getLectureRequestServiceDatetimeByAjax')?>";

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
                        $('.reschedule-lecture-request-datetime').button('reset');
                    }
                });

            });

            $('#modal-rescheduleLectureRequest').on('hidden.bs.modal', function (){
                $('#table-lecture-service-content').html('');
            });

            $('#reschedule-lecture-request-btn').click(function () {
                rescheduleLectureRequest();
            });

            function rescheduleLectureRequest() {

                var lecture_date = $('#lecture_date').val();
                var lecture_start_time = $('#lecture_start_time').val();
                var lecture_request_id = $(".reschedule-lecture-request-datetime").data("lecture-request-id");
                var rescheduleLectureRequestDatetimeByAjaxURL = "<?php echo route('cpn.admin.rescheduleLectureRequestDatetimeByAjax')?>";

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

        });
    </script>
@endsection
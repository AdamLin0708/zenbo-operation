@extends('admin.teacher.dashboard')
@section('page_heading', '講座預約單細節')
@section('section')
    <div class="container-fluid">
        <a href="{{ route('tch.admin.main') }}" class="btn btn-primary">返回講座佈告欄</a><br><br>
        <div class="row">
            <div class="col-md-12">

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        講座預約單編號：{{ $lecture_request->lecture_request_number }}<br>
                        講座名稱：{{ $lecture_request->lecture_name }}<br>
                        講座地點：{{ $lecture_request->lecture_city_name.$lecture_request->lecture_district_name.$lecture_request->lecture_address }}<br>
                        講座日期：{{ datetimeToDateFormat($lecture_request->lecture_start_datetime) }}<br>
                        講座時間：{{ datetimeToTimeFormat($lecture_request->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($lecture_request->lecture_end_datetime) }}<br>
                        講座費用：$NTD {{ $lecture_request->lecture_hour * $lecture_request->hourly_rate }}<br>
                        主辦公司：{{ $lecture_request->company_name }}
                        <hr>
                        <button class="btn btn-danger btn-block accept-lecture-request" data-lecture-request-id="{{ $lecture_request->lecture_request_id }}"
                                data-teacher-id="{{ $teacher_id }}">我要承接</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.accept-lecture-request', function() {

                var lecture_request_id = $(this).data('lecture-request-id');
                var teacher_id = $(this).data('teacher-id');

                var acceptLectureRequestByAjaxUrl = "<?php echo route('tch.admin.acceptLectureRequestByAjax')?>";
                var mainUrl = "<?php echo route('tch.admin.main')?>";

                var confirmedAccept = confirm('確定承接?');

                if(confirmedAccept){
                    $.ajax({
                        type: 'POST',
                        url: acceptLectureRequestByAjaxUrl,
                        data: {
                            'lecture_request_id': lecture_request_id,
                            'teacher_id': teacher_id
                        },
                        dataType: 'json',
                        success: function(results){
                            alert(results);
                            window.location.replace(mainUrl);
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
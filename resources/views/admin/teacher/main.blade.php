@extends('admin.teacher.dashboard')
@section('page_heading', '講座佈告欄')
@section('section')
    <div class="container-fluid">
        @foreach($lecture_requests as $request)
            <div class="card">
                <div class="card-header">講座預約單編號 - {{ $request->lecture_request_number }}</div>
                <div class="card-body">
                    講座名稱：{{ $request->lecture_name }}<br>
                    講座地點：{{ $request->lecture_city_name.$request->lecture_district_name.$request->lecture_address }}<br>
                    講座日期：{{ datetimeToDateFormat($request->lecture_start_datetime) }}<br>
                    講座時間：{{ datetimeToTimeFormat($request->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($request->lecture_end_datetime) }}<br>
                    講座費用：{{ priceFormatAmendent($request->total_price) }} $NTD<br><br>
                    <a href="{{ route('tch.admin.requestDetail', $request->lecture_request_id) }}" class="btn btn-primary">查看</a>
                    <button type="button" class="btn btn-danger accept-lecture-request" data-lecture-request-id="{{ $request->lecture_request_id }}"
                        data-teacher-id="{{ $teacher_id }}">我要承接</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.accept-lecture-request', function() {

                var lecture_request_id = $(this).data('lecture-request-id');
                var teacher_id = $(this).data('teacher-id');

                var acceptLectureRequestByAjaxUrl = "<?php echo route('tch.admin.acceptLectureRequestByAjax')?>";

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
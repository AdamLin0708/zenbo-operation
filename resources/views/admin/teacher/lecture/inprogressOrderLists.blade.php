@extends('admin.teacher.dashboard')
@section('page_heading', '進行中單列表')
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
                            <button class="btn btn-danger order-checkout" data-lecture-order-id="{{ $list->lecture_order_id }}"
                                    data-teacher-id="{{ $teacher_id }}">簽退</button>
                            <a href="{{ route('tch.admin.orderDetail', $list->lecture_order_id) }}" class="btn btn-primary">查看</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('javascript')
    <script>
        $( document ).ready(function() {
            $(document).on('click', '.order-checkout', function() {

                var lecture_order_id = $(this).data('lecture-order-id');
                var teacher_id = $(this).data('teacher-id');

                var checkoutByAjaxURL = "<?php echo route('tch.admin.orderCheckoutByAjax')?>";

                if(confirm('確定簽退?')){
                    $.ajax({
                        type: 'POST',
                        url: checkoutByAjaxURL,
                        data: {
                            'lecture_order_id': lecture_order_id,
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
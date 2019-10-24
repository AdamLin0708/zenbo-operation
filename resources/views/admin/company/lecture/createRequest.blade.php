@extends('admin.company.dashboard')
@section('page_heading','建立講座預約單')
@section('section')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3-mobile">講座預約單申請表單</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cpn.admin.postCreateLectureRequest') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <h3 class="col-md-10 offset-md-1">選擇講座產品</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>勾選</th>
                                            <th>產品</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lectures as $key => $lecture)
                                            <tr>
                                                <td class="vertical-middle text-center"><input type="radio" name="lecture_id" value="{{ $lecture->lecture_id }}" required></td>
                                                <td>{{ $lecture->lecture_name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h3 class="col-md-10 offset-md-1">填寫講座細節</h3>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10 offset-md-1">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="vertical-middle">*講座日期</th>
                                            <td>
                                                <input type="text" class="form-control" name="lecture_date" id="lecture_date" value="{{ old('lecture_date') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="vertical-middle">*講座開始時間</th>
                                            <td>
                                                <input type="text" class="form-control" name="lecture_start_time" id="lecture_start_time" value="{{ old('lecture_start_time') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="vertical-middle">*縣市</th>
                                            <td>
                                                {!!  Form::select('lecture_city', $city_ids, null, ['id' => 'lecture_city', 'placeholder' => '請選擇...', 'required' => true, 'class' => 'form-control']) !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="vertical-middle">*行政區</th>
                                            <td>
                                                <select class="lecture_select_area form-control" name="lecture_district" id="lecture_district" required>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="vertical-middle">*地址</th>
                                            <td>
                                                <input class="form-control" type="text" name="lecture_address" value="{{ old('lecture_address') }}" required>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <h3 class="col-md-10 offset-md-1">我有問題想問問</h3>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10 offset-md-1">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="vertical-middle" >至多500字</th>
                                            <td>
                                                <textarea class="form-control" rows="4" style="resize: none" name="lecture_request_question"></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">確認送出</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>

        var district_ids = {!! json_encode($district_ids->toArray()) !!};

        $( "#lecture_city" ).change(function() {
            var val = $('#lecture_city').val();
            $('#lecture_district').html('');
            if(val !== ''){
                district_ids[val].forEach(function (item) {
                    $('#lecture_district').append('<option value="'+item.district_id+'">' + item.name + '</option>');
                });
            }
            else{
                $('#lecture_district').append('<option value="">請選擇...</option>');
            }
        });

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

        $('#lecture_end_time').datetimepicker({
            pickDate: false,
            format: 'HH:mm',
        });

    </script>
@endsection
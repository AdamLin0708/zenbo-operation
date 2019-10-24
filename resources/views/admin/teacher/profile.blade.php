@extends('admin.teacher.dashboard')
@section('page_heading','講師資料 - 基本資料修改')
@section('section')
    <div class="container-fluid">
        <form class="form-horizontal" action="{{ route('tch.admin.updateProfile') }}" method="post" enctype="multipart/form-data" novalidate>
            {{ csrf_field() }}
            <h2 class="h2-mobile">基本資料</h2>
            <div class="form-group row">
                <label for="teacher_surname" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">姓氏：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->teacher_surname }}" name="teacher_surname">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label for="teacher_first_name" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">名字：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->teacher_first_name }}" name="teacher_first_name">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">性別：</label>
                <div class="col-md-2 col-sm-12">
                    <select name="gender" class="form-control">
                        @if($teacher->gender == 'MALE')
                            <option value="MALE" selected>男</option>
                            <option value="FEMALE">女</option>
                        @elseif($teacher->gender == 'FEMALE')
                            <option value="MALE">男</option>
                            <option value="FEMALE" selected>女</option>
                        @else
                            <option value="">請選擇</option>
                            <option value="MALE">男</option>
                            <option value="FEMALE">女</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label for="birthday" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">生日：</label>
                <div class="col-md-2 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->birthday }}" name="birthday" id="birthday">
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label  class="col-md-3 col-sm-12 col-12 m-auto form-label-align">可承接之講座：</label>
                <div class="col-md-9"></div>
            </div>
            <div class="form-group row">
                <div class="col-md-10 offset-md-2 col-sm-12">
                    @foreach($lectures as $lecture)
                        <input tabindex="1" type="checkbox" name="tch_lectures[]" id="tch_lectures" value="{{$lecture->lecture_id}}"
                                {{in_array($lecture->lecture_id, $teacher_lectures) ? "checked" : ""}}> {{$lecture->lecture_name}}<br>
                    @endforeach
                </div>
            </div>
            <div class="form-group row">
                <label for="login_phone_number" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">手機號碼：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->login_phone_number }}" name="login_phone_number" readonly="">
                </div>
                <div class="col-md-4"></div>
            </div>
            <h2 class="h2-mobile">經歷</h2>
            <div class="form-group row">
                <label for="experience" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">公司 / 所屬機構：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->job_company_name_1 }}" name="job_company_name_1" id="job_company_name_1" placeholder="請填寫機構">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">職稱：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->job_title_1 }}" name="job_title_1" id="job_title_1" placeholder="請填寫職稱">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label for="job_start_date_1" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">工作開始日期：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->job_start_date_1 }}" name="job_start_date_1" id="job_start_date_1">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label for="job_end_date_1" class="col-md-3 col-sm-12 col-12 m-auto form-label-align">工作結束日期：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $teacher->job_end_date_1 }}" name="job_end_date_1" id="job_end_date_1">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="col-lg-12  text-center">
                <button type="submit" class="btn btn-primary" style="margin-top: 10px">儲存</button>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
    <script>
        $('#birthday').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1950:2019',
            maxDate: 'today',
            dateFormat: 'yy-mm-dd'
        });

        $('#job_start_date_1').datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: 'today',
            dateFormat: 'yy-mm-dd'
        });

        $('#job_end_date_1').datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: 'today',
            dateFormat: 'yy-mm-dd'
        });
    </script>
@endsection
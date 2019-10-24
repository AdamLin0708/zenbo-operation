@extends('layouts.scaffold')
@section('section')
@include('partial._teacher_navbar')

    <div class="container-fluid text-center section-with-top">
        <h1>講師註冊</h1>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <p>申請成為優健康照護講座之講師</p>
            </div>
            <div class="col-md-12 text-center">
                <h3 class="h3-mobile"><img src="/img/star_icon.png" style="width: 15px;"> 凡附有星星符號為必填</h3>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                <div class="card">
                    <div class="card-body padding-0">
                        <form action="{{  route('tch.registerPost') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">填寫講師資料</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 講師姓氏</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="teacher_surname" value="{{ old('teacher_surname') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 講師名字</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="teacher_first_name" id="teacher_first_name" value="{{ old('teacher_first_name') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 手機號碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="teacher_phone" id="teacher_phone" value="{{ old('teacher_phone') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 密碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="password" name="password" value="{{ old('password') }}" id="password">
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 確認密碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="password" name="password_confirmed"  value="{{ old('password_confirmed') }}" id="password_confirmed">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">可承接之講座</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-12 list-padding">
                                                @foreach($lectures as $lecture)
                                                    <input tabindex="1" type="checkbox" name="lecture_ids[]" id="lecture_id" value="{{$lecture->lecture_id}}"> {{$lecture->lecture_name}}<br>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">合約相關</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding">合約 <button type="button" class="center-block btn btn-brand btn-sm get-u2t-contract">查看</button></div>
                                            <div class="col-md-9 list-padding">
                                                <input type="checkbox" name="u2t_contract" id="u2t_contract" value="1" required> 是否同意合約?
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-brand">確認送出</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-u2t-contract" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title"></span>講師與優照護之合約</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="u2t-contract-content">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>

        $(document).ready(function() {

            $('div[data-name="nav-teacher-register"]').addClass('nav-active');

            $(document).on('click', '.get-u2t-contract', function() {
                var u2bContractUrl = "<?php echo route('tch.getU2TContractByAjax')?>";
                var company_name = $("#company_name").val();

                $(this).button('loading');

                $.ajax({
                    type: 'GET',
                    url: u2bContractUrl,
                    data: {
                        'company_name': company_name
                    },
                    dataType: 'json',
                    success: function(result){
                        console.log(result);
                        $('#u2t-contract-content').append(
                            result
                        );
                        $('#modal-u2t-contract').modal('show');
                        $('.get-u2t-contract').button('reset');
                    }
                });
            });

        });
    </script>
@endsection
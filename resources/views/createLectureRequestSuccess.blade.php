@extends('layouts.scaffold')
@section('section')
@include('partial._company_navbar')
    <div class="container-fluid text-center section-with-top">
        <h2 class="h2-mobile">感謝您建立講座預約單，以下是您建立的資訊</h2>
    </div>
    <br><br>
    <div class="container-fluid desktop-visible">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-sm-10 offset-sm-1">
                <table class="table table-bordered">
                    <tr>
                        <th class="vertical-align">預約單編號</th>
                        <td>{{ $newLectureRequest->lecture_request_number }}</td>
                        <th class="vertical-align">預約單建立時間</th>
                        <td>{{ datetimeFormat($newLectureRequest->lecture_request_created_datetime) }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座產品</th>
                        <td class="vertical-align">{{ $newLectureRequest->lecture_name }}</td>
                        <th class="vertical-align">講座日期</th>
                        <td class="vertical-align">{{ datetimeToDateFormat($newLectureRequest->lecture_start_datetime) }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">講座時間</th>
                        <td class="vertical-align">{{ datetimeToTimeFormat($newLectureRequest->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($newLectureRequest->lecture_end_datetime) }}</td>
                        <th class="vertical-align">講座地點</th>
                        <td class="vertical-align">{{ $newLectureRequest->lecture_city_name . $newLectureRequest->lecture_district_name . $newLectureRequest->lecture_address}}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">企業名稱</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->company_name) ? $newLectureRequest->informal_company_name : $newLectureRequest->company_name }}</td>
                        <th class="vertical-align">統一編號</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->company_tax_number) ? $newLectureRequest->informal_company_tax_number : $newLectureRequest->company_tax_number }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">聯絡人姓名</th>
                        <td class="vertical-align">{{ $company_info->contact_surname . $company_info->contact_first_name }}</td>
                        <th class="vertical-align">聯絡人電話</th>
                        <td class="vertical-align">{{ empty($newLectureRequest->informal_company_id) ? $company_info->phone_number : $company_info->contact_phone }}</td>
                    </tr>
                    <tr>
                        <th class="vertical-align">聯絡人信箱</th>
                        <td class="vertical-align">{{ $company_info->contact_email }}</td>
                        <th class="vertical-align">是否有建立帳號？</th>
                        <td class="vertical-align">
                            {{ empty($newLectureRequest->informal_company_id) ? '是' : '否' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="vertical-align">合約</th>
                        <td colspan="3"><button type="button" class="center-block btn btn-brand get-u2b-contract">查看合約</button></td>
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
                        <td class="list-height">
                            <strong>預約單編號：</strong>{{ $newLectureRequest->lecture_request_number }}<br>
                            <strong>預約單建立時間：</strong>{{ datetimeFormat($newLectureRequest->lecture_request_created_datetime) }}<br>
                            <strong>講座產品：</strong>{{ $newLectureRequest->lecture_name }}<br>
                            <strong>講座日期：</strong>{{ datetimeToDateFormat($newLectureRequest->lecture_start_datetime) }}<br>
                            <strong>講座時間：</strong>{{ datetimeToTimeFormat($newLectureRequest->lecture_start_datetime) }} ~ {{ datetimeToTimeFormat($newLectureRequest->lecture_end_datetime) }}<br>
                            <strong>講座地點：</strong>{{ $newLectureRequest->lecture_city_name . $newLectureRequest->lecture_district_name . $newLectureRequest->lecture_address}}<br>
                            <strong>企業名稱：</strong>{{ empty($newLectureRequest->company_name) ? $newLectureRequest->informal_company_name : $newLectureRequest->company_name }}<br>
                            <strong>統一編號：</strong>{{ empty($newLectureRequest->company_tax_number) ? $newLectureRequest->informal_company_tax_number : $newLectureRequest->company_tax_number }}<br>
                            <strong>聯絡人姓名：</strong>{{ $company_info->contact_surname . $company_info->contact_first_name }}<br>
                            <strong>聯絡人電話：</strong>{{ empty($newLectureRequest->informal_company_id) ? $company_info->phone_number : $company_info->contact_phone }}<br>
                            <strong>聯絡人信箱：</strong>{{ $company_info->contact_email }}<br>
                            <strong>是否有建立帳號：</strong> {{ empty($newLectureRequest->informal_company_id) ? '是' : '否' }}<br>
                            <strong>合約：</strong><button type="button" class="center-block btn btn-sm btn-brand get-u2b-contract">查看合約</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-u2b-contract" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></span>企業與優照護之合約</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="u2b-contract-content">

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

            $(document).on('click', '.get-u2b-contract', function() {
                var u2bContractUrl = "<?php echo route('lct.getU2BContractByAjax')?>";
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
                        $('#u2b-contract-content').append(
                            result
                        );
                        $('#modal-u2b-contract').modal('show');
                        $('.get-u2b-contract').button('reset');
                    }
                });
            });

            $('#modal-u2b-contract').on('hidden.bs.modal', function (){
                $('#u2b-contract-content').html('');
            });

        });

    </script>
@endsection
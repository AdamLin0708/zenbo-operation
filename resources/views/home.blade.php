@extends('layouts.scaffold')
@section('section')
@include('partial._company_navbar')
    <div class="container-fluid" style="z-index: 100">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="#cpn_fill_form" class="btn btn-fab padding-0 no-box-shadow" id="main">
                        <img src="/img/fab_icon.png" style="width: 50px; height: 50px">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid section-with-top">
        <div class="row text-center">
            <div class="col-md-12">
                <h1 class="h1-mobile">照顧長輩的辛苦旅程 企業能怎麼支持？<br>
                員工沒跟公司說的事? 職場中的隱形未爆彈 💣</h1>
            </div>
            <div class="col-md-12">
                <h2 class="h2-mobile">最適合企業的照顧資源與諮詢管道</h2>
            </div>
        </div>
        <div class="row margin-with-bottom">
            <div class="col-md-10 offset-md-1">
                <p>忙碌拓展工作業務之餘，您可曾發現「照顧家中失能長輩」是員工離職或轉換工作的主因之一，許多員工人生中最艱難的掙扎，就是該不該為了照顧家人而離職?</p>
                <p>隨著員工的年紀漸增，面臨養育孩子與長輩照顧的需求，在工作與家庭間面臨掙扎與兩難，「在職照顧者」常上演著「蠟燭兩頭燒」、「有假不敢請」、「無法或不知該如何跟公司溝通只能被迫提辭職」的情形。</p>
                <p>「只有周末照顧或是一個月數次照顧形式的員工人數很多，公司很難發現這種情形的員工」、「員工離職因素是起因於照顧家人的壓力，問題還沒有顯在化是因為許多員工是隱形照護。」則是「在職照顧者」所面臨的常見困境。</p>
                <p>高齡少子化趨勢下，企業究竟應該如何響應『照顧友善職場』。想做但是不知如何著手嗎？</p>
                 <p>「優健康照護講座」提供一個更有效率、更平價、更具成本效益的方式！藉著教育訓練了解講座中最基礎照護相關知識，讓身兼家庭照顧的員工認識照顧資源，平衡家庭與工作，避免因照顧離職問題，也減少企業承受的人才流失的風險，這也是最直接能幫助照顧壓力大的員工，渡過人生中最不容易的幾年，提供一份最溫暖、深刻的支持！</p>
            </div>
            <div class="col-md-4 offset-md-2 col-10 offset-1 mobile-image-padding text-center">
                <img src="/img/company_image_1.png" alt="..." class="img-fluid">
            </div>
            <div class="col-md-4 col-10 offset-1 mobile-image-padding text-center">
                <img src="/img/company_image_2.png" alt="..." class="img-fluid">
            </div>
            <div class="col-md-2 col-12"></div>
        </div>
        <div class="row margin-with-bottom">
            <div class="col-md-12">
                <h2 class="h2-mobile text-center">『優健康照護講座』與誰最有關？</h2>
            </div>
            <div class="col-md-10 offset-md-1">
                <ul>
                    <li class="list-padding decorate-list">上有老下有小，上班忙碌下班照顧，夾扁扁的『三明治世代』們。</li>
                    <li class="list-padding decorate-list">擔任公司職工福利委員會，為第一線員工謀取各種福利的福委大大們。</li>
                    <li class="list-padding decorate-list">避免公司三明治世代因照顧而離職，正在設法穩定人才的人資管理者。</li>
                    <li class="list-padding decorate-list">想從Ａ到A+ 提升職場競爭力，充滿洞見與智慧的經理人與企業主。</li>
                </ul>
            </div>
        </div>
        <div class="row margin-with-bottom">
            <div class="col-md-12">
                <h2 class="h2-mobile text-center">企業為什麼值得試試？</h2>
            </div>
            <div class="col-md-10 offset-md-1">
                <ul>
                    <li class="list-padding decorate-list">在職照顧者不知如何照顧? 從認識高齡議題與照顧資源看案例找解方。</li>
                    <li class="list-padding decorate-list">講師親到公司行號，您不需花費太多執行成本，卻讓職場留才更友善。</li>
                    <li class="list-padding decorate-list">為您的企業量身打造專屬員工的健康照護，增加員工滿意度與生產力。</li>
                    <li class="list-padding decorate-list">企業友善照顧員工，對內留住優秀人才，對外獲得社會認同與肯定。</li>
                    <li class="list-padding decorate-list">獲得全台首創安全、方便、合適的『短期居家照顧服務第三方平台』更優惠的價格服務！</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="cpn_fill_form">
        <div class="row">
            <div class="col-md-12 text-center desktop-visible">
                <h2 class="h2-mobile"><img src="/img/heart_icon.png" class="heart-icon">展開企業照顧友善職場的第一步！</h2>
            </div>
            <div class="mobile-visible text-center col-12">
                <img src="/img/heart_icon.png" class="heart-icon">
                <h2 class="h2-mobile">展開企業照顧友善職場的第一步！</h2>
            </div>
            <div class="col-md-10 offset-md-1 desktop-visible">
                <div id="stepper-example" class="bs-stepper">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#test-l-1">
                            <span><img src="/img/step1.png" style="width: 30px;"></span>
                            <span class="bs-stepper-label">填資料</span>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#test-l-2">
                            <span><img src="/img/step2.png" style="width: 30px;"></span>
                            <span class="bs-stepper-label">送出表單</span>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#test-l-3">
                            <span><img src="/img/step3.png" style="width: 30px;"></span>
                            <span class="bs-stepper-label">完成</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 offset-4 mobile-visible">
                <img src="/img/mobile_stepflow.png" class="img-fluid">
            </div>
            <div class="col-md-12 text-center logo-padding">
                <h2 class="h2-mobile">講座預約單申請表單</h2>
                <h3 class="h3-mobile"><img src="/img/star_icon.png" style="width: 15px;"> 凡附有星星符號為必填</h3>
            </div>
            <div class="col-md-10 offset-md-1 col-12">
                <div class="card">
                    <div class="card-body padding-0">
                        <form action="{{ route('lct.createRequest') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">選擇講座主題</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-center">勾選</th>
                                    <th>講座主題</th>
                                </tr>
                                @foreach($lectures as $key => $lecture)
                                    <tr>
                                        <td class="vertical-middle text-center"><input type="radio" name="lecture_id" value="{{ $lecture->lecture_id }}" required></td>
                                        <td>{{ $lecture->lecture_name }}<br>費用：{{ priceFormatAmendent($lecture->total_price) }} $NTD<br>總時數：{{ priceFormatAmendent($lecture->lecture_hour) }}小時</td>
                                    </tr>
                                @endforeach
                                <tr>
                                   <td colspan="2">
                                       <h3 class="h3-mobile title-margin-0">填寫講座細節</h3>
                                   </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 講座日期</div>
                                            <div class="col-md-9 list-padding">
                                                <input type="text" class="form-control" name="lecture_date" id="lecture_date" value="{{ old('lecture_date') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 講座開始時間</div>
                                            <div class="col-md-9 list-padding">
                                                <input type="text" class="form-control" name="lecture_start_time" id="lecture_start_time" value="{{ old('lecture_start_time') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 縣市</div>
                                            <div class="col-md-9 list-padding">
                                                {!!  Form::select('lecture_city', $city_ids, null, ['id' => 'lecture_city', 'placeholder' => '請選擇...', 'required' => true, 'class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 行政區</div>
                                            <div class="col-md-9 list-padding">
                                                <select class="lecture_select_area form-control" name="lecture_district" id="lecture_district" required>
                                                </select>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 地址</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="lecture_address" value="{{ old('lecture_address') }}" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">填寫企業資訊</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 聯絡人姓氏</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="contact_surname" value="{{ old('contact_surname') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 聯絡人姓名</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="contact_first_name" value="{{ old('contact_first_name') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 聯絡人電話</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="tel" name="contact_phone" value="{{ old('contact_phone') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 聯絡人信箱</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="contact_email" value="{{ old('contact_email') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 企業名稱</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 統一編號</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="company_tax_number" id="company_tax_number" value="{{ old('company_tax_number') }}" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 縣市</div>
                                            <div class="col-md-9 list-padding">
                                                {!!  Form::select('company_city', $city_ids, null, ['id' => 'company_city', 'placeholder' => '請選擇...', 'required' => true, 'class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 行政區</div>
                                            <div class="col-md-9 list-padding">
                                                <select class="company_select_area form-control" name="company_district" id="company_district" required>
                                                </select>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 地址</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="text" name="company_address" value="{{ old('company_address') }}" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">確認事項</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding">合約 <button type="button" class="center-block btn btn-brand btn-sm get-u2b-contract">查看</button></div>
                                            <div class="col-md-9 list-padding">
                                                <input type="checkbox" name="u2b_contract" id="u2b_contract" value="1" required> 是否同意合約?
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding">註冊帳號</div>
                                            <div class="col-md-9 list-padding">
                                                <input type="checkbox" name="check_if_register" id="check_if_register"> 我要一併建立帳號（若勾選請填寫密碼）
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding">密碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="password" name="company_password" value="{{ old('company_password') }}" id="company_password">
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding">確認密碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input class="form-control" type="password" name="company_password_confirmed"  value="{{ old('company_password_confirmed') }}" id="company_password_confirmed">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h3 class="h3-mobile title-margin-0">我有問題想問問（最多500字）</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <textarea class="form-control" rows="4" style="resize: none" name="lecture_request_question"></textarea>
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

    <style>
        #u2b-contract-content p {
            color: black;
        }
    </style>
    <div class="modal fade" id="modal-u2b-contract" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title">企業與優照護之合約</h4>
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

        $( "#company_city" ).change(function() {
            var val = $('#company_city').val();
            $('#company_district').html('');
            if(val !== ''){
                district_ids[val].forEach(function (item) {
                    $('#company_district').append('<option value="'+item.district_id+'">' + item.name + '</option>');
                });
            }
            else{
                $('#company_district').append('<option value="">請選擇...</option>');
            }
        });

        $(document).ready(function() {


            $('div[data-name="nav-home"]').addClass('nav-active');

            $(document).on('click', '.get-u2b-contract', function() {
                var u2bContractUrl = "<?php echo route('lct.getU2BContractByAjax')?>";
                var company_name = $("#company_name").val();
                var company_register_flag = 0;

                $(this).button('loading');

                if($("#check_if_register").is(':checked')){
                    company_register_flag = 1;
                }

                $.ajax({
                    type: 'GET',
                    url: u2bContractUrl,
                    data: {
                        'company_name': company_name,
                        'company_register_flag': company_register_flag
                    },
                    dataType: 'json',
                    success: function(result){
                        $('#u2b-contract-content').append(
                            result.content
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

        $('#check_if_register').on('change', function(){ // on change of state
            if(this.checked) {
                console.log('123');
                $("#company_password").prop('required',true);
                $("#company_password_confirmed").prop('required',true);
            } else {
                console.log('456');
                $("#company_password").prop('required',false);
                $("#company_password_confirmed").prop('required',false);
            }
        })
        $('a').click(function(){
            $('html, body').animate({
                scrollTop: $( $(this).attr('href') ).offset().top
            }, 500);
            return false;
        });
    </script>
@endsection
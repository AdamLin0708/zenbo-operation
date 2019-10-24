@extends('admin.company.dashboard')
@section('page_heading','企業資料 - 企業基本資料修改')
@section('section')

    <div class="container-fluid">
        <form class="form-horizontal" action="{{ route('cpn.admin.updateProfile') }}" method="post" enctype="multipart/form-data" novalidate>
            <div class="row">
            </div>
            <h2 class="h2-mobile">基本資料</h2>
            {{ csrf_field() }}
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align" for="company_name">組織名稱：</label>
                <div class="col-md-5 col-sm-12">
                    <input class="form-control" type="text" value="{{ $company->name }}" name="company_name">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">公司地址縣市：</label>
                <div class=" col-md-2 col-sm-12">
                    {!!Form::select('company_address_city_id', $city_ids, old('company_city_id')?
                    old('company_city_id'): $company_address_city_id, ['placeholder' => '請選擇...', 'class' =>
                    'form-control', 'id' => 'company_address_city_id'])!!}
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">公司地址行政區：</label>
                <div class=" col-md-2 col-sm-12">
                    <select class="form-control" name="company_address_district_id"
                            id="company_address_district_id">
                        <option value="">請選擇...</option>
                    </select>
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">公司地址：</label>
                <div class=" col-md-5 col-sm-12">
                    <input type="text" name="company_address" class="form-control"
                           value="{{old('company_address')? old('company_address'): $company_address}}"
                           placeholder="範例:羅斯福路1段1號">
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">聯絡人姓氏：</label>
                <div class="col-md-2 col-sm-12">
                    <input class="form-control" type="text" value="{{ $company_contact_employee->surname }}" name="company_contact_employee_surname">
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">聯絡人名字：</label>
                <div class="col-sm-12 col-md-2">
                    <input class="form-control" type="text" value="{{ $company_contact_employee->first_name }}" name="company_contact_employee_first_name">
                </div>
                <div class="col-md-7"></div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-12 col-12 m-auto form-label-align">聯絡人電話：</label>
                <div class="col-sm-12 col-md-5">
                    <input class="form-control" type="text" value="{{ $contact_phone_info->phone_number }}" name="company_contact_phone_number">
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
        var district_ids = {!! json_encode($district_ids->toArray()) !!};
        var district_id = "{!! old('company_address_district_id')? old('company_address_district_id'):$company_address_district_id !!}";
        var city_id = "{!! old('company_address_city_id')? old('company_address_city_id'):$company_address_city_id !!}";
        if(city_id){
            district_ids[city_id].forEach(function (item) {
                $('#company_address_district_id').append('<option value="'+item.district_id+'">' + item.name + '</option>');
            });
            $('#company_address_district_id').val(district_id);
        }
        $( "#company_address_city_id" ).change(function() {
            var val = $('#company_address_city_id').val();
            $('#company_address_district_id').html('');
            if(val !== ''){
                district_ids[val].forEach(function (item) {
                    $('#company_address_district_id').append('<option value="'+item.district_id+'">' + item.name + '</option>');
                });
            }
            else{
                $('#company_address_district_id').append('<option value="">請選擇...</option>');
            }
        });
    </script>
@endsection
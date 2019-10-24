@extends('layouts.scaffold')
@section('section')
@include('partial._teacher_navbar')

    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1>感謝您註冊，請等待人員審核，若您需要修改資料，也可以登入後台進行修改</h1>
            </div>
            <div class="col-md-12">
                <a href="{{ route('tch.login') }}" class="btn btn-primary">我要登入</a>
            </div>
        </div>
    </div>
@endsection
@section('javascript')

@endsection
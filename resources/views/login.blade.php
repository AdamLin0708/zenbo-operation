@extends ('layouts.scaffold')
@section ('section')
    <div class="container-fluid section-with-top">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="" method="post" action="{{route('postLogin')}}" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    <div class="card">
                        <div class="card-body padding-0">
                            <table class="table table-bordered margin-bottom-0">
                                <tr>
                                    <td>
                                        <h3 class="h3-mobile title-margin-0 text-center">登入管理後台</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 電子信箱</div>
                                            <div class="col-md-9 list-padding">
                                                <input type="text" value="{{ old('email_login') }}" name="email_login" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 密碼</div>
                                            <div class="col-md-9 list-padding">
                                                <input type="password" value="{{ old('password') }}"name="password" class="form-control" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group text-center margin-with-top">
                        <input type="submit" class="btn btn-block btn-success" value="登入">
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
@section('javascript')
@endsection



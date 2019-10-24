@extends ('layouts.plane')
@section ('body')

    <nav class="navbar navbar-web test">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{route('home')}}">Zenbo專案管理後台</a>
            </div>
        </div>
    </nav>
    <div>
        @include('partial._message')
        @include('partial._validation_error')
        @include('flash::message')
        <div class="row section-with-bottom">
            @yield('section')
        </div>

    </div>
@stop
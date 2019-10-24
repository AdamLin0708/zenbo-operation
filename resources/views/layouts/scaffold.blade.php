@extends ('layouts.plane')
@section ('body')


    <nav class="navbar navbar-web test">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand text-center" href="https://ucarer.tw/healthLecture" target="_blank">
                    <img alt="「優照護」商標" style="max-height: 40px; display: inline; margin-top: -5px;" src="/img/Logo.png"/>
                </a>
            </div>
        </div>
    </nav>
    <section id="welfare-banner" class="container-fluid full-bg-image" style="background: url('/img/lectures-banner.jpg')">
        <div class="container-fluid container-welfare">
            <h1 class="h1-mobile-welfare container-margin" style="color: rgb(105,149,12)"><strong>優健康照護講座</strong></h1>
            <h2 class="h2-mobile-welfare container-margin" style="color: rgb(152,159,175)"><i class="fa fa-caret-right"></i> 最新健康照護資訊</h2>
            <h2 class="h2-mobile-welfare container-margin" style="color: rgb(152,159,175)"><i class="fa fa-caret-right"></i> 專業人員現場交流</h2>
            <p class="container-margin" style="color: black">優照護歡迎企業福委及鄰里社區預約辦理優健康照護講座。</p>
        </div>
    </section>
    <div>
        @include('partial._message')
        @include('partial._validation_error')
        @include('flash::message')
        <div class="row section-with-bottom">
            @yield('section')
        </div>

    </div>
@stop
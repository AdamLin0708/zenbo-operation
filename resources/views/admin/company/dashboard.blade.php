@extends('layouts.plane')

@section('body')
  <div class="wrapper">

    <nav class="sidebar-cus">

      <div class="dashboard-dismiss">
        <i class="fas fa-arrow-left"></i>
      </div>

      <div class="sidebar-header">
        <h3><a href="{{route('cpn.admin.main')}}">企業管理後台</a></h3>
      </div>
      <ul class="list-unstyled components">
        <li>
          <a href="{{ route('cpn.admin.createLectureRequest') }}">建立講座預約單</a>
        </li>
        <li>
          <a href="#companyInfoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">企業資料</a>
          <ul class="collapse list-unstyled" id="companyInfoSubmenu">
            <li>
              <a href="{{ route('cpn.admin.editProfile') }}">企業基本資料修改</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#lectureOrderInfo" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">訂單相關</a>
          <ul class="collapse list-unstyled" id="lectureOrderInfo">
            <li>
              <a href="{{ route('cpn.admin.orderLists') }}">訂單列表</a>
            </li>
            <li>
              <a href="{{ route('cpn.admin.requestLists') }}">預約單列表</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{{ route('cpn.admin.logout')  }}">登出</a>
        </li>
      </ul>
    </nav>

    <div class="admin-content">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

          <button type="button" id="sidebarCollapse" class="btn btn-info">
            <i class="fas fa-align-left"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                @if(\Auth::check())
                  ({{\Auth::user()->email_login}})
                @endif
              </li>
              <li class="nav-item">
                <a href="{{ route('cpn.admin.logout')  }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
              </li>
            </ul>
          </div>

        </div>
      </nav>

      <div class="overlay"></div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header h1-mobile">@yield('page_heading')</h1>
          </div>
        </div>
        @include('partial._message')
        @include('partial._validation_error')
        @yield('section')
      </div>
    </div>
  </div>

  <script>
      $(document).ready(function () {

          $(document).ready(function () {
              $(".sidebar-cus").mCustomScrollbar({
                  theme: "minimal"
              });

              $('.dashboard-dismiss, .overlay').on('click', function () {
                  // hide sidebar
                  $('.sidebar-cus').removeClass('active');
                  // hide overlay
                  $('.overlay').removeClass('active');
              });

              $('#sidebarCollapse').on('click', function () {
                  // open sidebar
                  $('.sidebar-cus').addClass('active');
                  // fade in the overlay
                  $('.overlay').addClass('active');
                  $('.collapse.in').toggleClass('in');
                  $('a[aria-expanded=true]').attr('aria-expanded', 'false');
              });
          });


      });
  </script>
@stop


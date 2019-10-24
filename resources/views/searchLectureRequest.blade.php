@extends('layouts.scaffold')
@section('section')

    @include('partial._company_navbar')
    <div class="container-fluid section-with-top">
         <div class="row">
             <div class="col-md-8 offset-md-2">
                 <form action="{{ route('lct.searchRequestPost') }}" method="post" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="card">
                         <div class="card-body padding-0">
                             <table class="table table-bordered margin-bottom-0">
                                 <tr>
                                     <td>
                                         <h3 class="h3-mobile title-margin-0 text-center">查詢講座預約單</h3>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>
                                         <div class="row">
                                             <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 預約單編號</div>
                                             <div class="col-md-9 list-padding">
                                                 <input type="text" class="form-control" name="lecture_request_number" id="lecture_request_number" required>
                                             </div>
                                             <div class="col-md-3 text-left m-auto list-padding"><img src="/img/star_icon.png" style="width: 15px;"> 手機號碼</div>
                                             <div class="col-md-9 list-padding">
                                                 <input type="tel" class="form-control" name="contact_phone" id="contact_phone" required>
                                             </div>
                                         </div>
                                     </td>
                                 </tr>
                             </table>
                         </div>
                     </div>
                     <div class="form-group text-center margin-with-top">
                         <button type="submit" class="btn btn-brand btn-block">查詢</button>
                     </div>
                 </form>
             </div>
         </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {

            $('div[data-name="nav-search-lecture"]').addClass('nav-active');

        });
    </script>
@endsection
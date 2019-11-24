@extends('admin.dashboard')
@section('page_heading','新增影片')
@section('section')
    <div class="container-fluid">
        <a href="{{ route('videoLists') }}" class="btn btn-primary">返回列表</a>
    </div>
    <br>
    <div class="container-fluid">
        <form action="{{ route('videoCreatePost') }}" method="POST">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="vertical-align: middle">影片名稱</th>
                    <td>
                        <input type="text" class="form-control" name="video_name" required />
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">影片敘述</th>
                    <td>
                        <input type='text' class="form-control" name="video_description" required />
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">影片連結</th>
                    <td>
                        <input type='text' class="form-control" name="video_url_link" required />
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">影片ID</th>
                    <td>
                        <input type='text' class="form-control" name="video_specific_id" required />
                    </td>
                </tr>
                </thead>
            </table>
            <button type="submit" class="btn btn-danger">新增</button>
        </form>
    </div>
@stop
@section('javascript')
@stop
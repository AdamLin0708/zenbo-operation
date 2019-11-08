@extends('admin.dashboard')
@section('page_heading','編輯影片')
@section('section')
    <div class="container-fluid">
        <a href="{{ route('videoLists') }}" class="btn btn-primary">返回列表</a>
    </div>
    <br>
    <div class="container-fluid">
        <form action="{{ route('videoEditPost', $video->video_id) }}" method="POST">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="vertical-align: middle">影片名稱</th>
                    <td>
                        <input type="text" class="form-control" name="video_name" value="{{ $video->name }}" required />
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">影片敘述</th>
                    <td>
                        <input type='text' class="form-control" name="video_description" value="{{ $video->description }}" required />
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">影片連結</th>
                    <td>
                        <input type='text' class="form-control" name="video_url_link" value="{{ $video->url_link }}" required />
                    </td>
                </tr>
                </thead>
            </table>
            <button type="submit" class="btn btn-danger">更新</button>
        </form>
    </div>
@stop
@section('javascript')
@stop
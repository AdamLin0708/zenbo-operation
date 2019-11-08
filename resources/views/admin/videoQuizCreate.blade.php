@extends('admin.dashboard')
@section('page_heading', $video->video_name.' - 新增測驗題')
@section('section')
    <div class="container-fluid">
        <a href="{{ route('videoLists') }}" class="btn btn-primary">返回列表</a>
    </div>
    <br>
    <div class="container-fluid">
        <form action="{{ route('videoQuizCreatePost', $video_id) }}" method="POST">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="vertical-align: middle">題目敘述</th>
                    <td>
                        <textarea type="text" class="form-control" name="quiz_description" required>{{ old('quiz_description') }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">選項A</th>
                    <td>
                        <input type='text' class="form-control" name="answers[]" placeholder="選項A，若無則不需填寫"/>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">選項B</th>
                    <td>
                        <input type='text' class="form-control" name="answers[]" placeholder="選項B，若無則不需填寫"/>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">選項C</th>
                    <td>
                        <input type='text' class="form-control" name="answers[]" placeholder="選項C，若無則不需填寫"/>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">選項D</th>
                    <td>
                        <input type='text' class="form-control" name="answers[]" placeholder="選項D，若無則不需填寫"/>
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">正確答案</th>
                    <td>
                        <select class="form-control selectpicker" name="correct_answer">
                            <option value="0">選項A</option>
                            <option value="1">選項B</option>
                            <option value="2">選項C</option>
                            <option value="3">選項D</option>
                        </select>
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
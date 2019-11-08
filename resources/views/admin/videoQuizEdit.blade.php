@extends('admin.dashboard')
@section('page_heading', '編輯測驗題')
@section('section')
    <div class="container-fluid">
        <a href="{{ route('videoLists') }}" class="btn btn-primary">返回列表</a>
    </div>
    <br>
    <div class="container-fluid">
        <form action="{{ route('videoQuizEditPost', $quiz->quiz_id) }}" method="POST">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="vertical-align: middle">題目敘述</th>
                    <td>
                        <textarea type="text" class="form-control" name="quiz_description" required>{{ $quiz->description }}</textarea>
                    </td>
                </tr>

                @foreach($answers as $key => $answer)
                    <tr>
                        <th style="vertical-align: middle">選項{{ $option_array[$key] }}</th>
                        <td>
                            <input type='text' class="form-control" name="answers[]" value="{{ $answer->description }}" required/>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th style="vertical-align: middle">正確答案</th>
                    <td>
                        <select class="form-control selectpicker" name="correct_quiz_answer_id">
                            @foreach($answers as $key => $answer)
                                @if($answer->quiz_answer_id == $quiz->correct_quiz_answer_id)
                                    <option value="{{ $answer->quiz_answer_id }}" selected>選項{{ $option_array[$key] }}</option>
                                @else
                                    <option value="{{ $answer->quiz_answer_id }}">選項{{ $option_array[$key] }}</option>
                                @endif
                            @endforeach
                        </select>
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
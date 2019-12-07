@extends('admin.dashboard')
@section('page_heading','影片列表')
@section('section')
    <div class="container-fluid">
        <a class="btn btn-primary" href="{{ route('memberLists') }}">返回會員列表</a>
    </div>

    <div class="container-fluid">
        <div class="tab-content">
            <div id="orderLists" class="tab-pane in active">
                <table class="table table-bordered" style="margin-top: 30px">
                    <thead>
                    <tr>
                        <th>影片ID</th>
                        <th>總題數</th>
                        <th>答對題數</th>
                        <th>答對率</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($output as $key => $item)
                        <tr>
                            <td style="vertical-align: middle">{{ $key }}</td>
                            <td style="vertical-align: middle">
                                {{ $item['total_quiz_num'] }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $item['correct_quiz'] }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ ( round($item['correct_quiz'] / $item['total_quiz_num'], 2) ) * 100 }} %
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@extends('admin.dashboard')
@section('page_heading','會員列表')
@section('section')
    <div class="container-fluid">
        <div class="tab-content">
            <div id="orderLists" class="tab-pane in active">
                <table class="table table-bordered" style="margin-top: 30px">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>年紀</th>
                        <th>性別</th>
                        <th>註冊時間</th>
                        <th>影片答題狀況</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $key => $member)
                        <tr>
                            <td style="vertical-align: middle">{{ $key+1 }}</td>
                            <td style="vertical-align: middle">
                                {{ $member->email_login }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $member->age }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $member->gender }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $member->created_at }}
                            </td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('videoAnswerLists', $member->user_id) }}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
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
                        <th>註冊時間</th>
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
                                {{ $member->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
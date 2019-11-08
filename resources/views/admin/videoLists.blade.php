@extends('admin.dashboard')
@section('page_heading','影片列表')
@section('section')
    <div class="container-fluid">
        <a class="btn btn-primary" href="{{ route('videoCreate') }}">新增影片</a>
    </div>

    <div class="container-fluid">
        <div class="tab-content">
            <div id="orderLists" class="tab-pane in active">
                <table class="table table-bordered" style="margin-top: 30px">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>影片名稱</th>
                        <th>影片連結</th>
                        <th>編輯影片</th>
                        <th>新增測驗題</th>
                        <th>目前題數</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($videoLists as $key => $videoList)
                        <tr>
                            <td style="vertical-align: middle">{{ $key+1 }}</td>
                            <td style="vertical-align: middle" id="video_{{$videoList->video_id}}_name" data-video-name="{{ $videoList->video_name }}">
                                {{ $videoList->video_name }}
                            </td>
                            <td style="vertical-align: middle">
                                {{ $videoList->video_url_link }}<br>
                            </td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('videoEdit', $videoList->video_id) }}" class="btn btn-outline-info" target="_blank"><i class="fa fa-edit"></i></a>
                            </td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('videoQuizCreate', $videoList->video_id) }}" class="btn btn-outline-info" target="_blank"><i class="fa fa-file"></i></a>
                            </td>
                            <td style="vertical-align: middle" class="text-center">
                                <button class="btn btn-outline-info get-quizLists" data-video-id="{{ $videoList->video_id }}">{{ $videoList->quiz_num }}</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-quizLists" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="video_name"></span>測驗題</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="table-quizLists">
                        <thead>
                        <tr>
                            <th>題目</th>
                            <th>動作</th>
                        </tr>
                        </thead>
                        <tbody id="table-quizLists-content">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>

        $(document).on('click', '.get-quizLists', function() {
            var video_id = $(this).data("video-id");
            var quizListsByAjaxUrl = "<?php echo route('getQuizListsByAjax')?>";
            $('#video_name').text($('td#video_'+video_id+'_name').data('video-name'));

            $(this).button('loading');

            $.ajax({
                type: 'GET',
                url: quizListsByAjaxUrl,
                data: {
                    'video_id': video_id
                },
                dataType: 'json',
                success: function(results){

                    for(var i = 0; i < results.length; i++){
                        var result = results[i];
                        console.log(result.quiz_id);
                        var videoQuizEditUrl = "<?php echo route('videoQuizEdit', "")?>" + "/" + result.quiz_id;

                        //append result to table in modal
                        $('#table-quizLists-content').append(
                            "<tr>"+
                            "<td>"+result.description+"</td>"+
                            "<td><a href='"+videoQuizEditUrl+"' class='btn btn-outline-info' target='_blank'><i class='fa fa-edit'></i></a></td>"+
                            "</tr>"
                        );
                    }
                    $('#modal-quizLists').modal('show');
                    $('.get-quizLists').button('reset');
                },
                error: function (results) {
                    alert(results.responseJSON.error);
                    $('.get-quizLists').button('reset');
                }
            });

        });

        //history modals close handle
        $('#modal-searchHistory').on('hidden.bs.modal', function (){
            var searchHistoryTable = $('#table-searchHistory').DataTable();
            searchHistoryTable.clear();
            searchHistoryTable.destroy();
        });
        $('#modal-notificationNoticeHistory').on('hidden.bs.modal', function (){
            var notificationNoticeTable = $('#table-notificationNotice').DataTable();
            notificationNoticeTable.clear();
            notificationNoticeTable.destroy();
            $('#select-notificationNoticeTemplates').val('');
            $('#template-title').html('');
            $('#notification-patient-to-send').html('');
        });

    </script>
@endsection
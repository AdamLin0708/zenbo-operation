<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class VideoController extends BackendController
{
    public function lists(){

        //取出影片
        $sql = <<<EOF
select
	vd_video_zv.*,
	case
		when tb_quiz_num.quiz_num is null then 0
		else tb_quiz_num.quiz_num
	end as quiz_num
from vd_video_zv
left join (
	select
		vd_quiz.video_id,
		count(vd_quiz.quiz_id) as quiz_num
	from vd_quiz
	group by video_id
) as tb_quiz_num on vd_video_zv.video_id = tb_quiz_num.video_id
EOF;

        $videoLists = DB::select($sql);

        $data = compact('videoLists');

        return view('admin.videoLists', $data);
    }

    public function create(){
        return view('admin.videoCreate');
    }

    public function createPost(){

        $request = Request::all();

        $video_name = $request['video_name'];
        $video_description = $request['video_description'];
        $video_url_link = $request['video_url_link'];
        $video_specific_id = $request['video_specific_id'];

        $check = DB::table('vd_video')->where('video_specific_id', $video_specific_id)->get();

        if(!empty($check)){
            \Session::flash('error', '影片ID不可重複！' );
            return redirect()->back()->withInput();
        }

        DB::table('vd_video')->insert([
            'name' => $video_name,
            'description' => $video_description,
            'url_link' => $video_url_link,
            'video_specific_id' => $video_specific_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        \Session::flash('success', '建立成功！' );
        return redirect()->back();
    }

    public function edit($video_id){

        $video = DB::table('vd_video')->where('video_id', $video_id)->first();

        $data = compact('video');

        return view('admin.videoEdit', $data);
    }

    public function editPost($video_id){

        $request = Request::all();

        $video_name = $request['video_name'];
        $video_description = $request['video_description'];
        $video_url_link = $request['video_url_link'];
        $video_specific_id = $request['video_specific_id'];

        $check = DB::table('vd_video')
            ->where('video_id', '!=', $video_id)
            ->where('video_specific_id', $video_specific_id)->get();

        if(!empty($check)){
            \Session::flash('error', '影片ID不可重複！' );
            return redirect()->back()->withInput();
        }

        DB::table('vd_video')->where('video_id', $video_id)->update([
            'name' => $video_name,
            'description' => $video_description,
            'url_link' => $video_url_link,
            'video_specific_id' => $video_specific_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id
        ]);

        \Session::flash('success', '編輯成功！' );
        return redirect()->back();
    }

    public function quizCreate($video_id){

        $video = DB::table('vd_video_zv')->where('video_id', $video_id)->first();

        $data = compact('video', 'video_id');

        return view('admin.videoQuizCreate', $data);
    }

    public function quizCreatePost($video_id){

        $request = Request::all();

        $quiz_description = $request['quiz_description'];
        $answers = $request['answers'];
        $correct_answer = $request['correct_answer'];

        //先判斷是否有填寫內容
        if(empty($answers[0])){
            \Session::flash('error', '請至少填寫選項A！' );
            return redirect()->back()->withInput();
        }

        //判斷所選的正確答案是否有填寫內容
        if(empty($answers[$correct_answer])){
            \Session::flash('error', '您選的正確答案尚未填寫內容，請確認！' );
            return redirect()->back()->withInput();
        }

        //先新增Quiz
        $newQuizId = DB::table('vd_quiz')->insertGetId([
            'video_id' => $video_id,
            'description' => $quiz_description,
            'created_by' => $this->user_identity_info->user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //新增Quiz Answer
        foreach ($answers as $key => $answer){
            if(!empty($answer)){
                $answer_id = DB::table('vd_quiz_answer')->insertGetId([
                    'quiz_id' => $newQuizId,
                    'description' => $answer,
                    'created_by' => $this->user_identity_info->user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->user_identity_info->user_id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                if($key == $correct_answer){
                    DB::table('vd_quiz')->where('quiz_id', $newQuizId)->update([
                        'correct_quiz_answer_id' => $answer_id,
                        'updated_by' => $this->user_identity_info->user_id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        \Session::flash('success', '新增測驗題成功' );
        return redirect()->back();
    }

    public function quizEdit($quiz_id){

        $option_array = ['A', 'B', 'C', 'D'];

        $quiz = DB::table('vd_quiz')
            ->select('quiz_id', 'video_id', 'description', 'correct_quiz_answer_id')
            ->where('quiz_id', $quiz_id)->first();

        $answers = DB::table('vd_quiz_answer')
            ->select('quiz_answer_id', 'quiz_id', 'description')
            ->where('quiz_id', $quiz_id)->get();

        $data = compact('quiz', 'answers', 'option_array');

        return view('admin.videoQuizEdit', $data);
    }

    public function quizEditPost($quiz_id){

        $request = Request::all();

        $quiz_description = $request['quiz_description'];
        $answers = $request['answers'];
        $correct_quiz_answer_id = $request['correct_quiz_answer_id'];

        DB::table('vd_quiz')->where('quiz_id', $quiz_id)->update([
            'description' => $quiz_description,
            'correct_quiz_answer_id' => $correct_quiz_answer_id,
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $answerIds = DB::table('vd_quiz_answer')->where('quiz_id', $quiz_id)->lists('quiz_answer_id');

        foreach ($answers as $key => $answer){
            DB::table('vd_quiz_answer')->where('quiz_answer_id', $answerIds[$key])->update([
                'description' => $answer,
                'updated_by' => $this->user_identity_info->user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }



        \Session::flash('success', '更新成功' );
        return redirect()->back();
    }

    public function quizDelete(){

    }

    public function getQuizListsByAjax(){
        $request = Request::all();
        $video_id = $request['video_id'];

        $quizLists = DB::table('vd_quiz')
            ->select('quiz_id', 'video_id', 'description', 'correct_quiz_answer_id')
            ->where('video_id', $video_id)
            ->get();

        $results = json_encode($quizLists);
        return $results;
    }

}

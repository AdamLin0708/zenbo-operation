<?php

namespace App\Entity\lct;


use Illuminate\Database\Eloquent\Model;
use App\Utility\WhoColumnTrait;

class LectureRequest extends Model
{
    use WhoColumnTrait;
    protected $table = "lct_lecture_request";
    protected $primaryKey = 'lecture_request_id';
    public $timestamps = false;
}

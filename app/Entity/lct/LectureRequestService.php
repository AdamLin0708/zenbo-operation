<?php

namespace App\Entity\lct;


use Illuminate\Database\Eloquent\Model;
use App\Utility\WhoColumnTrait;

class LectureRequestService extends Model
{
    use WhoColumnTrait;
    protected $table = "lct_lecture_request_service";
    protected $primaryKey = 'lecture_request_service_id';
    public $timestamps = false;
}

<?php

namespace App\Entity\lct;


use Illuminate\Database\Eloquent\Model;
use App\Utility\WhoColumnTrait;

class LectureOrder extends Model
{
    use WhoColumnTrait;
    protected $table = "lct_lecture_order";
    protected $primaryKey = 'lecture_order_id';
    public $timestamps = false;
}

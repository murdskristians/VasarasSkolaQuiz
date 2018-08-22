<?php


namespace Quiz\Models;


class ResultModel extends BaseModel
{
    public $userId;
    public $quizId;
    public $score;
    public $ip;
}
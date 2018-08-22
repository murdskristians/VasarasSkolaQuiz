<?php

namespace Quiz\Models;


class AnswersModel extends BaseModel
{
    public $id;
    public $answer;
    public $questionId;
    public $isCorrect;
    public $userId;
}
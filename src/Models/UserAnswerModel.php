<?php

namespace Quiz\Models;


class UserAnswerModel extends BaseModel
{
    public $id;
    public $userId;
    public $quizId;
    public $answerId;
    public $questionId;
}
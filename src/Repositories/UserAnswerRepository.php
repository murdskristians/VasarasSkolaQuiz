<?php

namespace Quiz\Repositories;


use Quiz\Models\UserAnswerModel;

class UserAnswerRepository
{
    /** @var UserAnswerModel[] */
    private $answers = [];

    public function saveAnswer(UserAnswerModel $answer)
    {
        $this->answers[] = $answer;
    }

    public function getAnswers(int $userId, int $quiz): array
    {
        $result = [];

        foreach ($this->answers as $answer) {
            if ($answer->userId == $userId && $answer->quizId == $quiz) {
                $result[] = $answer;
            }
        }
        return $result;
    }
}
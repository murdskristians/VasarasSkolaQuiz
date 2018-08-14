<?php

namespace Quiz\Repositories;

use Quiz\Models\AnswersModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;

class QuizRepository
{
    /** @var QuizModel[] */
    private $quizes = [];
    /** @var QuestionModel[] */
    private $questions = [];
    /** @var AnswersModel[] */
    private $answers = [];

    public function addQuiz(QuizModel $quiz)
    {
        $this->quizes[] = $quiz;
    }

    public function addQuestion(QuestionModel $question)
    {
        $this->questions[] = $question;
    }

    public function addAnswers(AnswersModel $answer)
    {
        $this->answers[] = $answer;
    }

    public function getList(): array
    {
        $list = array();
        foreach ($this->quizes as $quiz) {
            $list[] = $quiz;
        }
        return $list;
    }

    public function getById(int $quizId): QuizModel
    {
        foreach ($this->quizes as $v) {
            if ($v->id == $quizId) {
                return $v;
            }
        }
        return new QuizModel; // Returns empty model
    }

    public function getQuestions(int $quizId): array
    {
        $result = array();

        foreach ($this->questions as $question) {
            if ($question->quizId == $quizId) {
                $result[] = $question;
            }
        }
        return $result;
    }

    public function getAnswers(int $questionId): array
    {
        $answers = array();

        foreach ($this->answers as $answer) {
            if ($answer->questionId == $questionId) {
                $answers[] = $answer;
            }
        }
        return $answers;
    }
}
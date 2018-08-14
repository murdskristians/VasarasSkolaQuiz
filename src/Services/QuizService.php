<?php

namespace Quiz;

use Quiz\Models\UserAnswerModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;

class QuizService
{
    /** @var QuizRepository */
    private $quizes;
    /** @var UserRepository */
    private $users;
    /** @var UserAnswerRepository */
    private $userAnswers;
    /** @var int */
    private $userId;

    public function __construct(
        int $userId,
        QuizRepository $quizes,
        UserRepository $users,
        UserAnswerRepository $userAnswers
    ){
        $this->quizes = $quizes;
        $this->users = $users;
        $this->userAnswers = $userAnswers;
        $this->userId = $userId;
    }

    public function getQuizes(): array
    {
        return $this->quizes->getList();
    }

    public function registerUser(string $name): UserModel
    {
        $user = new UserModel;
        $user->name = $name;

        return $this->users->saveOrCreate($user);
    }

    /** @return array */
    public function getQuestions(): array{

    }

    /** @param int $questionId */
    public function getAnswers(int $questionId){

    }

    /** @param int $quizId */
    public function getUserAnswers(int $quizId){

    }

    public function submitAnswer(int $quizId, int $answerId): UserAnswerModel{

    }

    public function getCurrentUser(): UserModel{

    }
    public function getResult(): ResultModel{

    }
}
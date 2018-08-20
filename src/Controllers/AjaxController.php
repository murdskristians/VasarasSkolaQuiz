<?php

namespace Quiz\Controllers;

use Quiz\Models\UserModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserRepository;

class AjaxController extends BaseAjaxController
{
    /** @var UserRepository */
    protected $userRepository;
    /**
     * @var QuizRepository
     */
    private $quizRepository;

    public function __construct(UserRepository $userRepository, QuizRepository $quizRepository)
    {
        $this->userRepository = $userRepository;
        $this->quizRepository = $quizRepository;
    }

    public function saveUserAction()
    {
        $name = $this->post->get('name');

        /** @var UserModel $user */
        $user = $this->userRepository->create();
        $user->name = $name;
        $this->userRepository->save($user);
        return $user;
    }

    public function indexAction()
    {
        return 'ok';

    }

    public function getAllQuizzesAction()
    {
        return $this->quizRepository->all();
    }
}
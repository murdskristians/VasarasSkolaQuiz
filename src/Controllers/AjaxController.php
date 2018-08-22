<?php

namespace Quiz\Controllers;

use Quiz\Models\UserAnswerModel;
use Quiz\Models\UserModel;
use Quiz\Repositories\AnswerRepository;
use Quiz\Repositories\QuestionRepository;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;

class ajaxController extends BaseAjaxController
{
    /** @var UserRepository */
    protected $userRepository;
    /**
     * @var QuizRepository
     */
    private $quizRepository;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var AnswerRepository
     */
    private $answerRepository;
    /**
     * @var UserAnswerRepository
     */
    private $userAnswerRepository;

    public function __construct(
        UserRepository $userRepository,
        QuizRepository $quizRepository,
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        UserAnswerRepository $userAnswerRepository
    ) {
        $this->userRepository = $userRepository;
        $this->quizRepository = $quizRepository;
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->userAnswerRepository = $userAnswerRepository;

        if (!session_id()) {
            session_start();
        }
    }

    public function saveUserAction()
    {
        $name = $this->post->get('name');

        /** @var UserModel $user */
        $user = $this->userRepository->create();
        $user->name = $name;
        $this->userRepository->save($user);

        return;
    }

    public function getAllQuizzesAction()
    {
        return $this->quizRepository->all();
    }

public function indexAction()
{
    return [
        'name' => '',
    'quizes' => [
    [
        'id' => 1,
    'name' => 'Programming'
],
]
];
}

public function startAction()
{
    $quizId = $this->post->get('quizId');
    $_SESSION['questionIndex'] = 0;

    $this->saveUserAction();

    return $this->getQuestion();
}

public function answerAction()
{
    $answerId = $this->post->get('answerId');

    $index = isset($_SESSION['questionIndex']) ? (int)$_SESSION['questionIndex'] : 0;
    $index++;
    $_SESSION['questionIndex'] = $index;

    return $this->getQuestion($index);
}

public function getQuestion(int $index = 0)
{
    //$questions = $this->questionRepository->all(); //NESTRĀDĀ
    $questions = [
        [
            'id' => 1,
    'question' => 'What is the most basic language Microsoft made?',
    'answers' => [
    [
        'id' => 1,
    'answer' => 'Visual Basic'
],
    [
        'id' => 2,
    'answer' => 'DirectX'
],
    [
        'id' => 3,
    'answer' => 'Batch'
],
    [
        'id' => 4,
    'answer' => 'C++'
],
],
],
    [
        'id' => 2,
    'question' => 'What does HTML stand for?',
    'answers' => [
    [
        'id' => 1,
    'answer' => 'Hyper Text Markup Language'
],
    [
        'id' => 2,
    'answer' => 'Home Tool Markup Language'
],
    [
        'id' => 3,
    'answer' => 'Hyperlinks and Text Markup Language'
],
],
]
];

    if (!isset($questions[$index])) {
        return 'Good you have done!';
    }

    return $questions[$index];
}
}
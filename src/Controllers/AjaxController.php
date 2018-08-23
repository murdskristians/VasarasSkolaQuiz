<?php

namespace Quiz\Controllers;

use Quiz\Models\AnswersModel;
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
                    'name' => 'Programming',
                ],
            ],
        ];
    }

    public function startAction()
    {
        $quizId = $this->post->get('quizId');
        $_SESSION['quizId'] = $quizId;
        $_SESSION['questionIndex'] = 1;

        $allQuestions = $this->questionRepository->all(['quiz_id'=>$quizId]);
        $_SESSION['totalQuestions'] = count($allQuestions);

        $this->saveUserAction();

        return [$_SESSION['totalQuestions'], $this->getQuestion()];
    }

    public function saveUserAction()
    {
        $name = $this->post->get('name');

        /** @var UserModel $user */
        $user = $this->userRepository->create();
        $user->name = $name;
        $this->userRepository->save($user);
        $_SESSION['userId'] = $user->id;

        return;
    }

    public function getQuestion(int $index = 1)
    {
        $question = $this->questionRepository->one([
            'quiz_id' => $_SESSION['quizId'],
            'order_nr' => $index,
        ]);

        if ($question == null) {
            return $this->getResult($_SESSION['quizId']);
        }

        $answers = $this->answerRepository->all(['question_id' => $question->id]);

        $questionWithAnswers = [
            'id' => $question->id,
            'question' => $question->question,
            'answers' => $answers,
        ];

        return $questionWithAnswers;
    }

    public function answerAction()
    {
        $this->saveUserAnswer();

        $index = isset($_SESSION['questionIndex']) ? (int)$_SESSION['questionIndex'] : 1;
        //TODO ja nav uzstādīts tad throw exception
        $index++;
        $_SESSION['questionIndex'] = $index;

        return $this->getQuestion($index);
    }

    public function saveUserAnswer(): void
    {
        $userId = $_SESSION['userId'];
        $quizId = $_SESSION['quizId'];
        $answerId = $this->post->get('answerId');

        $answer = $this->answerRepository->getById($answerId);
        $questionId = $answer->questionId;

        $userAnswerModel = new UserAnswerModel();
        $userAnswerModel->userId = $userId;
        $userAnswerModel->quizId = $quizId;
        $userAnswerModel->answerId = $answerId;
        $userAnswerModel->questionId = $questionId;

        $this->userAnswerRepository->save($userAnswerModel);
    }

    private function getResult( int $quizId ): int
    {
        $score = 0;
        $userId = $_SESSION["userId"];

        /** @var UserAnswerModel[] $userAnswers */
        $userAnswers = $this->userAnswerRepository->all(['quiz_id' => $quizId, 'user_id' => $userId]);

        foreach ($userAnswers as $userAnswer)
        {
            /** @var AnswersModel $answer */
            $answer = $this->answerRepository->getById($userAnswer->answerId);
            if ($answer->isCorrect == 1) $score++;
        }

        return  $score;
    }
}
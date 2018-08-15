<?php
namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;
use Quiz\Models\AnswersModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Models\UserAnswerModel;
use Quiz\QuizService;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;
use Quiz\Repositories\UserRepository;

class QuizTest extends TestCase
{
    /** @var QuizRepository */
    private $quizRepository;

    public function setUp()
    {
        parent::setUp();

        $this->quizRepository = new QuizRepository;

        $data = [
            'Country capitals' => [
                'Latvia' => [
                    'Riga' => true,
                    'Ventspils' => false,
                    'Jurmala' => false,
                    'Daugavpils' => false,
                ],
                'Lithuania' => [
                    'Kaunas' => false,
                    'Siaulia' => false,
                    'Vilnius' => true,
                    'Mazeikiai' => false,
                ],
                'Estonia' => [
                    'Talling' => true,
                    'Paarnu' => false,
                    'Tartu' => false,
                    'Valga' => false,
                ],
            ],
        ];


        $quizIds = 0;
        $questionIds = 0;
        $answerIds = 0;

        foreach ($data as $quizTitle => $questions) {
            $quiz = new QuizModel;
            $quiz->id = ++$quizIds;
            $quiz->name = $quizTitle;

            $this->quizRepository->addQuiz($quiz);

            foreach ($questions as $questionText => $answers) {
                $question = new QuestionModel;
                $question->quizId = $quiz->id;
                $question->id = ++$questionIds;
                $question->question = $questionText;

                $this->quizRepository->addQuestion($question);

                foreach ($answers as $answerText => $isCorrect) {
                    $a = new AnswersModel;
                    $a->id = ++$answerIds;
                    $a->answer = $answerText;
                    $a->isCorrect = $isCorrect;
                    $a->questionId = $question->id;
                }
            }
        }
    }

    public function testSubmittedAnswerIsFound()
    {
        $repo = new UserAnswerRepository;

        //Ievietojam izdomāta quiz id atbildi
        $answer = new UserAnswerModel;
        $answer->quizId = 666;
        $answer->questionId = 13343;
        $answer->answerId = 23321;
        $answer->userId = 1117867;
        $repo->saveAnswer($answer);

        //Ievietojam otra quiz atbildi
        $answer = new UserAnswerModel;
        $answer->quizId = 222;
        $answer->questionId = 1;
        $answer->answerId = 1;
        $answer->userId = 111;
        $repo->saveAnswer($answer);

        //paprasam quiz id iesniegtās atbildes no repositorija.
        $answersFound = $repo->getAnswers(111, 222);

        //Paņemam pirmo masīva elementu
        $answerFound = array_shift($answersFound);

        //Pārbaudam
        self::assertEquals($answer, $answerFound);
    }

    function testAddAndGetQuizzes()
    {
        $repo = new QuizRepository();

        $quiz = new QuizModel();
        $quiz ->name = "Latvia";
        $repo->addQuiz($quiz );

        $newQuiz = new QuizModel();
        $newQuiz ->name = "Estonia";
        $repo->addQuiz($newQuiz );

        $newQuiz2 = new QuizModel();
        $newQuiz2 ->name = "Lithuania";
        $repo->addQuiz($newQuiz2);

        $testResult = $repo->getList();

        $quiz1 = array_shift($testResult);
        $quiz2 = array_shift($testResult);
        $quiz3 = array_shift($testResult);

        self::assertEquals("Latvia", $quiz1->name);
        self::assertEquals("Estonia", $quiz2->name);
        self::assertEquals("Lithuania", $quiz3->name);
    }

    function testAddAndGetQuestion()
    {
        $repo = new QuizRepository();

        $question = new QuestionModel();
        $question->quizId = 3;
        $question->question = "Capital of Latvia?";

        $repo->addQuestion($question);

        $testResult = $repo->getQuestions(3);
        $answerFound = reset($testResult);

        self::assertEquals("Capital of Latvia?", $answerFound->question);
        self::assertEquals(3, $answerFound->quizId);
    }

    function testSaveAndGetAnswersForQuiz()
    {
        $repo = new QuizRepository();

        $answer = new AnswersModel();
        $answer->answer= "perfect test";
        $answer->questionId = 3;
        $answer->isCorrect = 1;
        $answer->userId = 3;


        $repo->addAnswers($answer);

        $testResult = $repo->getAnswers(3);
        $answerFound = reset($testResult);

        self::assertEquals("perfect test", $answerFound->answer);
        self::assertEquals(3, $answerFound->questionId);
        self::assertEquals(1, $answerFound->isCorrect);
        self::assertEquals(3, $answerFound->userId);
    }

    function testGetById(){
        $repo = new QuizRepository();

        $quiz = new QuizModel();
        $quiz ->id = 1;
        $quiz ->name = "Latvia";
        $repo->addQuiz($quiz );

        $newQuiz = new QuizModel();
        $newQuiz ->id = 2;
        $newQuiz ->name = "Estonia";
        $repo->addQuiz($newQuiz );

        $newQuiz2 = new QuizModel();
        $newQuiz2 ->id = 3;
        $newQuiz2 ->name = "Lithuania";
        $repo->addQuiz($newQuiz2);

        $testResult = $repo->getById(2);

        self::assertEquals("Estonia", $testResult->name);
    }

    function testSaveAndGetAnswersForUser()
    {
        $repo = new UserAnswerRepository();

        $answer = new UserAnswerModel();
        $answer->userId = 1;
        $answer->quizId = 3;
        $answer->answerId = 5;
        $answer->questionId = 3;


        $repo->saveAnswer($answer);

        $testResult = $repo->getAnswers(1, 3);
        $answerFound = reset($testResult);

        self::assertEquals(1, $answerFound->userId);
        self::assertEquals(3, $answerFound->quizId);
        self::assertEquals(5, $answerFound->answerId);
        self::assertEquals(3, $answerFound->questionId);
    }

//    function testStuff()
//    {
//        $userAnswerRepo = new UserAnswerRepository;
//        $userRepo = new UserRepository;
//        $quizRepo = new QuizRepository;
//
//        $service = new QuizService($quizRepo, $userRepo, $userAnswerRepo);
//
//        // Add a quiz model to repository
//        $quiz = new QuizModel; // TODO set multiple properties
//        $quizRepo->addQuiz($quiz);
//
//        // Check if service returns the quiz
//        $quizes = $service->getQuizes();
//
//        $answerFound = array_shift($quizes);
//        self::assertCount(1, $answerFound);
//    }
}

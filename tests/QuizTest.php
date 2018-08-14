<?php
namespace Quiz\Tests;

use PHPUnit\Framework\TestCase;
use Quiz\Models\AnswersModel;
use Quiz\Models\QuestionModel;
use Quiz\Models\QuizModel;
use Quiz\Models\UserAnswerModel;
use Quiz\Repositories\QuizRepository;
use Quiz\Repositories\UserAnswerRepository;

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

                foreach($answers as $answerText => $isCorrect){
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
        $answersFound = $repo->getAnswers(111,222);

        //Paņemam pirmo masīva elementu
        $answerFound = array_shift($answersFound);

        //Pārbaudam
        self::assertEquals($answer, $answerFound);
    }
}
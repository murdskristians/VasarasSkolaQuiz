import Api from '../api.js';
import Quiz from '../models/model.quiz.js';
import Question from '../models/model.question.js';
import UserAnswer from '../models/model.userAnswer.js';

class QuizRepository {
    constructor(){
        this.quizApi = new Api('ajax');
    }

    getAllQuizzes() {
        return new Promise( resolve => {
            this.quizApi.get('getAllQuizzes')
                .then(response => {
                    let quizzes = response.data.result.map(Quiz.fromArray);
                    resolve(quizzes);
                })
        })
    }

    start (name, quizId) {
        return new Promise(resolve => {
            this.quizApi.post('start', {name,quizId})
                .then(response => {
                    let questions = Question.fromArray(response.data.result);
                    resolve(questions);
                })
                .catch(() => alert('Oh nooo!!!'));
        })
    }

    answer(answerId) {
        return new Promise(resolve => {
            this.quizApi.post('answer', {answerId} )
                .then(response => {
                    resolve(
                        (typeof response.data.result === 'string'?
                            response.data.result : Question.fromArray(response.data.result)
                        )
                    );
                })
                .catch(() => {
                    debugger;
                })
        })
    }

    result(quizId) {
        return new Promise(resolve => {
            this.quizApi.get('getResult', {quizId} )
                .then(response => {
                    resolve(response.data.score);
                })
                .catch(() => {
                    debugger;
                })
        })
    }
}

export default new QuizRepository();
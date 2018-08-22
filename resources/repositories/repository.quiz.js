import Api from '../api.js';
import Quiz from '../models/model.quiz.js';
import Question from '../models/model.question.js';

class QuizRepository {
    constructor(){
        this.quizApi = new Api('ajax'); //Mainīt ja ekspermentēju uz myAjax
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
}

export default new QuizRepository();
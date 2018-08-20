import Api from '../api.js';
import Quiz from '../models/model.quiz.js';

class QuizRepository {
    constructor(){
        this.quizApi = new Api('ajax'); //CHANGE
    }

    getAllQuizzes() {
        return new Promise( resolve => {
            this.quizApi.get('getAllQuizzes') //CHANGE
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
                    let questions
                    //apstrādā datus, ja vajag
                    //Questions.FromArray
                    resolve();
                })
        })
    }
}

export default new QuizRepository();
export default class UserAnswer {
    constuctor() {
        this.id = null;
        this.userId = null;
        this.quizId = null;
        this.answerId = null;
        this.questionId = null;
    }

    static fromArray(rawData) {
        let userAnswer = new UserAnswer();
        userAnswer.id = rawData.id;
        userAnswer.userId = rawData.userId;
        userAnswer.quizId = rawData.quizId;
        userAnswer.answerId = rawData.answerId;
        userAnswer.questionId = rawData.questionId;

        return userAnswer;
    }
}
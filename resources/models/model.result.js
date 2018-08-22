export default class Result {
    constuctor() {
        this.userId = null;
        this.quizId = '';
        this.score = null;
        this.ip = null;
    }

    static fromArray(rawData) {
        let result = new Result();
        result.userId = rawData.userId;
        result.quizId = rawData.quizId;
        result.score = rawData.score;
        result.ip = rawData.ip;

        return result;
    }
}
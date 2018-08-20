export default class Quiz {
    constuctor() {
        this.id = null;
        this.name = '';
    }

    static fromArray(rawData) {
        let quiz = new Quiz();
        quiz.id = rawData.id;
        quiz.name = rawData.name;

        return quiz;
    }
}
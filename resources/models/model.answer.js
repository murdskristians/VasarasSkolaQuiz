export default class Answer {
    constuctor() {
        /**
         *
         * @type {?number}
         */
        this.id = null;
        /**
         *
         * @type {string}
         */
        this.answer = '';
        /**
         *
         * @type {null}
         */
    }

    /**
     *
     * @param {{}} rawData
     * @returns {Answer}
     */
    static fromArray(rawData) {
        let answer = new Answer();
        answer.id = rawData.id;
        answer.answer = rawData.answer;

        return answer;
    }
}
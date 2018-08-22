export default class User {
    constuctor() {
        this.id = null;
        this.name = '';
    }

    static fromArray(rawData) {
        let user = new User();
        user.id = rawData.id;
        user.name = rawData.name;

        return user;
    }
}
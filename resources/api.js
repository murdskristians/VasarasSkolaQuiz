import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios);

export default class Api {

    /**
     * @param controllerName
     */
    constructor(controllerName) {
        this.controllerName = controllerName;
    }

    /**
     * @param {string} action
     * @param {{}} params
     */
    get(action, params) {
        return Vue.axios.get(this.controllerName + '/' + action , params ? params : {})
    }

    /**
     * @param action
     * @param params
     * @returns {AxiosPromise<any>}
     */
    post(action, params) {
        return Vue.axios.post(this.buildUrl(action), params ? params : {});
    }

    /**
     * @param url
     * @returns {string}
     */
    buildUrl(url) {
        return '/'+this.controllername + '/' +url;
    }

}
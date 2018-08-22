import Vue from 'vue';
import store from './store/store.js';
import Quiz from './components/Quiz.vue';
import './styles/main.scss';

new Vue({
    el: '#app',
    render: h =>h(Quiz),
    store,
});
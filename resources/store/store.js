import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutations.js';

import QuizRepository from '../repositories/repository.quiz.js';

import Quiz from "../models/model.quiz";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        name: '',
        activeQuizId: null,
        allQuizzes: [],
    },
    mutations: {
        [types.SET_ACTIVE_QUIZ](state, quizId){
            state.activeQuizId = quizId;
        },
        [types.SET_ALL_QUIZZES](state, quizzes) {
            state.allQuizzes = quizzes;
        },
        [types.SET_NAME](state, name) {
            state.name = name;
        }
    },
    actions: {
        setActiveQuizId(context, {quizId}){
            context.commit(types.SET_ACTIVE_QUIZ, quizId)
        },
        setAllQuizzes(context) {
            //TODO
            QuizRepository.getAllQuizzes()
                .then(quizzes => {
                    context.commit(types.SET_ALL_QUIZZES, quizzes);
                });
            // context.commit(types.SET_ALL_QUIZZES,
            //     [
            //         {
            //             id:1 ,
            //             name: 'Programming',
            //         },
            //         {
            //             id:2 ,
            //             name: 'Geography',
            //         },
            //     ].map(Quiz.fromArray)
            // )
        },
        setName (context, name) {
            context.commit(types.SET_NAME, name);
        },
        start(context) {
            console.log(this.state.name, this)
        }
    }
})
import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutations.js';

import QuizRepository from '../repositories/repository.quiz.js';
import Question from "../models/model.question.js";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        name: '',
        activeQuizId: null,
        allQuizzes: [],
        activeQuestion: null,
        result: null,
        questionCount: null,
        currentQuestion: 0
    },
    mutations: {
        [types.SET_ACTIVE_QUIZ](state, quizId) {
            state.activeQuizId = quizId;
        },
        [types.SET_ALL_QUIZZES](state, quizzes) {
            state.allQuizzes = quizzes;
        },
        [types.SET_NAME](state, name) {
            state.name = name;
        },
        [types.SET_QUESTION](state, question) {
            state.activeQuestion = question;
        },
        [types.SET_RESULTS](state, result) {
            state.result = result;
        },
        [types.SET_QUESTION_COUNT](state, questionCount) {
            state.questionCount = questionCount;
        },
        [types.SET_CURRENT_QUESTION](state, currentQuestion) {
            state.currentQuestion = currentQuestion;
        },
    },
    actions: {
        setActiveQuizId(context, quizId) {
            context.commit(types.SET_ACTIVE_QUIZ, quizId)
        },
        setAllQuizzes(context) {
            QuizRepository.getAllQuizzes()
                .then(quizzes => {
                    context.commit(types.SET_ALL_QUIZZES, quizzes);
                });
        },
        setName(context, name) {
            context.commit(types.SET_NAME, name);
        },
        start(context) {
            QuizRepository.start(this.state.name, this.state.activeQuizId)
                .then(([questionCount, question]) => {
                    context.commit(types.SET_QUESTION_COUNT, questionCount);
                    context.commit(types.SET_QUESTION, question);
                })
        },
        answer(context, answerId) {
            context.commit(types.SET_CURRENT_QUESTION, context.state.currentQuestion + 1);

            QuizRepository.answer(answerId)
                .then(questionOrResults => {
                    if (questionOrResults instanceof Question) {
                        context.commit(types.SET_QUESTION, questionOrResults)
                    } else {
                        context.commit(types.SET_QUESTION, null);
                        context.commit(types.SET_RESULTS, questionOrResults);
                    }

                })
        },
        result(context) {
            QuizRepository.result(this.state.activeQuizId)
                .then(result => {
                    context.commit(types.SET_RESULTS, result);
                })
        },

    }
})
<template>
    <div>
        <h1 class="main__question">{{question.question}}</h1>
                <AnswerItem :answer="answer" :on-answered="onAnswerPicked" :is-active="answerId === answer.id" v-for="answer in question.answers"/>

        <div class="progress main__progress">
            <div class="progress-bar progress-bar-striped bg-success progress-bar-animated active" role="progressbar"
                 :style="{ width: percent + '%' }">
                <span v-if="percent != 0">{{percent}}%</span>
            </div>
        </div>
        <button class="main__button" @click.stop="onAnswered" :disabled="!answerId">Next</button>

    </div>
</template>
<script>
    import AnswerItem from "./AnswerItem";
    import {mapActions} from 'vuex';
    export default {
        components: {AnswerItem},
        data() {
            return {
                answerId: null,
            }
        },
        computed: {
            question: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
            questionCount: {
                get() {
                    return this.$store.state.questionCount;
                }
            },
            percent() {
                return Math.round(this.$store.state.currentQuestion/this.$store.state.questionCount*100)
            }
        },
        methods: Object.assign({}, mapActions([
            'answer',
        ]), {
            onAnswerPicked(answerId) {
                this.answerId = answerId;
            },
            onAnswered() {
                if (!this.answerId) {
                    alert('No answer picked');
                }
                this.answer(this.answerId);
                this.reset();
            },
            reset() {
                this.answerId = null;
            }
        })
    }
</script>


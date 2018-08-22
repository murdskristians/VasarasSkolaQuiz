<template>
    <div>
        <h1>{{question.question}}</h1>
        <ul>
            <li v-for="answer in question.answers">
                <AnswerItem :answer="answer" :on-answered="onAnswerPicked" :is-active="answerId === answer.id" />
            </li>
        </ul>
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


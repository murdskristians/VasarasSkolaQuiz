<template>
    <div v-if="activeQuestion">
        <div class="main">
            <div class="main__name">Hello, {{name}}! Total questions: {{ questionCount}}</div>

            <div>
                <QuestionItem />
            </div>

        </div>
    </div>
</template>

<script>
    import QuestionItem from './QuestionItem';
    export default {
        name: 'MainFlow',
        components: {QuestionItem},
        computed: {
            name: {
                get() {
                    return this.$store.state.name;
                }
            },
            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
            questionCount: {
                get() {
                    return this.$store.state.questionCount;
                }
            }
        }
    }
</script>
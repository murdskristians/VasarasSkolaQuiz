<template>
    <div v-if="result !== null">
        <div class="result">
            <div class="result__message">Your result: {{ result }}. Total questions: {{ questionCount}}. Correct {{percent}}%.</div>
            <button class="result__button" @click="restart">Start again</button>
        </div>
    </div>
</template>
<script>

    export default {
        name: 'Results',

        //  methods: mapActions(['restart']),
        methods: {
            restart() {
                window.location.reload();
            }

        },
        computed: {
            result: {
                get() {
                    return this.$store.state.result;
                }
            },
            questionCount: {
                get() {
                    return this.$store.state.questionCount;
                }
            },
            percent() {
                    return Math.round(this.$store.state.result/this.$store.state.questionCount*100)
            }
        }
    }
</script>
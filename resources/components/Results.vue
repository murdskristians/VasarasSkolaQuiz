<template>
    <div v-if="result">
        <div class="result">
            <div class="result__message">Your result: {{ result }}</div>
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
            }
        }
    }
</script>
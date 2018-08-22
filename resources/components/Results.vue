<template>
    <div v-if="result">
        <div>{{ result }}</div>
        <button @click="restart">Start again</button>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';
    export default {
        name: 'Results',
        computed: {
            result: {
                get() {
                    return this.$store.state.result;
                }
            }
        },
        methods: mapActions(['restart']),
    }
</script>
<template>
    <button @click="onClick" :class="{ main__answerButton: true, active: isActive }">
        {{ answer.answer }}
    </button>
</template>

<script>
    import Answer from '../models/model.answer.js';
    export default {
        name: 'AnswerItem',
        props: {
            answer: {
                type: Answer,
                required: true,
            },
            onAnswered: {
                type: Function,
                required: true,
            },
            isActive: Boolean,
        },
        methods: {
            onClick() {
                this.onAnswered(this.answer.id);
            }
        }
    }
</script>
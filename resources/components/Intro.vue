<template>
    <div>
        <div class="intro" v-if="!activeQuestion && result === null">
            <div >
                <TextInput v-model="name" />
            </div>
<br />
            <div class="intro__dropdown">
                <SelectDropdown v-model="activeQuizId" label="Choose your quiz below:" :options="getQuizzes()" />
            </div>

            <div>
                <button class="intro__button" @click="onStart"> Start </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import TextInput from './forms/input.text.vue';
    import SelectDropdown from "./forms/select.dropdown.vue";

    export default {
        name: 'Intro',
        components: {SelectDropdown, TextInput},
        computed: {
            allQuizzes: {
                get() {
                    return this.$store.state.allQuizzes
                }
            },
            activeQuestion: {
                get() {
                    return this.$store.state.activeQuestion;
                }
            },
            activeQuizId: {
                get() {
                    return this.$store.state.activeQuizId;
                },
                set(newValue) {
                    this.setActiveQuizId(newValue);
                }
            },
            result: {
                get() {
                    return this.$store.state.result;
                }
            },
            name: {
                get() {
                    return this.$store.state.name;
                },
                set(newName) {
                    this.setName(newName);
                }
            },
        },
        methods: Object.assign({}, mapActions([
            'setAllQuizzes',
            'setActiveQuizId',
            'setName',
            'start',
        ]), {
            onStart() {
                if (!this.name) {
                    alert('Give me your name');
                    return;
                }
                if (!this.activeQuizId) {
                    alert('Pick a quiz!');
                    return;
                }
                this.start();
            },
            getQuizzes() {
                return [].concat([{id: '', name: '---'}], this.allQuizzes);
            }
        }),
        created() {
            this.setAllQuizzes();
        }
    }
</script>
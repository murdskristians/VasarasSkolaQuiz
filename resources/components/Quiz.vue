<template>
    <div class="container">
        <Intro />
        <MainFlow />
        <Results />
    </div>
</template>

<script>
    import Intro from "./Intro";
    import MainFlow from "./MainFlow";
    import Results from './Results';
    export default {
        name: 'Quiz',
        components: {MainFlow, Intro, Results}
    }
</script>
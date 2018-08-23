<template>
    <div>
        <label>{{label}}</label>
        <input class="intro__name form-control" placeholder="Enter your name here" type="text" v-bind:value="value" v-on:input="$emit('input', $event.target.value)" />
    </div>
</template>
<script>
    export default {
        name: 'TextInput',
        props: {
            value: String,
            label: String
        }
    }
</script>
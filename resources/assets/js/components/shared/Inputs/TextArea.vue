<template>
    <textarea class="form-control" v-model="internalValue" v-bind:value="value" :name="name"></textarea>
</template>

<script>
    export default {
        mixins: [require('../Mixins/Model')]
    }
</script>
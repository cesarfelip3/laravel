<template>
    <a>
        <icon :icon="icon" v-if="icon" />
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                required: false
            }
        }
    }
</script>
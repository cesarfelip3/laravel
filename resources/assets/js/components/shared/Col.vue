<template>
    <div :class="sizeClass">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            size: {
                type: String,
                required: true
            }
        },

        computed: {
            sizeClass() {
                return `col-md-${this.size}`;
            }
        }
    }
</script>
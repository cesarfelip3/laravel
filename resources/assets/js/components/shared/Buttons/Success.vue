<template>
    <button :type="type" :class="classes" :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>
    import ButtonMixin from '../Mixins/Button';

    export default {
        mixins: [ButtonMixin],
        computed: {
            defaultColor() {
                return this.color ? this.color : 'success';
            }
        }
    }
</script>
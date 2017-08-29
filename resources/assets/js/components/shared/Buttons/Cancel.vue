<template>
    <button type="reset" class="btn btn-white" data-dismiss="modal">
        <slot></slot>
        <span v-if="! hasDefaultSlot">Cancel</span>
    </button>
</template>

<script>
    export default {
        computed: {
            hasDefaultSlot() {
                return !! this.$slots.default;
            }
        }
    }
</script>
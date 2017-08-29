<template>
    <div class="modal-footer">
        <cancel-btn></cancel-btn>
        <slot></slot>
    </div>
</template>

<script>
    import CancelBtn from '../Buttons/Cancel';

    export default {
        props: {
            cancelButton: {
                type: Boolean,
                required: false,
                default: true
            }
        },
        components: {
            CancelBtn
        }
    }
</script>
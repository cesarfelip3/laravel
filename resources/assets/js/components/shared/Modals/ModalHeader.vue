<template>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
        <i class="fa modal-icon" :class="iconClass" v-if="icon"></i>
        <h4 class="modal-title" style="margin-top: 5px;">
            <slot></slot>
        </h4>
        <small class="font-bold"><slot name="subtitle"></slot></small>
    </div>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                required: false
            }
        },
        computed:{
            iconClass() {
                return `fa-${this.icon}`;
            }
        }
    }
</script>
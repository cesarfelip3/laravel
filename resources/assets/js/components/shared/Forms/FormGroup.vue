<template>
    <div class="form-group" :class="{'has-error': form.errors.has( field )}">
        <slot></slot>
        <span class="help-block" v-show="form.errors.has( field )">
            {{ form.errors.get(field) }}
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            form: {
                type: Object,
                required: true
            },
            field: {
                type: String,
                required: true
            }
        }
    }
</script>
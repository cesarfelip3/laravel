<template>
    <form @submit.prevent="$emit('submit')">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        mixins: [require('../Mixins/Model')],
        data() {
            return {
                form: null
            }
        },
        watch: {
            internalValue() {
                this.form = this.value;
            },
            form: {
                handler(newObject) {
                    for (let element in newObject.errors.all()) {
                        if (newObject.hasOwnProperty(element)) {
                            if (newObject[element] !== null && newObject[element].indexOf('required') > -1) {
                                this.internalValue.errors.forget(element);
                            }
                        }
                    }
                },
                deep: true
            }
        }
    }
</script>
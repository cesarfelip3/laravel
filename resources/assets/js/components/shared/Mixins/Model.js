module.exports = {
    props: {
        value: {required: true},
        name: {required: false}
    },

    data() {
        return {
            internalValue: null
        }
    },

    watch: {
        value() {
            this.internalValue = this.value;
        },
        internalValue(newValue) {
            this.$emit('input', newValue);
        }
    },
};
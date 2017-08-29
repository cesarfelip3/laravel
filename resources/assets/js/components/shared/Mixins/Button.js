export default {
    props: {
        disabled: {
            type: Boolean,
            required: false,
            default: false
        },
        type: {
            type: String,
            required: false,
            default: 'button'
        },
        color: {
            type: String,
            required: false
        },
        size: {
            type: String,
            required: false
        }
    },
    computed: {
        defaultColor() {
            return this.color;
        },
        classes() {
            let result = '';
            if (this.defaultColor) {
                result = `btn-${this.defaultColor} `;
            }

            if (this.size) {
                result += `btn-${this.size} `;
            }

            return `btn ${result}`
        }
    }
}
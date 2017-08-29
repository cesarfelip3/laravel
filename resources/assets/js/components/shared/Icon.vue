<template>
    <i :class="classes"></i>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                required: true
            },
            theme: {
                type: String,
                required: false,
                default: 'fa'
            }
        },

        computed: {
            classes() {
                let icons = this.icon.split(',');
                let result = '';
                if( icons.length > 0) {
                    for ( let index in icons ){
                        let icon = icons[index];
                        result += `${this.theme}-${icon.trim()} `;
                    }
                }
                if( result.length === 0) result = `${this.theme}-${this.icon}`;

                return `${this.theme} ${result}`
            }
        }
    }
</script>
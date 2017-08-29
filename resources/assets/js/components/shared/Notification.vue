<template></template>

<script>
    export default {
        props: ['type', 'message'],

        created() {
            let self = this;
            this.$nextTick(() => {
                self.notify(this.type, this.message);
            });
            Bus.$on('notify', (type, message) => {
                self.notify(type, message);
            });
        },

        methods: {
            notify(type, message)
            {
                if( type && message )
                    toastr[type](message);
            }
        }
    }
</script>
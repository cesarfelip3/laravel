<template>
    <div>
        <multiselect
                v-model="internalValue"
                track-by="id"
                label="name"
                :options="options"
                :searchable="true"
                :internal-search="true"
                placeholder="Select a Role"
                @select="onSelect"
                v-bind:value="value"
        />
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {

        components: {
            Multiselect
        },

        props: {
            value: {required: true}
        },

        data() {
            return {
                internalValue: null,
                options: []
            }
        },

        watch: {
            value() {
                this.internalValue = this.value;
            }
        },

        created() {
            Slc
                .find(laroute.route('api.role.index'))
                .then((response) => {
                    this.options = response;
                });
        },

        methods: {
            onSelect(value) {
                this.$emit('input', value);
            }
        }
    }
</script>
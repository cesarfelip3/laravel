<template>
    <div>
        <single-select
                v-model="internalValue"
                :value="value"
                api="user"
                placeholder="Select a User">
        </single-select>
    </div>
</template>

<script>
    import SingleSelect from '../shared/Inputs/SingleSelect';

    export default {
        mixins: [require('../shared/Mixins/Model')],
        components: {
            SingleSelect
        },
    }
</script>
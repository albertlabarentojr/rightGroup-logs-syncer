<script setup>
import App from '../../../_shared/components';
import {reactive} from 'vue';
import VueMultiselect from "vue-multiselect";

defineProps({
    modelValue: {required: false, default: () => []},
    name: {type: String, required: false, default: null},
    placeholder: {type: String, required: true, default: null},
})

const select = {
    options: [
        {
            value: 'user-service',
            text: 'User Service',
        },
        {
            value: 'invoice-service',
            text: 'Invoice Service',
        },
    ],
};

const emits = defineEmits(['update:modelValue'])
</script>

<template>
    <App.Form.Select
        :modelValue="modelValue"
        :multiple="true"
        :name="name"
        :placeholder="placeholder"
        :options="select.options"
        @update:model-value="(value) => emits('update:modelValue', value)"
    ></App.Form.Select>
</template>

<style scoped>

</style>

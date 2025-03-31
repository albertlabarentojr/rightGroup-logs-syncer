<script setup>
import VueMultiselect from 'vue-multiselect';

defineProps({
    name: {type: String, required: true},
    options: {type: Array, required: false, default: () => []},
    text: {type: [String, Number], required: false, default: 'text'},
    value: {type: [String, Number], required: false, default: 'value'},
    modelValue: {type: Array, required: false, default: null},
    multiple: {type: Boolean, required: false, default: false}
})

const emits = defineEmits(['update:modelValue']);
</script>


<template>
    <VueMultiselect
        :modelValue="modelValue"
        :name="name"
        :multiple="multiple"
        :label="text"
        :track-by="value"
        :options="options"
        @update:model-value="(value) => emits('update:modelValue', value)">
    </VueMultiselect>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

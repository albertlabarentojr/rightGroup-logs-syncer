<script setup>
import {computed} from 'vue'

const props = defineProps({
    name: {type: String, required: true, default: null},
    modelValue: {type: Date, required: false, default: null},
    isDatetime: {type: Boolean, required: false, default: false}
})

const emit = defineEmits(['update:modelValue']);

const inputType = computed(() => {
    return props.isDatetime ? 'datetime-local': 'date';
})
</script>

<template>
    <input
        :type="inputType"
        :modal-value="modelValue"
        @change="event => emit('update:modelValue', event.target.value)"
        :value="modelValue">
</template>

<style scoped>

</style>

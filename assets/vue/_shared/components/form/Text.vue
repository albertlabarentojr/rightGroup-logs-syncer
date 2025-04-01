<script setup>
defineProps({
    name: {type: String, required: true, default: null},
    modelValue: {type: [String, Number], required: false, default: null},
    placeholder: {type: String, required: false, default: null}
})

const emits = defineEmits(['update:modelValue']);

</script>

<template>
    <input
        type="text"
        :placeholder="placeholder"
        :value="modelValue"
        @change="event => emits('update:modelValue', event.target.value)"
    />
</template>

<style scoped>

</style>

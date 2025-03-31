<script setup>
defineProps({
    name: {type: String, required: true, default: null},
    modelValue: {type: [String, Number], required: false, default: null},
    placeholder: {type: String, required: false, default: null}
})

const emits = defineEmits(['update:modelValue']);

</script>

<template>
    <input type="text" :model-value="modelValue" :placeholder="placeholder">
</template>

<style scoped>

</style>

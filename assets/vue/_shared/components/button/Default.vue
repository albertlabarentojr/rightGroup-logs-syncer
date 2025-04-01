<script setup>
defineProps({
    text: {type: String, required: false, default: 'Button'},
    disabled: {type: Boolean, required: false, default: false},
})
</script>

<template>
<button :disabled="disabled">
    <slot>
        {{ text }}
    </slot>
</button>
</template>

<style scoped>

</style>

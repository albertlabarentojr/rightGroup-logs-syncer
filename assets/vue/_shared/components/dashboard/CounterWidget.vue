<template>
    <div class="counter-widget">
        <div class="counter-text">Total Logs: <span class="counter-number">{{ count }}</span></div>
    </div>
</template>

<script setup>
import {computed} from 'vue';

const props = defineProps({
    count: {
        type: Number,
        required: true
    },
});
</script>

<style>
.counter-widget {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
</style>

<template>
    <div class="analytics-widget" :class="{ 'is-increasing': isIncreasing, 'is-decreasing': isDecreasing }">
        <div class="widget-content">
            <h3 class="widget-title">{{ title }}</h3>
            <div class="widget-count">{{ count }}</div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    count: {
        type: Number,
        required: true
    },
});
</script>

<style>
.analytics-widget {
    display: flex;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
    position: relative;
}

.analytics-widget:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}
.widget-content {
    flex: 1;
}

.widget-title {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0 0 0.5rem 0;
    font-weight: 500;
}

.widget-count {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .analytics-widget {
        padding: 1rem;
    }

    .widget-count {
        font-size: 1.5rem;
    }
}
</style>

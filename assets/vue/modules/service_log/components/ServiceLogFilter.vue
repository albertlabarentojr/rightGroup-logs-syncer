<script setup>
import ServiceNameSelect from "./ServiceNameSelect.vue";
import {onMounted, reactive, ref, watch} from "vue";
import App from '../../../_shared/components';
import moment from "moment";

const filters = reactive({
    serviceNames: [],
    statusCode: null,
    startDate: null,
    endDate: null,
})

const emit = defineEmits(['update:filters', 'onFilter'])

const onFilter = () => {
    emit('update:filters', filters);
    emit('onFilter', filters);
}

const onReset = () => {
    filters.serviceNames = [];
    filters.statusCode = null;
    filters.startDate = null;
    filters.endDate = null;

    emit('onFilter', filters);
}

onMounted(() => {
    onFilter();
})
</script>

<template>
    <div>
        <div class="filter">
            <div class="w-25">
                <span>Service Name</span>
                <ServiceNameSelect
                    v-model="filters.serviceNames"
                    name="serviceName"
                    placeholder="Enter service names"/>
            </div>
            <div>
                <span>Status Code</span>
                <App.Form.Text
                    v-model="filters.statusCode"
                    name="statusCode"
                    placeholder="Enter status code"/>
            </div>
            <div>
                <span>Start Date</span>
                <App.Form.Datepicker
                    v-model="filters.startDate"
                    name="startDate"
                    :is-datetime="true"/>
            </div>
            <div>
                <span>End Date</span>
                <App.Form.Datepicker
                    v-model="filters.endDate"
                    name="endDate"
                    :is-datetime="true"/>
            </div>
        </div>
        <div class="action-container">
            <App.Button.Default @click="onFilter">Filter</App.Button.Default>
            <App.Button.Default @click="onReset">Reset</App.Button.Default>
        </div>
    </div>
</template>

<style scoped>
.filter {
    display: flex;
    gap: 2em;
    justify-content: space-between;
}

.filter > div {
    display: flex;
    flex-direction: column;
    gap: 1em;
}

.w-25 {
    width: 25%;
}

.action-container {
    width: 100%;
    display: flex;
    gap: 1em;
    justify-content: end;
    margin-top: 1em;
}
</style>

<script setup>
import ServiceNameSelect from "./ServiceNameSelect.vue";
import {reactive} from "vue";
import App from '../../../_shared/components';

const table = reactive({
    isLoading: false,
    columns: [
        {
            label: "ID",
            field: "id",
        },
        {
            label: "Name",
            field: "name",
        },
        {
            label: "Email",
            field: "email",
        },
    ],
    rows: [
        {
            'id': 1,
            'name': 'John',
            'email': 'john@mail.com'
        }
    ],
    totalRecordCount: 0,
    sortable: {
        order: "id",
        sort: "asc",
    },
});

const filters = reactive({
    serviceNames: [],
    statusCode: null,
    startDate: null,
    endDate: null,
})

</script>

<template>
    <div class="filter">
        <div class="w-25">
            <span>Service Name</span>
            <ServiceNameSelect v-model="filters.serviceNames" name="serviceName" placeholder="Enter service names"/>
        </div>
        <div>
            <span>Status Code</span>
            <App.Form.Text v-model="filters.statusCode" name="statusCode" placeholder="Enter status code"/>
        </div>
        <div>
            <span>Start Date</span>
            <App.Form.Datepicker v-model="filters.statusCode" name="startDate" :is-datetime="true"/>
        </div>
        <div>
            <span>End Date</span>
            <App.Form.Datepicker v-model="filters.statusCode" name="endDate" :is-datetime="true"/>
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
</style>

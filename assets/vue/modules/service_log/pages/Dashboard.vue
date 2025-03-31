<script setup>
import App from '../../../_shared/components';
import {onMounted, onServerPrefetch, reactive} from "vue";
import useFetchCount from "../composables/useFetchCount";
import ServiceNameSelect from "../components/ServiceNameSelect.vue";
import ServiceLogFilter from "../components/ServiceLogFilter.vue";

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

const {isLoading, run: runFetchCount, data} = useFetchCount({
    serviceNames: ['user-service'],
    statusCode: 201,
});

const fetchCount = async () => {
    runFetchCount();
}

onMounted(() => {
    fetchCount();
})
</script>

<template>
<div class="container main centered">
    <App.Dashboard.CounterWidget
        title="Total logs"
        :count="3.45"
        :percentage="3.4"
    ></App.Dashboard.CounterWidget>

    <ServiceLogFilter></ServiceLogFilter>

    <App.Table.List
        :columns="table.columns"
        :data="table.rows"
    ></App.Table.List>
</div>
</template>

<style scoped>
.main {
    height: 100%;
    width: 60%;
    padding-top: 3em;
    display: flex;
    flex-direction: column;
    gap: 2em;
}

.centered {
    margin-left: auto;
    margin-right: auto;
}
</style>

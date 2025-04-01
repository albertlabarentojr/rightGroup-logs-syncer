<script setup>
import App from '../../../_shared/components';
import {onMounted, onServerPrefetch, reactive, computed} from "vue";
import useFetchCount from "../composables/useFetchCount";
import ServiceLogFilter from "../components/ServiceLogFilter.vue";
import useFetchServiceLogs from "../composables/useFetchServiceLogs";
import moment from "moment-timezone";
import ServiceLogTable from "../components/ServiceLogTable.vue";

const dateFormat = 'DD/MMM/YYYY HH:mm:ss z';

const table = reactive({
    pagination: {
        page: 1,
        pages: 0,
    },
    filters: {},
});

const {isLoading: isLoadingCount, run: runFetchCount, data: countData} = useFetchCount();
const {isLoading: isLoadingLogs, run: runFetchLogs, data: serviceLogs} = useFetchServiceLogs();

const query = computed(() => {
    if (!table.filters.serviceNames) {
        return;
    }

    const mapped = {...table.filters};

    mapped.serviceNames = table.filters.serviceNames.map(({value}) => value);

    return mapped;
});

const fetchPaginatedLogs = async () => {
    await runFetchLogs({...query.value, ...table.pagination});

    table.pagination.pages = serviceLogs.value.pages;
}

const fetchDashboardData = () => {
    runFetchCount(query.value);
    fetchPaginatedLogs();
}

const onFilter = () => {
    table.pagination.page = 1;
    fetchDashboardData();
}
</script>

<template>
    <div class="container main centered">
        <ServiceLogFilter @on-filter="onFilter" v-model:filters="table.filters"></ServiceLogFilter>

        <App.Dashboard.CounterWidget
            title="Total logs"
            :count="countData?.count ?? 0"
        ></App.Dashboard.CounterWidget>

        <ServiceLogTable
            v-model:page="table.pagination.page"
            :pages="table.pagination.pages"
            :data="serviceLogs?.items ?? []"
            @on-paginate="fetchPaginatedLogs"
            @on-delete="fetchDashboardData"
        />
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

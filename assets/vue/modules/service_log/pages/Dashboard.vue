<script setup>
import App from '../../../_shared/components';
import {onMounted, onServerPrefetch, reactive, computed} from "vue";
import useFetchCount from "../composables/useFetchCount";
import ServiceLogFilter from "../components/ServiceLogFilter.vue";
import useFetchServiceLogs from "../composables/useFetchServiceLogs";
import moment from "moment-timezone";

const dateFormat = 'DD/MMM/YYYY HH:mm:ss z';

const table = reactive({
    isLoading: false,
    columns: [
        {
            label: "Service Name",
            field: "service_name",
        },
        {
            label: "Date",
            field: 'log_date',
        },
        {
            label: "Url",
            field: "url",
        },
        {
            label: "Status Code",
            field: "status_code",
        },
        {
            label: "Http Verb",
            field: "http_verb",
        },
        {
            label: "Http Version",
            field: "http_version",
        },
        {
            label: "Action",
            field: "action",
        },
    ],
    pagination: {
        page: 1,
        pages: 0,
    },
    filters: {},
});

const {isLoadingCount, run: runFetchCount, data: countData} = useFetchCount();
const {isLoadingLogs, run: runFetchLogs, data: serviceLogs} = useFetchServiceLogs();

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
</script>

<template>
    <div class="container main centered">
        <ServiceLogFilter @on-filter="fetchDashboardData" v-model:filters="table.filters"></ServiceLogFilter>

        <App.Dashboard.CounterWidget
            title="Total logs"
            :count="countData?.count ?? 0"
        ></App.Dashboard.CounterWidget>

        <div>
            <App.Table.List
                :columns="table.columns"
                :data="serviceLogs?.items ?? []"
            >
                <template #log_date="{log_date}">
                    {{ moment.tz(log_date.date, log_date.timezone).format(dateFormat) }}
                </template>

                <template #action="{log_date}">
                    <App.Button.Default>Delete</App.Button.Default>
                </template>
            </App.Table.List>

            <App.Table.Pagination
                v-model:page="table.pagination.page"
                :pages="table.pagination.pages"
                @on-paginate="fetchDashboardData"
            />
        </div>
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

<script setup>
import moment from "moment-timezone";
import App from '../../../_shared/components';
import useFetchServiceLogs from "../composables/useFetchServiceLogs";
import useDeleteServiceLog from "../composables/useDeleteServiceLog";

defineProps({
    data: {type: Array, required: false, default: () => []},
    page: {type: Number, required: false, default: 1},
    pages: {type: Number, required: false, default: 0},
});

const dateFormat = 'DD/MMM/YYYY HH:mm:ss z';

const columns = [
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
];

 const {isLoading: isDeleting, run: deleteLog} = useDeleteServiceLog();

const emit = defineEmits(['update:page', 'onPaginate', 'onDelete']);

const onPaginate = (page) => {
    emit('update:page', page);
    emit('onPaginate', page);
}

const onDelete = async (serviceLogId) => {
    await deleteLog(serviceLogId);

    emit('onDelete', serviceLogId);
}

</script>

<template>
<div>
    <App.Table.List
        :columns="columns"
        :data="data"
    >
        <template #log_date="{log_date}">
            {{ moment.tz(log_date.date, log_date.timezone).format(dateFormat) }}
        </template>

        <template #action="{id}">
            <App.Button.Default @click="() => onDelete(id)">Delete</App.Button.Default>
        </template>
    </App.Table.List>

    <App.Table.Pagination
        :page="page"
        :pages="pages"
        @on-paginate="onPaginate"
    />
</div>
</template>

<style scoped>

</style>

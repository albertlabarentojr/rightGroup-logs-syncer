<script setup>
import App from '../../_shared/components';
import {reactive} from "../../../vendor/@vue/reactivity/reactivity.index";

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
</script>

<template>
<div class="container main centered">
    <div class="container widget">
        <App.Dashboard.CounterWidget
            title="Total logs"
            :count="3.45"
            :percentage="3.4"
        ></App.Dashboard.CounterWidget>

        <App.Table.List
            :columns="table.columns"
            :data="table.rows"
        ></App.Table.List>
    </div>
</div>
</template>

<style scoped>
.main {
    height: 100%;
    width: 60%;
    padding-top: 3em;
}

.centered {
    margin-left: auto;
    margin-right: auto;
}
</style>

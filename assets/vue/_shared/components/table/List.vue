<script setup>
import {reactive} from 'vue';

const props = defineProps({
    isLoading: {type: Boolean, required: false, default: false},
    columns: {type: Array, required: false, default: () => []},
    data: {type: Array, required: false, default: () => []}
})

const formatter = (row, col) => {
    if (col.field instanceof Function) {
        return col.field(row);
    }

    return row[col.field] ?? '-';
}

</script>

<template>
    <table>
        <thead>
        <tr>
            <th v-for="header in columns">{{ header.label }}</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="row in data">
                <td v-for="col in columns" :data-label="row.field">
                    <slot :name="col.field" v-bind="row">
                        {{ row[col.field] ?? '-' }}
                    </slot>
                </td>
            </tr>
            <tr v-if="data.length === 0" :row="columns.length">No records to display</tr>
        </tbody>
    </table>
</template>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #495057;
    border-bottom: 2px solid #ddd;
}

tr:hover {
    background-color: #f5f5f5;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>

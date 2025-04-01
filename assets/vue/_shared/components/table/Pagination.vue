<script setup>
import { VuePaginate } from '@svifty7/vue-paginate';

defineProps({
    page: {type: Number, required: false, default: 1},
    pages: {type: Number, required: false, default: 0},
    maxPageShown: {type: Number, required: false, default: 5},
});

const emit = defineEmits(['update:page', 'onPaginate'])

const onPaginate = (page) => {
    emit('update:page', page)
    emit('onPaginate', page)
}
</script>

<template>
    <VuePaginate
        :model-value="page"
        :page-count="pages"
        container-class="ui pagination menu"
        page-link-class="item"
        prev-link-class="item"
        next-link-class="item"
        break-view-link-class="break-view-link"
        :no-li-surround="true"
        :click-handler="onPaginate"
    />
</template>

<style>
@import "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/components/menu.min.css";

.ui.pagination.menu {
    background: var(--vp-c-text-1);
}

.ui.pagination.menu .item,
.ui.pagination.menu .item.active,
.ui.pagination.menu .item:hover {
    color: var(--vp-c-bg);
}
</style>

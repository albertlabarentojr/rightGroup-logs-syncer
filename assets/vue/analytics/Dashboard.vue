<script setup>
import CountWidget from "./components/CountWidget.vue";
</script>

<template>
<div class="container main centered">
    <div class="container widget">
        <CountWidget
            title="Total logs"
            :count="3.45"
            :percentage="3.4"
        />
    </div>
</div>
</template>

<style scoped>
.main {
    height: 100%;
    width: 60%;
    padding-top: 3em;
    border: 2px solid black;
}

.centered {
    margin-left: auto;
    margin-right: auto;
}
</style>

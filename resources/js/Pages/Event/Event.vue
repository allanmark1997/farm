<script setup>
const props = defineProps(["event"]);
</script>
<template>
    {{ event.title }}
    {{ event.content }}
</template>

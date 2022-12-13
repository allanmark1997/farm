<script setup>
const props = defineProps(["timeline"]);
</script>
<template>
    {{ timeline.title }}
    {{ timeline.content }}
</template>

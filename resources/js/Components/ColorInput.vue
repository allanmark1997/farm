<script setup>
defineProps({
    modelValue: String,
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <input
        type="color"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="text-gray-900 rounded-md border-1 placeholder-gray-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-700"
    />
</template>

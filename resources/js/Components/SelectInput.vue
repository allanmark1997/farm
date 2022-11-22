<script setup>
defineProps({
    modelValue: [String, Number, Boolean],
});

defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        class="truncate block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-ssr-blue2 border-[1.9px] appearance-none focus:outline-none focus:ring-0 peer rounded-lg px-[15px] disabled:cursor-not-allowed"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <slot></slot>
    </select>
</template>

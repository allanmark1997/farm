<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    disabled: {
        type: [Boolean],
        default: false,
    },
    value: {
        type: [String, Boolean],
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit("update:checked", val);
    },
});
</script>
<template>
    <label class="flex cursor-pointer select-none items-center">
        <div class="relative">
            <input
                :disabled="disabled"
                v-model="proxyChecked"
                :value="value"
                type="checkbox"
                class="sr-only"
            />
            <div
                :class="disabled ? 'bg-[#687469]' : 'bg-[#E5E7EB]'"
                class="block h-6 w-10 rounded-full"
            ></div>
            <div
                class="dot absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition"
            ></div>
        </div>
    </label>
</template>
<style scoped>
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #48bb78;
}
</style>

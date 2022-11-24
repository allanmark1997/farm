<script setup>
import { computed } from "vue";

const emit = defineEmits(["update:checked"]);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
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
                v-model="proxyChecked"
                :value="value"
                type="checkbox"
                class="sr-only"
            />
            <div class="block h-6 w-10 rounded-full bg-[#E5E7EB]"></div>
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

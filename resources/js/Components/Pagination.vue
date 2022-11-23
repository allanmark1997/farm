<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const props = defineProps(["links"]);
const search_url = computed(() =>
    usePage().props.value.search != "" &&
    usePage().props.value.search != undefined
        ? "&search=" + usePage().props.value.search
        : ""
);
</script>

<template>
    <div class="-mt-10 -mb-1 flex flex-wrap relative px-2">
        <template v-for="(link, key) in links" :key="key">
            <div
                v-if="link.url === null"
                class="mr-1 mb-1 px-3 py-1 text-md border rounded-sm text-gray-500 cursor-pointer"
                :class="{ 'ml-auto': links.length === key + 1 }"
            >
                <span v-html="link.label"></span>
            </div>
            <Link
                v-else
                class="mr-1 mb-1 px-3 py-1 text-md text-gray-700 rounded-sm border hover:text-gray-900 cursor-pointer"
                :class="{
                    'text-white text-gray-800': link.active,
                    'ml-auto': links.length === key + 1,
                }"
                :href="link.url + search_url"
            >
                <span v-html="link.label"></span>
            </Link>
        </template>
    </div>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { onMounted, reactive, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["transactions"]);

const date_from_filter = ref("");
const date_to_filter = ref("");

onMounted(() => {
    date_from_filter.value = function_date();
    date_to_filter.value = function_date();
});

const function_date = (startYear) => {
    var currentYear = new Date().getFullYear(),
        years = [];
    startYear = 1900;
    while (startYear <= currentYear) {
        years.push(startYear++);
    }
    return years;
};
</script>

<template>
    <AppLayout title="User Management">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2">
                    <div class="flex justify-between gap-1">
                        <a :href="route('analysis.download_report')"
                            class="mb-6 bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition cursor-pointer">Download
                            Report</a>
                            <div class="flex gap-2">
                                <div class="mb-2">
                            <InputLabel
                                for="date_from_filter"
                                value="Date From"
                            />
                            <select
                                id="date_from_filter"
                                
                                class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                                <option value="" disabled>
                                    Select Date filter
                                </option>

                                <template
                                    v-for="(date_from_filter, key) in date_from_filter"
                                    :key="key"
                                >
                                    <option :value="date_from_filter">
                                        {{ date_from_filter }}
                                    </option>
                                </template>
                            </select>
                        </div>
                        <div class="mb-2">
                            <InputLabel
                                for="date_to_filter"
                                value="Date To"
                            />
                            <select
                                id="date_to_filter"
                                
                                class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                                <option value="" disabled>
                                    Select Date filter
                                </option>

                                <template
                                    v-for="(date_to_filter, key) in date_to_filter"
                                    :key="key"
                                >
                                    <option :value="date_to_filter">
                                        {{ date_to_filter }}
                                    </option>
                                </template>
                            </select>
                        </div>
                            </div>
                        
                        
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg">
                            <tr>
                                <th scope="col" class="px-6 py-3">Baranggay name</th>
                                <th scope="col" class="px-6 py-3">Seeds Distributed</th>
                                <th scope="col" class="px-6 py-3">Fertilizers Distributed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(report, barangay ) in transactions" :key="barangay">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                    <div class="pl-3">
                                        <div class="font-normal text-gray-500">
                                            {{ barangay }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        {{ report.seeds }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        {{ report.fertilizers }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </AppLayout>
</template>

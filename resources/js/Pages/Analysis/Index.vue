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


</script>

<template>
    <AppLayout title="User Management">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2"
                >
                <div class="flex justify-between gap-1">
                        <a class="mb-6 bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition cursor-pointer">Download Report</a>
                    </div>
                    <table
                        class="w-full text-sm text-left text-gray-500 rounded-lg"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Baranggay name</th>
                                <th scope="col" class="px-6 py-3">Seeds Distributed</th>
                                <th scope="col" class="px-6 py-3">Fertilizers Distributed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b"
                                v-for="(report, barangay ) in transactions" :key="barangay"
                            >
                                <th
                                    scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap"
                                >
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

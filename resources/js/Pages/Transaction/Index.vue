<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { reactive, ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import moment from "moment";

const props = defineProps(["transactions", "search", "filter_view", "date_from", "date_to"]);
// const filter_view = ref("harvest");

const form = useForm(
    {
        amount: "",
        farmer_id: 1,
        type: "",
    },
    {
        resetOnSuccess: true,
    }
);

const search = ref(props.search);
const filter_view = ref(props.filter_view);
const date_from_filter = ref(props.date_from);
const date_to_filter = ref(props.date_to);
const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add Transaction",
            id: 0,
        },
    },
});

const showModal = () => {
    modals.add_edit.show = true;
};

const saveTransaction = () => {
    form.post(route("transactions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            // alert("Added transactions");
            form.reset();
            modals.add_edit.show = false;
        },
        onError: () => { },
        onFinish: () => {
            //code
        },
    });
};

// const searchTransaction = () => {
//     Inertia.get(
//         route("transactions.index", {
//             search: search.value,
//             filter_view: filter_view.value,
//         }),
//         {
//             preserveScroll: true,
//         }
//     );
// };

// watch(() => search.value, debounce(searchTransaction, 1000));

// const view_filter = () => {
//     Inertia.get(
//         route("transactions.index", {
//             search: search.value,
//             filter_view: filter_view.value,
//         }),
//         {
//             preserveScroll: true,
//         }
//     );
// };

const formatNumber = (num) => {
    return parseFloat(num).toFixed(2)
}

const formatter = new Intl.NumberFormat('en-PH', {
    style: 'currency',
    currency: 'PHP'
});

const function_search = () => {
    Inertia.get(
        route("transactions.index", {
            search: search.value,
            category: filter_view.value,
            date_from:date_from_filter.value, 
            date_to:date_to_filter.value
        }),
        {
            preserveScroll: true,
        }
    );
}
</script>

<template>
    <AppLayout title="Transactions">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-2 pb-12 mt-2">
                    <div class="flex items-center justify-between py-4 bg-white">
                        <!-- <div>
                                    <select
                                        class="mt-1 border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                        v-model="filter_view"
                                        @change="view_filter()"
                                    >
                                        <option value="all">All</option>
                                        <option value="plant">Planting</option>
                                        <option value="harvest">Harvest</option>
                                    </select>
                                </div> -->
                        <div>
                            <a :href="route('transactions.download_transactions', {search:search,  category: filter_view, date_from:date_from_filter, date_to:date_to_filter})"
                            class="mb-6 bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition cursor-pointer">Download
                            Report</a>
                        </div>
                        <div class="flex float-right gap-2">
                            <div class="mb-2 mt-[-1vmin]">
                                <InputLabel for="date_from_filter" value="Date From" />
                                <input v-model="date_from_filter" type="date" class="mr-2 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                            <div class="mb-2 mt-[-1vmin]">
                                <InputLabel for="date_to_filter" value="Date To" />
                                <input v-model="date_to_filter" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                            <div>
                                    <select
                                        class="mt-1 border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                        v-model="filter_view"
                                    >
                                        <option value="0">Farmer</option>
                                        <option value="1">Farm</option>
                                        <option value="2">Barangay</option>
                                    </select>
                                </div>
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" v-model="search" id="table-search-farmers"
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                    placeholder="Search for farmer or farm or baranggay" />
                            </div>
                            <button @click="function_search()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold ml-1 px-4 rounded">
                                Search
                            </button>
                        </div>

                    </div>
                    <table class="w-full text-sm text-left text-gray-500 rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg">
                            <tr>
                                <th scope="col" class="px-6 py-3 align-text-top">Farmer</th>
                                <th scope="col" class="px-6 py-3 align-text-top">Farm</th>
                                <th scope="col" class="px-6 py-3 align-text-top">BARANGAY</th>
                                <th scope="col" class="px-6 py-3 align-text-top">
                                    Expected Income
                                </th>
                                <th scope="col" class="px-6 py-3 align-text-top">Income</th>
                                <th scope="col" class="px-6 py-3 align-text-top">Expectation difference</th>
                                <th scope="col" class="px-6 py-3 align-text-top">Product</th>
                                <th scope="col" class="px-6 py-3 align-text-top">
                                    Fertilizers
                                </th>
                                <th scope="col" class="px-6 py-3 align-text-top">Production Date</th>
                                <th scope="col" class="px-6 py-3 align-text-top">Harvest Date</th>
                                <th scope="col" class="px-6 py-3 align-text-top">Farming Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(transaction, index ) in transactions.data" :key="index">
                                <th class="px-6 py-4 text-gray-900 align-text-top">
                                    {{
                                        transaction.farmer?.name ||
                                        "Inactive Farmer"
                                    }}
                                </th>
                                <td scope="row" class="flex items-center px-6 py-4">
                                    {{
                                        transaction.farm?.map.name
                                    }}
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    {{
                                        transaction.farm?.barangay ||
                                        "Inactive Farm"
                                    }}
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    {{ formatter.format(formatNumber(transaction.details.expected_income)) }}
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    {{ formatter.format(formatNumber(transaction.details.income)) }}
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    {{ formatter.format(formatNumber(transaction.details.income -
                                        transaction.details.expected_income)) }}
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    
                                    <div v-if=" transaction.details.inventories.seedling">
                                        <p>
                                            N: {{ transaction.details.inventories.seedling }}
                                        </p>
                                        <p>
                                            #: {{ transaction.details.inventories
                                            .seedling_quantity }}
                                        </p>
                                    </div>
                                    <div v-else>
                                        <p>None</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-text-top">
                                    <div v-if="transaction.details.inventories
                                        .fertilizer.length != 0">
                                        <template v-for="( fertilizer, fer ) in  transaction.details.inventories
                                            .fertilizer" :key="fer">
                                            <p>N: {{ fertilizer.name }}</p>
                                            <p class="text-xs">#: {{ fertilizer.quantity }}</p>
                                            <p></p>
                                        </template>
                                    </div>
                                    <div v-else>
                                        <p>
                                            None
                                        </p>
                                    </div>


                                </td>
                                <td class="px-6 py-4 align-text-top whitespace-nowrap">
                                    {{ moment(transaction.plant_at).format("MMM. Do, YYYY") }}
                                </td>
                                <td class="px-6 py-4 align-text-top whitespace-nowrap">
                                    {{ transaction.harvest_at != null ? moment(transaction.harvest_at).format("MMM. Do, YYYY") : '-' }}
                                </td>
                                <td class="px-6 py-4 align-text-top whitespace-nowrap">
                                    {{ transaction.harvest_at != null ?
                                        moment(transaction.harvest_at).diff(moment(transaction.plant_at), 'days') + ' days' :
                                        '-'
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mx-auto text-center" v-if="transactions.data.length == 0">
                        No search found
                    </div>
                </div>
                <div class="bottom-4 relative">
                    <Pagination :links="transactions.links"></Pagination>
                </div>

            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Farmer" />
                        <SelectInput class="mt-1 block w-full" required v-model.number="form.farmer_id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Farm" />
                        <SelectInput class="mt-1 block w-full" required v-model.number="form.farmer_id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-4">
                        <InputLabel value="Crop" />
                        <SelectInput class="mt-1 block w-full" required v-model.number="form.farmer_id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Estimated Income" />
                        <TextInput type="number" class="mt-1 block w-full" required v-model="form.name" />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Fertilizer 1" />
                        <SelectInput class="mt-1 block w-full" required v-model.number="form.type">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Fertilizer 2" />
                        <SelectInput class="mt-1 block w-full" required v-model.number="form.type">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Color" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.name" />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false">Cancel</SecondaryButton>
                    <PrimaryButton @click="saveTransaction" :disabled="form.processing">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

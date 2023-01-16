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

const props = defineProps(["transactions", "search"]);
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
            alert("Added transactions");
            form.reset();
            modals.add_edit.show = false;
        },
        onError: () => {},
        onFinish: () => {
            //code
        },
    });
};

const searchTransaction = () => {
    Inertia.get(route("transactions.index", { search: search.value }), {
        preserveScroll: true,
    });
};

watch(() => search.value, debounce(searchTransaction, 1000));
</script>

<template>
    <AppLayout title="Transactions">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2"
                >
                    <div class="flex gap-1">
                        <TextInput
                            v-model="search"
                            placeholder="Search"
                            type="text"
                            class="text-xs mb-2"
                        />
                    </div>
                    <TableList>
                        <template #header>
                            <th
                                class="p-2 border border-l"
                                v-for="header in [
                                    'Date',
                                    'Processed By',
                                    'Farmer',
                                    'Farm',
                                    'Type',
                                ]"
                            >
                                {{ header }}
                            </th>
                        </template>
                        <template #body>
                            <tr
                                class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50"
                                v-for="(
                                    transaction, index
                                ) in transactions.data"
                                :key="index"
                            >
                                <td class="p-2">
                                    {{
                                        moment(transaction.created_at).format(
                                            "MMMM Do YYYY"
                                        )
                                    }}
                                </td>
                                <td class="p-2">
                                    {{ transaction.user?.name }}
                                </td>
                                <td class="p-2">
                                    {{
                                        transaction.farmer?.name ||
                                        "Inactive Farmer"
                                    }}
                                </td>
                                <td class="p-2">
                                    {{
                                        transaction.farm?.name ||
                                        "Inactive Farm"
                                    }}
                                </td>
                                <td class="p-2 uppercase">
                                    {{ transaction.type }}
                                </td>
                            </tr>
                        </template>
                    </TableList>
                    <Pagination :links="transactions.links"></Pagination>
                </div> -->
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2"
                >
                    <div
                        class="flex items-center justify-between py-4 bg-white"
                    >
                        <div></div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-500"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                v-model="search"
                                id="table-search-farmers"
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                placeholder="Search for users"
                            />
                        </div>
                    </div>
                    <table
                        class="w-full text-sm text-left text-gray-500 rounded-lg"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">
                                    Processed by
                                </th>
                                <th scope="col" class="px-6 py-3">Farmer</th>
                                <th scope="col" class="px-6 py-3">Farm</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b"
                                v-for="(
                                    transaction, index
                                ) in transactions.data"
                                :key="index"
                            >
                                <th
                                    scope="row"
                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap"
                                >
                                    <div class="pl-3">
                                        {{
                                            moment(
                                                transaction.created_at
                                            ).format("MMMM Do YYYY")
                                        }}
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ transaction.user?.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        transaction.farmer?.name ||
                                        "Inactive Farmer"
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        transaction.farm.map?.name ||
                                        "Inactive Farm"
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ transaction.type }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="transactions.links"></Pagination>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Farmer" />
                        <SelectInput
                            class="mt-1 block w-full"
                            required
                            v-model.number="form.farmer_id"
                        >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Farm" />
                        <SelectInput
                            class="mt-1 block w-full"
                            required
                            v-model.number="form.farmer_id"
                        >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-4">
                        <InputLabel value="Crop" />
                        <SelectInput
                            class="mt-1 block w-full"
                            required
                            v-model.number="form.farmer_id"
                        >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Estimated Income" />
                        <TextInput
                            type="number"
                            class="mt-1 block w-full"
                            required
                            v-model="form.name"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.amount"
                        />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Fertilizer 1" />
                        <SelectInput
                            class="mt-1 block w-full"
                            required
                            v-model.number="form.type"
                        >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Fertilizer 2" />
                        <SelectInput
                            class="mt-1 block w-full"
                            required
                            v-model.number="form.type"
                        >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </SelectInput>
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Color" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.name"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.amount"
                        />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton
                        @click="saveTransaction"
                        :disabled="form.processing"
                        >Submit</PrimaryButton
                    >
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

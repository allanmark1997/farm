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
    Inertia.get(route("transactions.index", { search: search.value }));
};

watch(() => search.value, debounce(searchTransaction, 1000));
</script>

<template>
    <AppLayout title="Transactions">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
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
                                    {{ transaction.created_at }}
                                </td>
                                <td class="p-2">{{ transaction.user_id }}</td>
                                <td class="p-2">
                                    {{ transaction.farmer.name }}
                                </td>
                                <td class="p-2">{{ transaction.farm.name }}</td>
                                <td class="p-2">{{ transaction.type }}</td>
                            </tr>
                        </template>
                    </TableList>
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

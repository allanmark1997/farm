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
import { reactive } from "vue";

const props = defineProps(["farmers"]);

const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add Farmer",
            id: 0,
        },
    },
});

const showModal = () => {
    modals.add_edit.show = true;
};
</script>

<template>
    <AppLayout title="Farmers">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Farmer
            </h2>
        </template>

        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <PrimaryButton class="my-2" @click="showModal()"
                    >Add</PrimaryButton
                >
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <TableList>
                        <template #header>
                            <th
                                class="p-2 border border-l"
                                v-for="header in [
                                    'Name',
                                    'Action',
                                    'Name',
                                    'Action',
                                ]"
                            >
                                {{ header }}
                            </th>
                        </template>
                        <template #body>
                            <tr
                                class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50"
                                v-for="(list, index) in [
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                    { items: [1, 2, 3, 4] },
                                ]"
                                :key="index"
                            >
                                <template v-for="item in list.items">
                                    <td class="p-2">{{ item }}</td>
                                </template>
                            </tr>
                        </template>
                    </TableList>
                    <Pagination :links="farmers.links"></Pagination>
                </div>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError class="mt-2" message="" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton>Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

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
import Icon from "@/Components/Icons.vue";
import { reactive } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";

const props = defineProps(["farmers"]);

let form = useForm(
    {
        name: "",
    },
    {
        resetOnSuccess: true,
    }
);

const modals = reactive({
    add_edit: {
        status:null,
        show: false,
        details: {
            title: "Add Farmer",
            id: 0,
        },
    },
});

const showModal = (status,data) => {
    modals.add_edit.status = status;
    modals.add_edit.details.title = status == 'edit' ? 'Edit Farmer' : status == 'delete' ? 'Delete Farmer': 'Add Farmer';
    modals.add_edit.show = true;
    if(status == 'edit' || status == 'delete'){
        form.name = data.name;
        form.id = data.id;
        form.income = data.income;
        console.log(form);
    }else{
        form.reset("name"); 
    }
    
};

const saveFarmer = () => {
    if( modals.add_edit.status == 'edit'){
        form.put(route("farmers.update",form), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Updated famers");
            form.reset("name"); 
            form.reset("id");
            form.reset("income");
            modals.add_edit.show = false;
        },
        onError: () => {
            //code
            loading.value = false;
        },
        onFinish: () => {
            //code
        },
    });
    }
    if( modals.add_edit.status == 'delete'){
        form.delete(route("farmers.delete",form), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Deleted famer");
            form.reset("name");
            modals.add_edit.show = false;
        },
        onError: () => {
            //code
            loading.value = false;
        },
        onFinish: () => {
            //code
        },
    });
    }else{
        form.post(route("farmers.store"), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Added famers");
            form.reset("name");
            modals.add_edit.show = false;
        },
        onError: () => {
            //code
            loading.value = false;
        },
        onFinish: () => {
            //code
        },
    });
    }

};
</script>

<template>
    <AppLayout title="Farmers">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2">
                    <div class="flex justify-between gap-1">
                        <PrimaryButton class="mb-2" @click="showModal('add')">New Farmer</PrimaryButton>
                        <SecondaryButton class="mb-2">Download Registration Form</SecondaryButton>
                    </div>

                    <TableList>
                        <template #header>
                            <th class="p-2 border border-l" v-for="header in ['Name','Total Income','Member since','Status',]" :key="header">
                                {{ header }}
                            </th>
                        </template>
                        <template #body>
                            <tr class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50" v-for="(farmer, index) in farmers.data"
                                :key="index">
                                <td class="p-2">
                                    <Link :href="route('farms.index', {selected_farmer: farmer.id,})">
                                        {{ farmer.name }}
                                    </Link>
                                </td>
                                <td class="p-2">{{ farmer.income }}</td>
                                <td class="p-2">{{moment(farmer.created_at).format("MMMM Do YYYY")}}
                                </td>
                                <td class="p-2">
                                    <div class="flex justify-between">
                                        <span>{{farmer.active? "Active": "Inactive"}}</span>

                                        <div class="flex flex-row-reverse gap-3">
                                            <div class="cursor-pointer"  @click="showModal('delete',farmer)">
                                                <Icon icon="delete"/>
                                            </div>
                                            <div class="cursor-pointer" @click="showModal('edit',farmer)">
                                                <Icon icon="edit" />
                                            </div>
                                        </div>
                                    </div>
                                </td>
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
                <div class="grid grid-cols-6 gap-6" v-if="modals.add_edit.status == 'delete'">
                    <div class="col-span-6">
                        Click SUBMIT to continue to remove the Farmer.
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6" v-else>
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.name"/>
                        <InputError class="mt-2" message="" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false">Cancel</SecondaryButton>
                    <PrimaryButton @click="saveFarmer">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

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
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["farms"]);

const form = useForm(
    {
        name: "",
    },
    {
        resetOnSuccess: true,
    }
);

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

const saveFarm = () => {
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
};
</script>

<template>
    <AppLayout title="Farms">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <PrimaryButton class="my-2" @click="showModal()">Add Farm</PrimaryButton>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"></div>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
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
                    <PrimaryButton @click="saveFarm">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

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

const props = defineProps(["users"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const activate = ref([]);

const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add Inventory",
            id: 0,
        },
    },
});

onMounted(() => {
    props.users.data.forEach((user) => {
        if (user.status == "active") {
            activate.value.push(true);
        } else {
            activate.value.push(false);
        }
    });
});

const showModal = () => {
    modals.add_edit.show = true;
};

const saveUser = () => {
    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Added User");
            form.reset();
            modals.add_edit.show = false;
        },
        onError: () => {
            //code
        },
        onFinish: () => {
            //code
        },
    });
};

const toggle_status = (id) => {
    Inertia.put(route("users.toggle_status", { id: id }));
};
</script>

<template>
    <AppLayout title="User Management">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2"
                >
                    <div class="flex justify-between gap-1">
                        <PrimaryButton class="mb-2" @click="showModal()"
                            >Add User</PrimaryButton
                        >
                    </div>
                    <TableList>
                        <template #header>
                            <th
                                class="p-2 border border-l"
                                v-for="header in [
                                    'Name',
                                    'Email',
                                    'Admin',
                                    'Status',
                                ]"
                            >
                                {{ header }}
                            </th>
                        </template>
                        <template #body>
                            <tr
                                class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50"
                                v-for="(user, index) in users.data"
                                :key="index"
                            >
                                <td class="p-2">
                                    {{ user.name }}
                                </td>
                                <td class="p-2">
                                    {{ user.email }}
                                </td>
                                <td class="p-2">
                                    {{ user.is_admin ? "True" : "False" }}
                                </td>
                                <td class="p-2">
                                    <div class="flex justify-between">
                                        <span class="capitalize">{{
                                            user.status
                                        }}</span>
                                        <ToggleSwitch
                                            @change="toggle_status(user.id)"
                                            v-model:checked="activate[index]"
                                        />
                                        <!-- <div
                                            class="flex flex-row-reverse gap-3"
                                        >
                                            <div class="cursor-pointer">
                                                <Icon icon="delete" />
                                            </div>
                                        </div> -->
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </TableList>
                    <Pagination :links="users.links"></Pagination>
                </div>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.name"
                        />
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Email" />
                        <TextInput
                            type="email"
                            class="mt-1 block w-full"
                            required
                            v-model="form.email"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Password" />
                        <TextInput
                            type="password"
                            class="mt-1 block w-full"
                            required
                            v-model="form.password"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Confirm Password" />
                        <TextInput
                            type="password"
                            class="mt-1 block w-full"
                            required
                            v-model="form.password_confirmation"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.password_confirmation"
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
                        :disabled="form.processing"
                        @click="saveUser()"
                        >Submit</PrimaryButton
                    >
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

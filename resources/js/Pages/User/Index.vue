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

const props = defineProps(["users", 'search']);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    search: props.search
});

const activate = ref([]);

const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add User",
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

const toggle_status = (user) => {
    if (user.is_admin == 0) {
        Inertia.put(route("users.toggle_status", { id: user.id }));
    }
};

const function_search = () => {
    form.get(route('users.index'))
}
</script>

<template>
    <AppLayout title="User Management">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2">
                    <div class="flex items-center justify-between py-4 bg-white">
                        <div class="flex justify-between gap-1">
                            <PrimaryButton class="mb-2 bg-green-500" @click="showModal()">Add User</PrimaryButton>
                        </div>
                        <div class="flex gap-1">
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
                                <input type="text" v-model="form.search" id="table-search-users"
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                    placeholder="Search for users" />
                            </div>
                            <button @click="function_search()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold ml-1 px-4 rounded">
                                Search
                            </button>
                        </div>

                    </div>
                    <table class="w-full text-sm text-left text-gray-500 rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">
                                    Administrator
                                </th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(user, index) in users.data" :key="index">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                    <img class="w-10 h-10 rounded-full" :src="user.profile_photo_url" :alt="user.name" />
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">
                                            {{ user.name }}
                                        </div>
                                        <div class="font-normal text-gray-500">
                                            {{ user.email }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ user.is_admin == 1 ? "Yes" : "No" }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div :class="
                                            user.status == 'active'
                                                ? 'h-2.5 w-2.5 rounded-full bg-green-400 mr-2'
                                                : 'h-2.5 w-2.5 rounded-full bg-red-400 mr-2'
                                        "></div>
                                        {{
                                            user.status == "active"
                                            ? "Active"
                                            : "Deactivated"
                                        }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Modal toggle -->
                                    <ToggleSwitch v-if="user.is_admin == 0" @change="toggle_status(user)"
                                        v-model:checked="activate[index]" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="">
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
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.name" />
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Email" />
                        <TextInput type="email" class="mt-1 block w-full" required v-model="form.email" />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Password" />
                        <TextInput type="password" class="mt-1 block w-full" required v-model="form.password" />
                        <InputError class="mt-1" :message="form.errors.password" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Confirm Password" />
                        <TextInput type="password" class="mt-1 block w-full" required
                            v-model="form.password_confirmation" />
                        <InputError class="mt-1" :message="form.errors.password_confirmation" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing" @click="saveUser()">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

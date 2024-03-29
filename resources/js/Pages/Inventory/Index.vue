<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Pagination from "@/Components/Pagination.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ColorInput from "@/Components/ColorInput.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Icon from "@/Components/Icons.vue";
import { reactive } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps(["categories", "inventories", "search"]);

const form = useForm({
    name: "",
    category_id: 1,
    details: {
        color: "#ed0707",
        quantity:''
    },
    search: props.search
});

const modals = reactive({
    add_edit: {
        status: null,
        show: false,
        details: {
            title: "Add Inventory",
            id: 0,
        },
    },
});

const showModal = (status, data) => {
    modals.add_edit.status = status;
    modals.add_edit.details.title =
        status == "edit"
            ? "Edit Inventory"
            : status == "delete"
                ? "Delete Inventory"
                : "Add Inventory";
    modals.add_edit.show = true;
    if (status == "edit" || status == "delete" || status == "add_quantity") {
        form.name = data.name;
        form.id = data.id;
        form.details.color = data.details.color;
        form.category_id = data.category_id;
        form.details.quantity = data?.details?.quantity??0;
    }
     else {
        form.reset("name");
    }
};

const saveInventory = () => {
    if (modals.add_edit.status == "edit") {
        form.put(route("inventory.update", form), {
            preserveScroll: true,
            onSuccess: () => {
                // alert("Updated inventory");
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
    } else if (modals.add_edit.status == "delete") {
        form.delete(route("inventory.delete", form), {
            preserveScroll: true,
            onSuccess: () => {
                // alert("Deleted inventory");
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
    } else if (modals.add_edit.status == "add") {
        form.post(route("inventory.store"), {
            preserveScroll: true,
            onSuccess: () => {
                // alert("Added Inventory");
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
    }
    else if (modals.add_edit.status == "add_quantity") {
        if(form.details.quantity < 0){
            alert('Cannot update quantity when below current quantity');
        }else{

            form.put(route("inventory.update_quantity", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                // alert("Added quantity");
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
        }

        
    }
};

const function_search = () => {
    form.get(route('inventory.index'))
}
</script>

<template>
    <AppLayout title="Inventory">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2">

                    <div class="flex items-center justify-between py-4 bg-white">
                        <a class="bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition cursor-pointer"
                            @click="showModal('add')">Add Inventory</a>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="flex">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input v-model="form.search" type="text" id="table-search-users"
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                    placeholder="Search item" />
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
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Color</th>
                                <th scope="col" class="px-6 py-3 flex justify-between">
                                    <p>Category</p>
                                    <p>Action</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(inventory, index) in inventories.data" :key="index">
                                <th scope="row" class="flex items-center px-4 py-4 text-gray-900 whitespace-nowrap">
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">
                                            {{ inventory.name }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{inventory?.details?.quantity??'None'}}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="p-2 rounded-md" :style="{
                                        backgroundColor:
                                            inventory.details.color,
                                    }"></div>
                                </td>
                                <td class="px-6 py-4 flex justify-between">
                                    <span>{{ inventory.category.name }}</span>
                                    <div class="flex flex-row-reverse gap-3">
                                        
                                        <div class="cursor-pointer" @click="
                                            showModal('delete', inventory)
                                        ">
                                            <Icon icon="delete" />
                                        </div>
                                        <div class="cursor-pointer" @click="
                                            showModal('edit', inventory)
                                        ">
                                            <Icon icon="edit" />
                                        </div>
                                        <div class="cursor-pointer" @click="
                                            showModal('add_quantity', inventory)
                                        ">
                                            <Icon icon="arrowright" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="inventories.links"></Pagination>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6" v-if="modals.add_edit.status == 'delete'">
                    <div class="col-span-6">
                        Click SUBMIT to continue to remove the Inventory.
                    </div>
                </div>
                <div v-else-if="modals.add_edit.status == 'add_quantity'" class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Quantity" />
                        <TextInput type="number" class="mt-1 block w-full" required v-model="form.details.quantity" />
                        <InputError class="mt-1" :message="form.errors.quantity" />
                    </div>
                </div>
                <div v-else class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.name" />
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>
                    <div class="col-span-4">
                        <InputLabel value="Category" />
                        <SelectInput class="block w-full mt-1" v-model="form.category_id">
                            <template v-for="category in categories" :key="category">
                                <option :value="category.id">
                                    {{ category.name }}
                                </option>
                            </template>
                        </SelectInput>
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Color" />
                        <ColorInput :disabled="form.category_id == 2" class="block w-full" v-model="form.details.color" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing" @click="saveInventory()">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
        
</AppLayout></template>

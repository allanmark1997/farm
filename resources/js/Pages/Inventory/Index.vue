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

const props = defineProps(["categories", "inventories"]);

const form = useForm({
    name: "",
    category_id: 1,
    details: {
        color: "#ed0707",
    },
});

const modals = reactive({
    add_edit: {
        status:null,
        show: false,
        details: {
            title: "Add Inventory",
            id: 0,
        },
    },
});

const showModal = (status,data) => {
    modals.add_edit.status = status;
    modals.add_edit.details.title = status == 'edit' ? 'Edit Inventory' : status == 'delete' ? 'Delete Inventory': 'Add Inventory';
    modals.add_edit.show = true;
    if(status == 'edit' || status == 'delete'){
        form.name = data.name;
        form.id = data.id;
        form.details.color = data.details.color;
        form.category_id = data.category_id;
        console.log(form);
    }else{
        form.reset("name"); 
    }
    
};

const saveInventory = () => { 
    if( modals.add_edit.status == 'edit'){
        form.put(route("inventory.update",form), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Updated inventory");
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
    else if( modals.add_edit.status == 'delete'){
        form.delete(route("inventory.delete",form), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Deleted inventory");
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
    }else if( modals.add_edit.status == 'add'){
        form.post(route("inventory.store"), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Added Inventory");
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
};
</script>

<template>
    <AppLayout title="Inventory">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2"
                >
                    <div class="flex justify-between gap-1">
                        <PrimaryButton class="mb-2" @click="showModal('add')">Add Inventory</PrimaryButton>
                    </div>
                    <TableList>
                        <template #header>
                            <th class="p-2 border border-l" v-for="header in ['Name', 'Color', 'Category']" :key="header" >
                                {{ header }}
                            </th>
                        </template>
                        <template #body>
                            <tr class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50" v-for="(inventory, index) in inventories.data"  :key="index" >
                                <td class="p-2">
                                    {{ inventory.name }}
                                </td>
                                <td class="p-2">
                                    <div class="p-2 rounded-md" :style="{ backgroundColor: inventory.details.color,}"></div>
                                </td>
                                <td class="p-2">
                                    <div class="flex justify-between">
                                        <span>{{ inventory.category.name }}</span> 
                                        <div class="flex flex-row-reverse gap-3" >
                                            <div class="cursor-pointer" @click="showModal('delete',inventory)">
                                                <Icon icon="delete" />
                                            </div>
                                            <div class="cursor-pointer" @click="showModal('edit',inventory)">
                                                <Icon icon="edit" />
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </TableList>
                    <Pagination :links="inventories.links"></Pagination>
                </div>
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
                <div v-else class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.name"/>
                        <InputError class="mt-1" :message="form.errors.name" />
                    </div>
                    <div class="col-span-4">
                        <InputLabel value="Category" />
                        <SelectInput class="block w-full mt-1" v-model="form.category_id" >
                            <template v-for="category in categories" :key="category">
                                <option :value="category.id">
                                    {{ category.name }}
                                </option>
                            </template>
                        </SelectInput>
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Color" />
                        <ColorInput :disabled="form.category_id == 2" class="block w-full" v-model="form.details.color"/>
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
    </AppLayout>
</template>

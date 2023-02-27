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
// import formPDF from "../../../../storage/Form.pdf";
import Icon from "@/Components/Icons.vue";
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import { Inertia } from "@inertiajs/inertia";
import FarmProfile from '@/Pages/Farmer/FarmerProfile.vue';

const props = defineProps(["farmers"]);
const activate = ref([]);

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
        status: null,
        show: false,
        details: {
            title: "Add Farmer",
            id: 0,
        },
    },
});
const showProfile = reactive({
    show:false,
    data:null
});


onMounted(() => {
    props.farmers.data.forEach((farmer) => {
        if (farmer.active == "1") {
            activate.value.push(true);
        } else {
            activate.value.push(false);
        }
    });
});

const profile = (data)=>{
    showProfile.show = true;
    showProfile.data = data
}
// const downloadItem = (url) => {
//     axios({
//         method: "get",
//         url,
//         responseType: "arraybuffer",
//     })
//         .then((response) => {
//             forceFileDownload(response, "Form.pdf");
//         })
//         .catch((e) => console.log(e +" error occured"));
// };
// const forceFileDownload = (response, title) => {
//     console.log(title);
//     const url = window.URL.createObjectURL(new Blob([response.data]));
//     const link = document.createElement("a");
//     link.href = url;
//     link.setAttribute("download", title);
//     document.body.appendChild(link);
//     link.click();
// };

const showModal = (status, data) => {
    modals.add_edit.status = status;
    modals.add_edit.details.title =
        status == "edit"
            ? "Edit Farmer"
            : status == "delete"
            ? "Delete Farmer"
            : "Add Farmer";
    modals.add_edit.show = true;
    if (status == "edit" || status == "delete") {
        form.name = data.name;
        form.id = data.id;
        form.income = data.income;
        console.log(form);
    } else {
        form.reset("name");
    }
};

const saveFarmer = () => {
    if (modals.add_edit.status == "edit") {
        form.put(route("farmers.update", form), {
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
    if (modals.add_edit.status == "delete") {
        form.delete(route("farmers.delete", form), {
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
    } else if (modals.add_edit.status == "add") {
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

const toggle_status = (farmer) => {
    Inertia.put(route("farmers.toggle_status", { id: farmer.id }));
};

const formatNumber = (num) => {
    return parseFloat(num).toFixed(2)
  }

const formatter = new Intl.NumberFormat('en-PH', {
style: 'currency',
currency: 'PHP'
});
</script>

<template>
    <AppLayout title="Farmers">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2" > 
                    <div class="flex items-center justify-between py-4 bg-white" > 
                        <div class="flex justify-between gap-1">
                            <a class="bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                            :href="route('farmers.add_farmer_page')" >New Farmer</a >
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none" >
                                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" >
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" ></path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="table-search-users"
                                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                placeholder="Search for users"
                            />
                        </div>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500 rounded-lg" >
                        <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg" >
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">
                                    Total Income
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Member Since
                                </th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(farmer, index) in farmers.data" :key="index">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap" >
                                    <Link :href=" route('farmers.profile', { id: farmer.id, }) ">
                                    <div>
                                        {{ farmer.name }}
                                    </div>
                                    </Link>
                                </th>
                                <td class="px-6 py-4">
                                    {{ formatter.format(formatNumber(farmer.income)) }}
                                </td>
                                <td class="px-6 py-4"> {{ moment(farmer.created_at).format( "MMMM Do YYYY")}}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div :class=" farmer.active == 1
                                                    ? 'h-2.5 w-2.5 rounded-full bg-green-400 mr-2'
                                                    : 'h-2.5 w-2.5 rounded-full bg-red-400 mr-2'  " ></div>
                                        {{ farmer.active ? "Active" : "Inactive" }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <!-- <div
                                            class="cursor-pointer mr-4"
                                            @click="showModal('delete', farmer)"
                                        >
                                            <Icon icon="delete" />
                                        </div>
                                        <div
                                            class="cursor-pointer"
                                            @click="showModal('edit', farmer)"
                                        >
                                            <Icon icon="edit" />
                                        </div> -->
                                        <div>
                                            <a
                                                :href="
                                                    route('farmers.profile', {
                                                        id: farmer.id,
                                                    })
                                                "
                                                >Profile</a
                                            >
                                        </div>
                                        <ToggleSwitch
                                            class="ml-3"
                                            @change="toggle_status(farmer)"
                                            v-model:checked="activate[index]"
                                        />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="farmers.links"></Pagination>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div
                    class="grid grid-cols-6 gap-6"
                    v-if="modals.add_edit.status == 'delete'"
                >
                    <div class="col-span-6">
                        Click SUBMIT to continue to remove the Farmer.
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-6" v-else>
                    <div class="col-span-6">
                        <InputLabel value="Name" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.name"
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
                    <PrimaryButton @click="saveFarmer">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
        <DialogModal maxWidth="7xl" :show="showProfile.show">
            <template #title>Profile</template>
            <template #content>
                <FarmProfile :farmer="showProfile.data"/>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="showProfile.show = false">Close</SecondaryButton
                    >
                    <!-- <PrimaryButton>Submit</PrimaryButton> -->
                </div>
            </template>

        </DialogModal>
    </AppLayout>
</template>

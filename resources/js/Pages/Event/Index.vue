<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableList from "@/Components/TableList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Icon from "@/Components/Icons.vue";
import Event from "./Event.vue";
import { reactive, ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

import moment from "moment";

const props = defineProps(["events", 'search']);
const post_images = ref([]);

let form = useForm(
    {
        title: "",
        content: "",
        started_at: null,
        ended_at: null,
        photos: [],
        search:props.search
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

const showModal = (status, data) => {
    modals.add_edit.status = status;
    modals.add_edit.details.title =
        status == "edit"
            ? "Edit Event"
            : status == "delete"
                ? "Delete Event"
                : "Add Event";
    modals.add_edit.show = true;
    if (status == "edit" || status == "delete") {
        form.id = data.id;
        form.title = data.title;
        form.content = data.content;
        form.started_at = data.started_at;
        form.ended_at = data.ended_at;
        console.log(form);
    } else {
        form.reset("title");
        form.reset("content");
        form.reset("started_at");
        form.reset("ended_at");
    }
};

const saveEvent = () => {
    if (modals.add_edit.status == "edit") {
        form.post(route("event.update", form), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Event Updated");
                form.reset();
                modals.add_edit.show = false;
                post_images.value = [];
                form.photos = [];
            },
            onError: () => {
                alert("Event error");
                loading.value = false;
            },
            onFinish: () => {
                //code
            },
        });
    }
    if (modals.add_edit.status == "delete") {
        form.delete(route("event.delete", form), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Event Deleted");
                form.reset("name");
                modals.add_edit.show = false;
            },
            onError: () => {
                alert("Event error");

                loading.value = false;
            },
            onFinish: () => {
                //code
            },
        });
    }
    if (modals.add_edit.status == "add") {
        if (form.started_at == null || form.ended_at == null) {
            alert("Please enter date");
        } else {
            form.post(route("event.store"), {
                preserveScroll: true,
                onSuccess: () => {
                    alert("Event Added");
                    form.reset();
                    modals.add_edit.show = false;
                    post_images.value = [];
                    form.photos = [];
                },
                onError: () => {
                    //code
                    alert(
                        "System notice an error, please fill out all fields"
                    );
                    loading.value = false;
                },
                onFinish: () => {
                    //code
                },
            });
        }
    }
};

const openFile = () => {
    let hidden = document.getElementById("post_image");
    hidden.click();
    hidden.onchange = (e) => {
        if (post_images.value.length + e.target.files.length > 1) {
            alert("Only 1 image can be selected");
            return;
        } else {
            for (let index = 0; index < e.target.files.length; index++) {
                post_images.value.push(
                    window.URL.createObjectURL(e.target.files[index])
                );
                form.photos.push(e.target.files[index]);
            }
        }
    };
};

const remove_image = (key) => {
    post_images.value.splice(key, 1);
    form.photos.splice(key, 1);
};

const function_search = () => {
    form.get(route('event.index'))
}
</script>

<template>
    <AppLayout title="Event">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2">

                    <div class="flex items-center justify-between py-4 bg-white">
                        <a class="bg-green-600 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition cursor-pointer"
                            @click="showModal('add')">New Event</a>
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
                                <input v-model="form.search" type="text"
                                    class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 m-1"
                                    placeholder="Search events" />
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
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Content</th>
                                <th scope="col" class="px-6 py-3">Image</th>
                                <th scope="col" class="px-6 py-3">
                                    Event Start
                                </th>
                                <th scope="col" class="px-6 py-3">Event End</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b" v-for="(event, index) in events.data" :key="index">
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">
                                            {{ event.title }}
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ event.content }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div v-if="event.photo == 0">None</div>
                                        <img :src="
                                            './images/events/' +
                                            event.photo[0]
                                        " alt="" style="width: 10vmin" />
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        moment(event.started_at).format(
                                            "MMMM Do YYYY"
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        moment(event.ended_at).format(
                                            "MMMM Do YYYY"
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-3">
                                        <div class="cursor-pointer" @click="showModal('edit', event)">
                                            <Icon icon="edit" />
                                        </div>
                                        <div class="cursor-pointer" @click="showModal('delete', event)">
                                            <Icon icon="delete" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :links="events.links"></Pagination>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6" v-if="modals.add_edit.status == 'delete'">
                    <div class="col-span-6">
                        Click SUBMIT to continue to remove an event.
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-3" v-else>
                    <div class="col-span-6">
                        <InputLabel value="Title" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.title" />
                        <InputError class="mt-2" message="" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Content" />
                        <TextAreaInput type="text" class="mt-1 block w-full" required v-model="form.content" />
                        <InputError class="mt-2" message="" />
                    </div>
                    <div class="col-span-4">
                        <InputLabel value="Image link" />
                        <TextInput type="text" class="mt-1 block w-full" required disabled v-model="post_images[0]" />
                        <InputError class="mt-2" message="" />
                    </div>
                    <input id="post_image" type="file" class="hidden" accept="image/png, image/gif, image/jpeg" multiple />
                    <div class="col-span-2">
                        <PrimaryButton @click="openFile" class="mt-7">Select Image</PrimaryButton>
                    </div>
                    <div class="col-span-3">
                        <InputLabel value="Event Start" />
                        <TextInput type="date" class="mt-1 block w-full" required v-model="form.started_at" />
                    </div>
                    <div class="col-span-3">
                        <InputLabel value="Event End" />
                        <TextInput type="date" class="mt-1 block w-full" required v-model="form.ended_at" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing" @click="saveEvent">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

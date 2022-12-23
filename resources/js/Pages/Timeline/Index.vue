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
import { reactive } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";

const props = defineProps(["timelines"]);

let form = useForm(
    {
        title: "",
        content: "",
        started_at: null,
        ended_at: null,
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

const saveTimeline = () => {
    if (modals.add_edit.status == "edit") {
        form.put(route("timeline.update", form), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Event Updated");
                form.reset();
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
        form.delete(route("timeline.delete", form), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Event Deleted");
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
    } if (modals.add_edit.status == "add") {
        form.post(route("timeline.store"), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Event Added");
                form.reset();
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
    <AppLayout title="Timeline">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-2">
                    <div class="flex justify-between gap-1">
                        <PrimaryButton class="mb-2" @click="showModal('add')"
                            >New Event</PrimaryButton
                        >
                    </div>
                    <TableList>
                        <template #header>
                            <th class="p-2 border border-l" v-for="header in ['Title','Content','Event Start','Event End','Action']" :key="header">
                                {{ header }}
                            </th>
                        </template>
                        <template #body> 
                            <tr class="text-md border-b border-l border-r border-gray-100 text-slate-500 hover:bg-slate-50" v-for="timeline,index in timelines"
                                :key="index">
                                <td class="p-2">
                                    {{ timeline.title }}
                                </td>
                                <td class="p-2">{{ timeline.content }}</td>
                                <td class="p-2">{{moment(timeline.started_at).format("MMMM Do YYYY")}}</td>
                                <td class="p-2">{{moment(timeline.ended_at).format("MMMM Do YYYY")}}
                                </td>
                                <td class="p-2">
                                    <div class=""> 
                                        <div class="flex justify-center items-center gap-3"> 
                                            <div class="cursor-pointer" @click="showModal('edit',timeline)">
                                                <Icon icon="edit" />
                                            </div>
                                            <div class="cursor-pointer"  @click="showModal('delete',timeline)">
                                                <Icon icon="delete"/>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </TableList>
                    <!-- <template v-for="timeline in timelines" :key="timeline">
                        <Event :timeline="timeline"></Event>
                    </template> -->
                </div>
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
                <div class="grid grid-cols-6 gap-3" v-else>
                    <div class="col-span-6">
                        <InputLabel value="Title" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.title"
                        />
                        <InputError class="mt-2" message="" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Content" />
                        <TextAreaInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.content"
                        />
                        <InputError class="mt-2" message="" />
                    </div>
                    <div class="col-span-3">
                        <InputLabel value="Event Start" />
                        <TextInput
                            type="date"
                            class="mt-1 block w-full"
                            required
                            v-model="form.started_at"
                        />
                    </div>
                    <div class="col-span-3">
                        <InputLabel value="Event End" />
                        <TextInput
                            type="date"
                            class="mt-1 block w-full"
                            required
                            v-model="form.ended_at"
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
                        @click="saveTimeline"
                        >Submit</PrimaryButton
                    >
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

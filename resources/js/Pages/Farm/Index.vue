<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import FarmCard from "@/Components/FarmCard.vue";
import Icon from "@/Components/Icons.vue";
import Map from "./Map.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";

const props = defineProps(["farms", "farmers", "selected_farmer"]);

const form = useForm({
    selected_farmer: props.selected_farmer,
    name: "",
});

const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add Farm",
            id: 0,
        },
    },
});

const selectFarmer = () => {
    Inertia.get(
        route("farms.index", { selected_farmer: form.selected_farmer })
    );
};

const showModal = () => {
    modals.add_edit.show = true;
};

const saveFarm = () => {
    form.post(route("farms.store"), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Added farm");
            form.reset("name");
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
</script>

<template>
    <AppLayout title="Farms">
        <div class="pb-4">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-2"
                >
                    <div class="grid grid-cols-8 gap-1 p-6">
                        <div class="col-span-2">
                            <InputLabel value="Farms" />
                            <div class="flex gap-1">
                                <SelectInput
                                    class="block w-full"
                                    v-model="form.selected_farmer"
                                    @change="selectFarmer()"
                                >
                                    <option value="all">All</option>
                                    <template v-for="farmer in farmers">
                                        <option :value="farmer.id">
                                            {{ farmer.name }}
                                        </option>
                                    </template>
                                </SelectInput>
                                <PrimaryButton
                                    class="w-36"
                                    @click="showModal()"
                                    :disabled="form.selected_farmer == 'all'"
                                    ><span>Add Farm</span></PrimaryButton
                                >
                            </div>
                            <div class="max-h-[720px] overflow-y-auto mt-2">
                                <template v-for="farm in farms">
                                    <FarmCard>
                                        <template #actions>
                                            <div class="cursor-pointer">
                                                <Icon icon="delete" />
                                            </div>
                                            <div class="cursor-pointer">
                                                <Icon icon="edit" />
                                            </div>
                                        </template>
                                        <template #content>
                                            <div>Name: Farm 1</div>
                                            <div>Owner: Ajeje</div>
                                            <div>Income: 100</div>
                                            <div>Color:</div></template
                                        >
                                        <template #footer>
                                            <PrimaryButton>Map</PrimaryButton>
                                            <PrimaryButton
                                                :disabled="
                                                    farm.status == 'active' ||
                                                    farm.map == null
                                                "
                                                >Plant</PrimaryButton
                                            >
                                            <PrimaryButton
                                                :disabled="
                                                    farm.status == 'idle'
                                                "
                                                >Harvest</PrimaryButton
                                            >
                                        </template>
                                    </FarmCard>
                                </template>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <Map />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <InputLabel value="Farm Name" />
                        <TextInput
                            type="text"
                            class="mt-1 block w-full"
                            required
                            v-model="form.name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_edit.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton @click="saveFarm">Submit</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

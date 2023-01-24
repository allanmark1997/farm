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
import { reactive, ref, onMounted } from "vue";

const props = defineProps([
    "farms",
    "farmers",
    "selected_farmer",
    "inventories",
    "categories",
]);
const childred = ref(null);
const enableEditMap = ref(false);

onMounted(() => {
    if (props.farms.length) {
        props.farms.map((item) => {
            if (item.map.coordinates.length) {
                callChildMethod(item);
            }
        });
    }
});

const callChildMethod = (farm) => {
    childred.value.drawMap(
        farm.map,
        farm.details.inventories,
        farm.farmer?.name,
        farm.status
    );
};
const form = useForm({
    selected_farmer: props.selected_farmer,
    map: {
        name: "",
        coordinates: [],
        color: "#ffffff",
    },
    details: {
        expected_income: 0,
        income: 0,
        inventories: {
            seedling: "",
            fertilizer: [],
        },
    },
});
const formPlants = useForm({
    id: null,
    details: {
        expected_income: 0,
        income: 0,
        inventories: {
            seedling: "",
            fertilizer: [],
        },
    },
    color: '#ffffff',
});

const modals = reactive({
    add_edit: {
        show: false,
        details: {
            title: "Add Farm",
            id: 0,
        },
    },
    add_plant: {
        show: false,
        details: {
            title: "Add Plant",
            id: 1,
        },
    },
    harvest_plant: {
        show: false,
        details: {
            title: "Harvest Plant",
            id: 2,
        },
    },
    deleteFarm: {
        show: false,
        details: {
            title: "Delete Plant",
            id: 3,
        },
    },
});

const fertilizerVar = ref({
    name: "",
    unit: "",
});

const selectFarmer = () => {
    Inertia.get(
        route("farms.index", { selected_farmer: form.selected_farmer })
    );
};

const showModal = () => {
    modals.add_edit.show = true;
};

const showModalPlant = (farm) => {
    console.log(farm);
    formPlants.id = farm.id;
    formPlants.details =
        farm.details ||
        Object.assign({
            expected_income: 0,
            income: 0,
            inventories: {
                seedling: "",
                fertilizer: [],
            },
        });
    modals.add_plant.show = true;
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

const handleMap = (farm) => {
    form.farmer_id = farm.farmer_id;
    form.farmer_id = farm.details;
    form.map.name = farm.map.name;
    form.put(route("farms.update", farm), {
        preserveScroll: true,
        onSuccess: () => {
            window.location.reload();
            childred.value.clearMarker();
            callChildMethod(form);
        },
        onError: () => {
            //code
        },
        onFinish: () => {
            //code
        },
    });
};

const mapCoordinate = (points) => {
    form.map.coordinates = points;
};

const plantHandle = () => {
    formPlants.details.datePlant = new Date();
    formPlants.put(route("farms.plant", formPlants.id), {
        preserveScroll: true,
        onSuccess: () => {
            alert("update plant");
            window.location.reload();
        },
    });
};

const harvestHandler = ()=>{ 
    formPlants.color = '#ffffff'; 
    formPlants.details.dateHarvest = new Date();
    if(formPlants.details.expected_income <= 0){
        alert("Please indicate your income.");
        return;
    }
    formPlants.put(route("farms.harvest", formPlants.id), {
        preserveScroll: true,
        onSuccess: () => {
            alert("harvest plant");
            window.location.reload();
        }
    });
}

const showHarvest = (farm) =>{
    formPlants.id = farm.id;
    formPlants.details = 
        Object.assign({
            expected_income: 0,
            income: 0,
            inventories: {
                seedling: "",
                fertilizer: [],
            },
    });
    modals.harvest_plant.show = true; 
}


const removeFilterizer = (index) => {
    let removeFertilizer = formPlants.details.inventories.fertilizer.filter(
        (item, indexItem) => indexItem != index
    );
    formPlants.details.inventories.fertilizer = removeFertilizer;
};

const onchangeColor = (e) => {
    console.log(e.target.value);
    let getPlant = props.inventories.seedling.filter(
        (item) => item.name === e.target.value
    );
    formPlants.details.inventories.seedling = getPlant[0].name;
    formPlants.color = getPlant[0].details.color;
    console.log(formPlants);
};

const onDeleteHandler = () => {
    formPlants.delete(route("farms.delete", formPlants.id), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Deleted");
            modals.deleteFarm.show = false;
            window.location.reload();
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
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-2"> 
                    <div class="grid grid-cols-8 gap-1 p-6 relative"> 
                        <div class="top-8 right-8 absolute border p-2 bg-white z-50 rounded-md" @click="enableEditMap = enableEditMap == false ? true : false ">
                            <button>Edit Map</button></div>
                        <div class="col-span-2">
                            <InputLabel value="Farms" />
                            <div class="flex gap-1">
                                <SelectInput
                                    class="block w-full"
                                    v-model="form.selected_farmer"
                                    @change="selectFarmer()"
                                >
                                    <option value="all">All</option>
                                    <template
                                        v-for="farmer in farmers"
                                        :key="farmer"
                                    >
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
                                <template v-for="farm in farms" :key="farm">
                                    <FarmCard>
                                        <template #actions>
                                            <div
                                                class="cursor-pointer"
                                                @click="
                                                    modals.deleteFarm.show = true;
                                                    formPlants.id = farm.id;
                                                "
                                            >
                                                <Icon icon="delete" />
                                            </div>
                                            <!-- <div class="cursor-pointer">
                                                <Icon icon="edit" />
                                            </div> -->
                                            <button @click="callChildMethod(farm)">
                                                <Icon icon="eye" />
                                            </button>
                                        </template>
                                        <template #content>
                                            <div>
                                                Name: {{ farm.map?.name }}
                                            </div>
                                            <div>
                                                Owner: {{ farm.farmer?.name }}
                                            </div>
                                            <div>Income: {{ farm.income }}</div>
                                            <div>Color:</div></template
                                        >
                                        <template #footer>
                                            <!-- <PrimaryButton :disabled="!farm?.map?.coordinates.length" @click="callChildMethod(farm)">View</PrimaryButton> -->
                                            <PrimaryButton :disabled="!enableEditMap"
                                                @click="handleMap(farm)">{{`${
                                                        farm?.map?.coordinates
                                                            .length
                                                            ? "Remap"
                                                            : "Map"
                                                    }`
                                                }}</PrimaryButton
                                            >
                                            <PrimaryButton
                                                :disabled="
                                                    !farm?.map?.coordinates
                                                        .length
                                                "
                                                @click="showModalPlant(farm)"
                                                >Plant</PrimaryButton
                                            >
                                            <PrimaryButton
                                                @click="showHarvest(farm)"
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
                            <Map
                                :mapCoordinate="mapCoordinate"
                                ref="childred"
                                :inventories="inventories"
                                :enableEditMap="enableEditMap"
                            />
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
                            v-model="form.map.name"
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
        <DialogModal :show="modals.harvest_plant.show">
            <template #title>{{ modals.harvest_plant.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <InputLabel value="Income" />
                        <TextInput
                            type="number"
                            class="mt-1 block w-full"
                            required
                            v-model="formPlants.details.expected_income"
                        />
                        <InputError class="mt-2" :message="formPlants.details.errors" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.harvest_plant.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton @click="harvestHandler">Continue</PrimaryButton>
                </div>
            </template>
        </DialogModal>
        <DialogModal :show="modals.add_plant.show">
            <template #title>{{ modals.add_plant.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <hr class="my-4" />
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <InputLabel value="Seedling" />
                                <SelectInput
                                    class="block w-full"
                                    @change="onchangeColor($event)"
                                    v-model="
                                        formPlants.details.inventories.seedling
                                    "
                                >
                                    <template
                                        v-for="seedling in inventories.seedling"
                                        :key="seedling"
                                    >
                                        <option :value="seedling.name">
                                            {{ seedling.name }}
                                        </option>
                                    </template>
                                </SelectInput>
                            </div>
                            <div>
                                <InputLabel value="Expected Income " />
                                <TextInput
                                    type="text"
                                    class="block w-full"
                                    required
                                    v-model="formPlants.details.expected_income"
                                />
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t-2">
                            <div class="grid grid-cols-7 gap-2">
                                <div class="col-span-3">
                                    <InputLabel value="Fertilizer" />
                                    <SelectInput
                                        class="block w-full"
                                        v-model="fertilizerVar.name"
                                    >
                                        <template
                                            v-for="fertilizer in inventories.fertilizer"
                                            :key="fertilizer"
                                        >
                                            <option :value="fertilizer.name">
                                                {{ fertilizer.name }}
                                            </option>
                                        </template>
                                    </SelectInput>
                                </div>
                                <div class="col-span-3">
                                    <InputLabel value="Unit" />
                                    <TextInput
                                        type="text"
                                        class="block w-full"
                                        required
                                        v-model="fertilizerVar.unit"
                                    />
                                </div>
                                <div class="mt-6">
                                    <PrimaryButton
                                        @click="
                                            formPlants.details.inventories.fertilizer.push(
                                                JSON.parse(
                                                    JSON.stringify(
                                                        fertilizerVar
                                                    )
                                                )
                                            )
                                        "
                                        >Add</PrimaryButton
                                    >
                                </div>
                            </div>
                            <div class="mt-2 border rounded-md p-2">
                                Lists:
                                <div
                                    v-for="(fertilizer, index) in formPlants
                                        .details.inventories.fertilizer"
                                    class="grid grid-cols-3"
                                    :key="index"
                                >
                                    <div>{{ fertilizer.name }}</div>
                                    <div>{{ fertilizer.unit }}</div>
                                    <div
                                        class="text-red-500 cursor-pointer"
                                        @click="removeFilterizer(index)"
                                    >
                                        Remove
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.add_plant.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton @click="plantHandle">Save</PrimaryButton>
                </div>
            </template>
        </DialogModal>
        <DialogModal :show="modals.deleteFarm.show">
            <template #title>{{ modals.deleteFarm.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        Are you sure you want to remove this farm?
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.deleteFarm.show = false"
                        >Cancel</SecondaryButton
                    >
                    <PrimaryButton @click="onDeleteHandler"
                        >Continue</PrimaryButton
                    >
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

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
import { getBarangayByMun } from 'phil-reg-prov-mun-brgy';
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
const children = ref(null);
const enableEditMap = ref(false);
const barangays = ref([]);



const callChildMethod = (farm) => {
    children.value.drawMap(
        farm.map,
        farm.details?.inventories,
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
    barangay: "",
    details: {
        ownership_document_no:'',
        farm_ownership:'',
        farm_owner:'',
        farm_type_business:'',
        specified_animal:'',
        farm_size:'',
        number_of_head_animal:'',
        farm_type:'',
        organic_practitioner:''
    },
});
const formPlants = useForm({
    id: null,
    plant_at:'',
    harvest_at:'',
    details: {
        expected_income: 0,
        income: 0,
        inventories: {
            seedling: "",
            seedling_quantity:1,
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
    quantity: 0,
    unit: "",
});

onMounted(() => {
    if (props.farms.length) {
        props.farms.map((item) => {
            if (item.map.coordinates.length) {
                callChildMethod(item);
            }
        });
    }

    barangays.value = getBarangayByMun('101310'); 

    if(props.selected_farmer != "all"){
        form.details.farm_owner = props.farmers.find(farmer=>farmer.id == props.selected_farmer).name
    }
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
    formPlants.reset();
    formPlants.id = farm.id;
    
    /* formPlants.details =
        farm.details ||
        Object.assign({
            expected_income: 0,
            income: 0,
            inventories: {
                seedling: "",
                fertilizer: [],
            },
        }); */
    modals.add_plant.show = true;
};

const saveFarm = () => {
    form.post(route("farms.store"), {
        preserveScroll: true,
        onSuccess: () => {
            // alert("Added farm");
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
            children.value.clearMarker();
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
    // formPlants.details.datePlant = new Date();
    formPlants.put(route("farms.plant", formPlants.id), {
        preserveScroll: true,
        onSuccess: () => {
            // alert("update plant");
            window.location.reload();
        },
    });
};

const harvestHandler = () => {
    formPlants.color = '#ffffff';
    // formPlants.details.dateHarvest = new Date();
    if (formPlants.details.income <= 0) {
        alert("Please indicate your income.");
        return;
    }
    formPlants.put(route("farms.harvest", formPlants.id), {
        preserveScroll: true,
        onSuccess: () => {
            // alert("harvest plant");
            window.location.reload();
        }
    });
}

const showHarvest = (farm) => {
    formPlants.id = farm.id;
    // alert(formPlants.details.expected_income)

    formPlants.details.expected_income = farm.details.expected_income
    // alert(farm.details.expected_income)

    // formPlants.details =
    //     Object.assign({
    //         expected_income: 0,
    //         income: 0,
    //         inventories: {
    //             seedling: "",
    //             fertilizer: [],
    //         },
    //     });
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
            // alert("Deleted");
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
                        <div class="top-8 right-8 absolute border p-2 bg-white z-50 rounded-md"
                            @click="enableEditMap = enableEditMap == false ? true : false">
                            <button>Edit Map</button>
                        </div>
                        <div class="col-span-2">
                            <InputLabel value="Farms" />
                            <div class="flex gap-1">
                                <SelectInput class="block w-full" v-model="form.selected_farmer"
                                    @change="selectFarmer()">
                                    <option value="all">All</option>
                                    <template v-for="farmer in farmers" :key="farmer">
                                        <option :value="farmer.id">
                                            {{ farmer.name }}
                                        </option>
                                    </template>
                                </SelectInput>
                                <PrimaryButton class="w-36" @click="showModal()"
                                    :disabled="form.selected_farmer == 'all'"><span>Add Farm</span></PrimaryButton>
                            </div>
                            <div class="max-h-[720px] overflow-y-auto mt-2">
                                <template v-for="farm in farms" :key="farm">
                                    <a >
                                        <FarmCard>
                                            <template #actions>
                                                <div class="cursor-pointer" @click="
    modals.deleteFarm.show = true;
formPlants.id = farm.id;
                                                ">
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
                                                <div>Color:</div>
                                            </template>
                                            <template #footer>
                                                <!-- <PrimaryButton :disabled="!farm?.map?.coordinates.length" @click="callChildMethod(farm)">View</PrimaryButton> -->
                                                <PrimaryButton :disabled="!enableEditMap" @click="handleMap(farm)">{{`${farm?.map?.coordinates
                                                        .length
                                                        ? "Remap"
                                                        : "Map"
                                                    }`
                                                }}</PrimaryButton>
                                                <PrimaryButton :disabled="
                                                    !farm?.map?.coordinates
                                                        .length || farm.status == 'farming'
                                                " @click="showModalPlant(farm)">Plant</PrimaryButton>
                                                <PrimaryButton @click="showHarvest(farm)" :disabled="
                                                    farm.status == 'idle'
                                                ">Harvest</PrimaryButton>
                                            </template>
                                        </FarmCard>
                                    </a>
                                </template>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <Map :mapCoordinate="mapCoordinate" ref="children" :inventories="inventories"
                                :enableEditMap="enableEditMap" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <DialogModal :show="modals.add_edit.show" maxWidth="7xl">
            <template #title>{{ modals.add_edit.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-2">
                    <div class="col-span-6">
                        <InputLabel value="Farm Name" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.map.name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel value="Location (Barangay & Municipality):" />
                        <select v-model="form.barangay" class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'>
                            <option value="">Select Barangay</option>
                            <template v-for="barangay in barangays">
                                <option :value="barangay.name">{{ barangay.name }}</option>
                            </template>
                        </select>
                        <InputError class="mt-2" :message="form.errors.barangay" />
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Ownership Document No: " />
                        <select
                            v-model="form.details.ownership_document_no"
                            class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                            name="" id="">
                            <option value="" selected disabled>Select type</option>
                            <option value="Certificate of Land Transfer">Certificate of Land Transfer</option>
                            <option value="Emancipation Patent">Emancipation Patent</option>
                            <option value="Individual Certificate of Land Ownership Award (CLOA)">Individual Certificate of Land Ownership Award (CLOA)</option>
                            <option value="Collective CLOA">Collective CLOA</option>
                            <option value="Co-ownership CLOA">Co-ownership CLOA</option>
                            <option value="Agricultural sales patent">Agricultural sales patent</option>
                            <option value="Homestead patent">Homestead patent</option>
                            <option value="Free Patent">Free Patent</option>
                            <option value="Certificate of Title or Regular Title">Certificate of Title or Regular Title</option>
                            <option value="Certificate of Ancestral Domain Title">Certificate of Ancestral Domain Title</option>
                            <option value="Certificate of Ancestral Land Title">Certificate of Ancestral Land Title</option>
                            <option value="Tax Declaration">Tax Declaration</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.ownership_document_no" />
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Type:" />
                        <select
                        v-model="form.details.farm_ownership"
                            class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                            name="" id="">
                            <option value="" selected disabled>Select type</option>
                            <option value="Registered Owner">Registered Owner</option>
                            <option value="Tenant">Tenant</option>
                            <option value="Lessee">Lessee</option>
                            <option value="Others">Others</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.farm_ownership" />
                    </div>
                    <div class="col-span-2" v-if="form.details.farm_ownership == 'Lessee' || form.details.farm_ownership == 'Tenant' || form.details.farm_ownership == 'Others'">
                        <InputLabel value="Name of owner:" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.details.farm_owner" />
                        <InputError class="mt-2" :message="form.errors.farm_owner" />
                    </div>
                    <div class="col-span-2">
                        <InputLabel value="Type:" />
                        <select
                        v-model="form.details.farm_type_business"
                            class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                            name="" id="">
                            <option value="" disabled selected>Select type</option>
                            <option value="Rice">Rice</option>
                            <option value="Corn">Corn</option>
                            <option value="HVC">HVC</option>
                            <option value="Livestock">Livestock</option>
                            <option value="Poultry">Poultry</option>
                            <option value="Agri-fishery">Agri-fishery</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.farm_type_business" />
                    </div>
                    <div class="col-span-3" v-if="form.details.farm_type_business == 'Livestock' || form.details.farm_type_business == 'Poultry'">
                        <InputLabel value="For Livestock & Poultry (specify type of animal)" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.details.specified_animal" />
                        <InputError class="mt-2" :message="form.errors.specified_animal" />
                    </div>
                    <div class="col-span-1">
                        <InputLabel value="Size (ha)" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.details.farm_size" />
                        <InputError class="mt-2" :message="form.errors.farm_size" />
                    </div>
                    <div class="col-span-2" v-if="form.details.farm_type_business == 'Livestock' || form.details.farm_type_business == 'Poultry'">
                        <InputLabel value="NO. OF HEAD (For Livestock and Poultry)" />
                        <TextInput type="text" class="mt-1 block w-full" required v-model="form.details.number_of_head_animal" />
                        <InputError class="mt-2" :message="form.errors.number_of_head_animal" />
                    </div>
                    <div class="col-span-2" v-if="form.details.farm_type_business != 'Agri-fishery' && form.details.farm_type_business != ''">
                        <InputLabel value="Farm type (NOTE: not applicable to agri-fishery):" />
                        <select
                        v-model="form.details.farm_type"
                            class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                            name="" id="">
                            <option value="" selected disabled>Select Type</option>
                            <option value="Irrigated">Irrigated</option>
                            <option value="Rainfed Upland">Rainfed Upland</option>
                            <option value="Rainfed Lowland">Rainfed Lowland</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.farm_type" />
                    </div>
                    <div class="col-span-1">
                        <InputLabel value="ORGANIC PRACTITIONER(Yes/No):" />
                        <select
                        v-model="form.details.organic_practitioner"
                            class='bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5'
                            name="" id="">
                            <option value="" selected disabled>Select Type</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.organic_practitioner" />
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
        <DialogModal :show="modals.harvest_plant.show">
            <template #title>{{ modals.harvest_plant.details.title }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-3">
                        <InputLabel value="Income" />
                        <TextInput type="number" class="mt-1 block w-full" required
                            v-model="formPlants.details.income" />
                        <InputError class="mt-2" :message="formPlants.details.income.errors" />
                    </div>
                    <div class="col-span-3">
                        <InputLabel value="Harvested Date" />
                        <TextInput type="date" class="mt-1 block w-full" required
                            v-model="formPlants.harvest_at" />
                        <InputError class="mt-2" :message="formPlants.harvest_at" />
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex gap-1">
                    <SecondaryButton @click="modals.harvest_plant.show = false">Cancel</SecondaryButton>
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
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <InputLabel value="Seedling" />
                                <SelectInput class="block w-full" @change="onchangeColor($event)" v-model="
                                    formPlants.details.inventories.seedling
                                ">
                                    <template v-for="seedling in inventories.seedling" :key="seedling">
                                        <option :value="seedling.name">
                                            {{ seedling.name }}
                                        </option>
                                    </template>
                                </SelectInput>
                            </div>
                            <div>
                                <InputLabel value="Quantity" />
                                <TextInput type="number" class="block w-full" required
                                    v-model="formPlants.details.inventories.seedling_quantity" />
                            </div>
                            <div>
                                <InputLabel value="Expected Income " />
                                <TextInput type="number" class="block w-full" required
                                    v-model="formPlants.details.expected_income" />
                            </div>
                            <div>
                                <InputLabel value="Planting date" />
                                <TextInput type="date" class="block w-full" required
                                    v-model="formPlants.plant_at" />
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t-2">
                            <div class="grid grid-cols-7 gap-2">
                                <div class="col-span-3">
                                    <InputLabel value="Fertilizer" />
                                    <SelectInput class="block w-full" v-model="fertilizerVar.name">
                                        <template v-for="fertilizer in inventories.fertilizer" :key="fertilizer">
                                            <option :value="fertilizer.name">
                                                {{ fertilizer.name }}
                                            </option>
                                        </template>
                                    </SelectInput>
                                </div>
                                <div class="col-span-2">
                                    <InputLabel value="Quantity" />
                                    <TextInput type="number" class="block w-full" required v-model="fertilizerVar.quantity" />
                                </div>
                                <!-- <div class="col-span-2">
                                    <InputLabel value="Unit" />
                                    <TextInput type="text" class="block w-full" required v-model="fertilizerVar.unit" />
                                </div> -->
                                <div class="mt-6">
                                    <PrimaryButton @click="
                                        formPlants.details.inventories.fertilizer.push(
                                            JSON.parse(
                                                JSON.stringify(
                                                    fertilizerVar
                                                )
                                            )
                                        )
                                    ">Add</PrimaryButton>
                                </div>
                            </div>
                            <div class="mt-2 border rounded-md p-2">
                                Lists:
                                <div v-for="(fertilizer, index) in formPlants
                                .details.inventories.fertilizer" class="grid grid-cols-3" :key="index">
                                    <div>{{ fertilizer.name }}</div>
                                    <!-- <div>{{ fertilizer.quantity + fertilizer.unit }}</div> -->
                                    <div>{{ fertilizer.quantity }}</div>
                                    <div class="text-red-500 cursor-pointer" @click="removeFilterizer(index)">
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
                    <SecondaryButton @click="modals.add_plant.show = false">Cancel</SecondaryButton>
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
                    <SecondaryButton @click="modals.deleteFarm.show = false">Cancel</SecondaryButton>
                    <PrimaryButton @click="onDeleteHandler">Continue</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </AppLayout>
</template>

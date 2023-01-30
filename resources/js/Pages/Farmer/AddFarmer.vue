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
import Parcel from "./Parcel.vue"; 
import { reactive, ref, provide } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import {regions,getCityMunByProvince,getBarangayByMun,getProvincesByRegion} from 'phil-reg-prov-mun-brgy';

const ADD_CATEGORY = {
    provinces:"Provinces",
    cities:"Cities",
    baranggays:"Baranggays"
};

const parcels = ref([]); 
const provinces = ref([]);
const baranggays = ref([]); 
const cities = ref([]);

console.log(getProvincesByRegion('01')); 

const getRegion = (event,cat)=>{ 
    if(cat === ADD_CATEGORY.provinces){ 
        description.value.address.region = JSON.parse(event.target.value);
        provinces.value = getProvincesByRegion(JSON.parse(event.target.value).reg_code);
        console.log(JSON.parse(event.target.value));
    }if(cat === ADD_CATEGORY.cities){ 
        description.value.address.province = JSON.parse(event.target.value);
        cities.value = getCityMunByProvince(JSON.parse(event.target.value).prov_code);
        console.log(cities.value);
    }if(cat === ADD_CATEGORY.baranggays){ 
        description.value.address.municpality = JSON.parse(event.target.value);
        baranggays.value = getBarangayByMun(JSON.parse(event.target.value).mun_code);
        console.log(baranggays.value);
    }else{
        description.value.address.baranngay = JSON.parse(event.target.value);
    }
}

const add_farmer = useForm({
    nname: "", 
    income: 0,
    active: true,
    photo: "",
    details: {
        parcels:[],
        fname: "",
        sname:"",
        mname:"",
        ename:"",
        gender:"",
        mobile:"",
        dateBirth:"",
        regionBirth:"",
        provinceBirth:"",
        cityBirth:"",
        baranggayBirth:"",
        streetBirth:"",
        lotBirth:"",
        regionAddress:"",
        provinceAddress:"",
        cityAddress:"",
        baranggayAddress:"",
        streetAddress:"",
        lotAddress:"",
        status:"",
        religion:"",
        nameSpouse:"",
        motherName:"",
        houseHold:"",
        houseHoldName:"",
        houseHoldRelation:"",
        householdLiving:"",
        numberMale:"",
        numberFemale:"",
        formalEducational:"",
        pwd:"",
        fourPs:"",
        IndigenousGoup:"",
        IndigenousSpecify:"",
        emergencyPerson:"",
        emergencyContact:"",
        uploadSignature:"",
        uploadThumbamark:"",
        uploadSignatureCaptain:"",
        uploadSignatureAgriculture:"",
        uploadSignatureCADC:"",
        mianLivelihood:"",
        farmActivity:"",
        farmSpecify:"",
        farmWork:"",
        farmWorkSpecify:"",
        grossFarming:"",
        grossNonFarming:"",
        grossParcel:"",
        grossARB:""

    },
});

const description = ref({
            address: {
                region: { 
                },
                province: { 
                },
                municpality: { 
                },
                baranngay:{ 
                },
                street: "",
                hose_lot: "",
            },
            farm_area: "",
            ownership: {
                document_number: "",
                owner: {
                    possess: "",
                    name: "",
                },
            },
            animals: "",
            size_ha: "",
            head_number: 0,
            type: "",
            organic: false,
});
const addFarmParcel = () => {
    add_farmer.details.parcels.push(description.value);
};

provide("add_farmer", add_farmer);
</script>

<template>
    <AppLayout title="Farms">
        <div class="pb-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <PrimaryButton class="my-2 bg-green-600" @click="showModal()">Save</PrimaryButton>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div>2x2 picture taken within 6 months</div>
                    <div>
                        <p class="text-lg text-center">
                            Part I: PERSONAL INFORMATION
                        </p>
                    </div>
                    <div class="flex m-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Surname</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>First Name</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Middle Name</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/4">
                            <InputLabel>Extension Name</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>

                    <hr />
                    <div class="flex mt-4 m-2">
                        <div class="w-1/2 mr-2">
                            <label for="Extension Name" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="">
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Mobile Number</InputLabel>
                            <TextInput type="number"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Date of Birth</InputLabel>
                            <TextInput type="date"/>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">Place of Birth</p>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Region</label>
                            <select @change="getRegion($event,ADD_CATEGORY.provinces)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Region</option>
                                <option v-for="(region,key) in regions" :key="key" :value="JSON.stringify(region)">{{region.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Province</label>
                            <select @change="getRegion($event,ADD_CATEGORY.cities)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Province</option>
                                <option v-for="(province,key) in provinces" :key="key" :value="JSON.stringify(province)">{{province.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2"> 
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Municipality/City</label>
                            <select @change="getRegion($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Municipality/City</option>
                                <option v-for="(city,key) in cities" :key="key" :value="JSON.stringify(city)">{{city.name}}</option> 
                            </select>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Baranggay</label>
                            <select @change="getRegion($event,'bara')" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Baranggay</option>
                                <option v-for="(baranggay,key) in baranggays" :key="key" :value="JSON.stringify(baranggay)">{{baranggay.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Street</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>House/Lot</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">Permanent Address</p> 
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Region</label>
                            <select @change="getRegion($event,ADD_CATEGORY.provinces)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Region</option>
                                <option v-for="(region,key) in regions" :key="key" :value="JSON.stringify(region)">{{region.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Province</label>
                            <select @change="getRegion($event,ADD_CATEGORY.cities)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Province</option>
                                <option v-for="(province,key) in provinces" :key="key" :value="JSON.stringify(province)">{{province.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2"> 
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Municipality/City</label>
                            <select @change="getRegion($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Municipality/City</option>
                                <option v-for="(city,key) in cities" :key="key" :value="JSON.stringify(city)">{{city.name}}</option> 
                            </select>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Baranggay</label>
                            <select @change="getRegion($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="" disabled selected>Baranggay</option>
                                <option v-for="(baranggay,key) in baranggays" :key="key" :value="JSON.stringify(baranggay)">{{baranggay.name}}</option> 
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Street</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>House/Lot</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label for="Status" class="block mb-2 text-sm font-medium text-gray-900"  >Status</label >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Single</option>
                                <option value="1">Widowed</option>
                                <option value="2">Maried</option>
                                <option value="3">Separated</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Religion</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Name of spouse if married</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-full">
                            <InputLabel>Mother's Maiden Name</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Household head?</InputLabel>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>If no, name of household head</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Relationship</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="mr-2 w-1/2">
                            <InputLabel>Number of living household members</InputLabel>
                            <TextInput type="number"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Number of Male</InputLabel>
                            <TextInput type="number"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Number of Female</InputLabel>
                            <TextInput type="number"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Highest Formal Educational</InputLabel >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">None</option>
                                <option value="1">Elementary</option>
                                <option value="2">High School</option>
                                <option value="3">Vocational</option>
                                <option value="4">College</option>
                                <option value="5">Post Graduate</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Person with disability (PWD)</InputLabel>
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>4P's Beneficiary?</InputLabel>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Member og Indigenous Group?</InputLabel>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel >If yes, specify</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="mr-2 w-1/2">
                            <InputLabel>Person to notify in case of emergency</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Contact number</InputLabel>
                            <TextInput type="number"/>
                        </div>
                    </div>
                    <hr />
                    <div class="mt-2 m-2">
                        <p class="text-lg text-center">Part II: FARM PROFILE</p>
                    </div>
                    <div class="flex mt-2 m-2">
                        <div class="w-full mr-2">
                            <InputLabel>Main livelihood</InputLabel>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""  id="" >
                                <option value="0">Farmer</option>
                                <option value="1">Farmworker/Laborer</option>
                                <option value="2">Fisherfolk</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">For Farmer</p>

                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Type of activity</InputLabel>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="">
                                <option value="0">Rice</option>
                                <option value="1">Corn</option>
                                <option value="2">Other crops</option>
                                <option value="3">Livestock</option>
                                <option value="4">Poultry</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Please specify</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">For Farmworker</p>

                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Kind of work</InputLabel>
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Land Preparation</option>
                                <option value="1">
                                    Planting/Transplanting
                                </option>
                                <option value="2">Cultivation</option>
                                <option value="3">Harvesting</option>
                                <option value="4">
                                    Others, Please specify
                                </option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Please specify</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">For Fisherfolk</p>
                    <p class="text-sm">
                        The lending Conduit shall coordinate with the Bureau of
                        Fisheries and Aquatic Resources(BFAR) in the issuance of
                        a certification that the fisherfolk-borrower under
                        PUNLA/PLEA is regitered under the Municipal Fisherfolk
                        Registration (FishR)
                    </p>

                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Type of Fishing Activity</InputLabel> 
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Fish Capture</option>
                                <option value="1">Fish Processing</option>
                                <option value="2">Aquaculture</option>
                                <option value="3">Fish Vending</option>
                                <option value="4">Gleaning</option>
                                <option value="5">
                                    Others, Please specify
                                </option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Please specify</InputLabel>
                            <TextInput/>
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">Gross Annual Income Last Year</p>

                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-1/2">
                            <InputLabel>Farming</InputLabel>
                            <TextInput type="text"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Non-farming</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <hr />

                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-1/2">
                            <InputLabel>Number of Parcels</InputLabel>
                            <TextInput type="number"/>
                        </div>
                        <div class="mr-2 w-1/2">
                            <InputLabel>Agrarian Reform Beneficiary (ARB)</InputLabel> 
                            <select  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name="" id="" >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                    </div>
                    <hr />

                    <div class="m-2 mt-2">
                        <PrimaryButton
                            class="bg-green-600 mb-2"
                            @click="addFarmParcel()"
                            >Add Farm Parcel</PrimaryButton
                        >
                        <Parcel />
                    </div>
                    <hr />
                    <p class="mt-4 text-md">
                        I hereby declare that all information indicated above
                        are true and correct, and that they may be used by
                        Department of Agriculture for the purposes of
                        registration to the Registry System for Basic Sectors in
                        Agriculture (RSBSA) and other legitimate interests of
                        the Department pursuant to its mandates.
                    </p>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <InputLabel>Date</InputLabel>
                            <TextInput type="date"/>
                        </div>
                        <div class="w-1/2 mr-2">
                            <InputLabel>Name of Applicant</InputLabel>
                            <TextInput type="text"/>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <PrimaryButton class="w-full"
                                >Upload Signature of applicant</PrimaryButton
                            >
                        </div>
                        <div class="w-1/2 mr-2">
                            <PrimaryButton class="w-full"
                                >Upload Thumbmark of applicant</PrimaryButton
                            >
                        </div>
                    </div>
                    <hr />
                    <p class="mt-4 text-md">VERIFIED TRUE AND CORRECT BY:</p>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <PrimaryButton class="w-full"
                                >Upload Signature above printed name of
                                Baranggay Captain</PrimaryButton
                            >
                        </div>
                        <div class="w-1/2 mr-2">
                            <PrimaryButton class="w-full"
                                >Upload Signature above printed name of
                                City/Municipal Agriculture Office</PrimaryButton
                            >
                        </div>
                        <div class="w-1/2 mr-2">
                            <PrimaryButton class="w-full"
                                >Upload Signature above printed name of
                                CAFC/MAFC Chairman</PrimaryButton
                            >
                        </div>
                    </div>
                    <hr />
                    <p class="mt-4 text-lg font-bold">DATA PRIVACY POLICY</p>
                    <p class="mt-4 text-md">
                        The collection of personal information is for
                        documentation, planning, reporting and processing
                        purposes in availing agricultural related interventions.
                        Processed data shall only be shared to partner agencies
                        for planning, reporting and other use in accordance to
                        the mandate of the agency. This is in compliance with
                        the Data Sharing Policy of the department. You have the
                        right to ask for a copy of your personal data that we
                        hold about you as well as to ask for it to be corrected
                        if you think it is wrong. To do so, please contact
                        (Contact Person and Contact Details).
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

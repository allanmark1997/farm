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
    name: "",
    income: 0,
    active: true,
    photo: "",
    details: {
        parcels: [],
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
                <PrimaryButton class="my-2 bg-green-600" @click="showModal()"
                    >Save</PrimaryButton
                >
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                >
                    <div>2x2 picture taken within 6 months</div>
                    <div>
                        <p class="text-lg text-center">
                            Part I: PERSONAL INFORMATION
                        </p>
                    </div>
                    <div class="flex m-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="text"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Surname</label
                            >
                            <input
                                type="text"
                                name="text"
                                id="Surname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Surname"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="First Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >First Name</label
                            >
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="First Name"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Middle Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Middle Name</label
                            >
                            <input
                                type="text"
                                name="middle_name"
                                id="middle_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Middle Name"
                                required=""
                            />
                        </div>
                        <div class="w-1/4">
                            <label for="Extension Name"  class="block mb-2 text-sm font-medium text-gray-900">Extension Name</label >
                            <input type="text" name="extension_name" id="extension_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Extension Name"
                                required=""
                            />
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
                            <label
                                for="Mobile Number"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Mobile Number</label
                            >
                            <input
                                type="text"
                                name="mobile_number"
                                id="mobile_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Mobile Number"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Date of Birth"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Date of Birth</label
                            >
                            <input
                                type="date"
                                name="date_of_birth"
                                id="date_of_birth"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Date of Birth"
                                required=""
                            />
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
                            <label for="Street" class="block mb-2 text-sm font-medium text-gray-900">Street</label>
                            <input type="text" name="Street" id="Street"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Street" required="" />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label for="House/Lot" class="block mb-2 text-sm font-medium text-gray-900">House/Lot</label>
                            <input type="text" name="House/Lot" id="House/Lot"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="House/Lot" required="" />
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
                            <label for="Street" class="block mb-2 text-sm font-medium text-gray-900">Street</label>
                            <input type="text" name="Street" id="Street"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Street" required="" />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label for="House/Lot" class="block mb-2 text-sm font-medium text-gray-900">House/Lot</label>
                            <input type="text" name="House/Lot" id="House/Lot"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="House/Lot" required="" />
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Status"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Status</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Single</option>
                                <option value="1">Widowed</option>
                                <option value="2">Maried</option>
                                <option value="3">Separated</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Religion"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Religion</label
                            >
                            <input
                                type="text"
                                name="religion"
                                id="religion"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Religion"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Name of spouse if married"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Name of spouse if married</label
                            >
                            <input
                                type="text"
                                name="spouse"
                                id="spouse"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Name of spouse if married"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-full">
                            <label
                                for="Mother's Maiden Name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Mother's Maiden Name</label
                            >
                            <input
                                type="text"
                                name="mother"
                                id="mother"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Mother's Maiden Name"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Household head?"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Household head?</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="If no, name of household head"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >If no, name of household head</label
                            >
                            <input
                                type="text"
                                name="household_head"
                                id="household_head"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="If no, name of household head"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Relationship"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Relationship</label
                            >
                            <input
                                type="text"
                                name="relationship"
                                id="relationship"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Relationship"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of living household members"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of living household members</label
                            >
                            <input
                                type="number"
                                name="household_total_members"
                                id="household_total_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of living household members
Number of living household members"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of Male"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of Male</label
                            >
                            <input
                                type="number"
                                name="household_male_members"
                                id="household_male_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of Male"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of Female"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of Female</label
                            >
                            <input
                                type="number"
                                name="household_female_members"
                                id="household_female_members"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of Female"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Highest Formal Educational"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Highest Formal Educational</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">None</option>
                                <option value="1">Elementary</option>
                                <option value="2">High School</option>
                                <option value="3">Vocational</option>
                                <option value="4">College</option>
                                <option value="5">Post Graduate</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Person with disability (PWD)"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Person with disability (PWD)</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="4P's Beneficiary?"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >4P's Beneficiary?</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Member og Indigenous Group?"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Member og Indigenous Group?</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Yes</option>
                                <option value="1">No</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="If yes, specify"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >If yes, specify</label
                            >
                            <input
                                type="text"
                                name="specify_indigenous_group"
                                id="specify_indigenous_group"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="If yes, specify"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="flex mt-2 m-2">
                        <div class="mr-2 w-1/2">
                            <label
                                for="Person to notify in case of emergency"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Person to notify in case of emergency</label
                            >
                            <input
                                type="text"
                                name="person_emergency"
                                id="person_emergency"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Person to notify in case of emergency"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Contact number"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Contact number</label
                            >
                            <input
                                type="text"
                                name="contact_number"
                                id="contact_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Contact number"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <div class="mt-2 m-2">
                        <p class="text-lg text-center">Part II: FARM PROFILE</p>
                    </div>
                    <div class="flex mt-2 m-2">
                        <div class="w-full mr-2">
                            <label
                                for="Main livelihood"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Main livelihood</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
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
                            <label
                                for="Type of activity"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Type of activity</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
                                <option value="0">Rice</option>
                                <option value="1">Corn</option>
                                <option value="2">Other crops</option>
                                <option value="3">Livestock</option>
                                <option value="4">Poultry</option>
                            </select>
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Please specify"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Please specify</label
                            >
                            <input
                                type="text"
                                name="specify_for_farmer"
                                id="specify_for_farmer"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Please specify"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">For Farmworker</p>

                    <div class="flex m-2 mt-2">
                        <div class="w-1/2 mr-2">
                            <label
                                for="Kind of work"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Kind of work</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
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
                            <label
                                for="Please specify"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Please specify</label
                            >
                            <input
                                type="text"
                                name="specify_for_farmworkers"
                                id="specify_for_farmworkers"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Please specify"
                                required=""
                            />
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
                            <label
                                for="Type of Fishing Activity"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Type of Fishing Activity</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
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
                            <label
                                for="Please specify"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Please specify</label
                            >
                            <input
                                type="text"
                                name="specify_for_fisherfolk"
                                id="specify_for_fisherfolk"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Please specify"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />
                    <p class="text-md">Gross Annual Income Last Year</p>

                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-1/2">
                            <label
                                for="Farming"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Farming</label
                            >
                            <input
                                type="text"
                                name="gross_income_farming"
                                id="gross_income_farming"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Farming"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Non-farming"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Non-farming</label
                            >
                            <input
                                type="text"
                                name="gross_income_non_farming"
                                id="gross_income_non_farming"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Non-farming"
                                required=""
                            />
                        </div>
                    </div>
                    <hr />

                    <div class="flex m-2 mt-2">
                        <div class="mr-2 w-1/2">
                            <label
                                for="Number of Parcels"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Number of Parcels</label
                            >
                            <input
                                type="text"
                                name="number_of_parcels"
                                id="number_of_parcels"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Number of Parcels"
                                required=""
                            />
                        </div>
                        <div class="mr-2 w-1/2">
                            <label
                                for="Agrarian Reform Beneficiary (ARB)"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Agrarian Reform Beneficiary (ARB)</label
                            >
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                name=""
                                id=""
                            >
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
                            <label
                                for="Date"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Date</label
                            >
                            <input
                                type="date"
                                name="date"
                                id="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required=""
                            />
                        </div>
                        <div class="w-1/2 mr-2">
                            <label
                                for="Date"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >Name of Applicant</label
                            >
                            <input
                                type="text"
                                name="name_of_applicant"
                                id="name_of_applicant"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required=""
                                disabled
                            />
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

<script setup>  
import PrimaryButton from "@/Components/PrimaryButton.vue"; 
import DialogModal from "@/Components/DialogModal.vue"; 
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue"; 
import { reactive, ref, provide,onBeforeMount } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import {regions,getCityMunByProvince,getBarangayByMun,getProvincesByRegion} from 'phil-reg-prov-mun-brgy';

const props = defineProps(['farmers']);
const ADD_CATEGORY = {
    provinces:"Provinces",
    cities:"Cities",
    baranggays:"Baranggays"
};

const provinces = ref([]);
const baranggays = ref([]); 
const cities = ref([]);
const provincesAdd = ref([]);
const baranggaysAdd = ref([]); 
const citiesAdd = ref([]);
const pic2x2 = ref(null);
 

const add_farmer = useForm({
    id:null,
    uploadSignature:null,
    uploadThumbamark:null,
    uploadSignatureCaptain:null,
    uploadSignatureAgriculture:null,
    uploadSignatureCADC:null,
    pic2x2:null,
    details: {  
    },
});

onBeforeMount(()=>{
    add_farmer.id = props.farmers.id
    add_farmer.details = props.farmers.details; 
    pic2x2.value = `/images/farmer/${add_farmer?.details?.pic2x2}`;
})
 
const getRegionBirth = (event,cat)=>{ 
    if(cat === ADD_CATEGORY.provinces){ 
        add_farmer.details.regionBirth = JSON.parse(event.target.value);
        provinces.value = getProvincesByRegion(JSON.parse(event.target.value).reg_code); 
    }if(cat === ADD_CATEGORY.cities){ 
        add_farmer.details.provinceBirth = JSON.parse(event.target.value);
        cities.value = getCityMunByProvince(JSON.parse(event.target.value).prov_code); 
    }if(cat === ADD_CATEGORY.baranggays){ 
        add_farmer.details.cityBirth = JSON.parse(event.target.value);
        baranggays.value = getBarangayByMun(JSON.parse(event.target.value).mun_code); 
    }if(cat === 'bara'){ 
        add_farmer.details.baranggayBirth = JSON.parse(event.target.value);
    }
}

const getRegionAddress = (event,cat)=>{
    if(cat === ADD_CATEGORY.provinces){ 
        add_farmer.details.regionAddress = JSON.parse(event.target.value);
        provincesAdd.value = getProvincesByRegion(JSON.parse(event.target.value).reg_code); 
    }if(cat === ADD_CATEGORY.cities){ 
        add_farmer.details.provinceAddress = JSON.parse(event.target.value);
        citiesAdd.value = getCityMunByProvince(JSON.parse(event.target.value).prov_code); 
    }if(cat === ADD_CATEGORY.baranggays){ 
        add_farmer.details.cityAddress = JSON.parse(event.target.value);
        baranggaysAdd.value = getBarangayByMun(JSON.parse(event.target.value).mun_code); 
    }if(cat === 'bara'){ 
        add_farmer.details.baranggayAddress = JSON.parse(event.target.value);
    }
} 
const saveForm = ()=>{ 
    add_farmer.put(route("farmers.update", add_farmer), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Updated famers");
            },
            onError: () => {
                //code
                 
            },
            onFinish: () => {
                //code
            },
        }); 
}

const openFile = (elementID) => {
    let hidden = document.getElementById(elementID);
    hidden.click();
    hidden.onchange = (e,) => {
        console.log(e.target.files);
        if(elementID === 'pic2x2'){ 
            pic2x2.value = window.URL.createObjectURL(e.target.files[0]); 
            add_farmer.pic2x2 = e.target.files[0] 
        }if(elementID == 'uploadSignature'){
            add_farmer.uploadSignature = e.target.files[0]; 
        }
        if(elementID == 'uploadThumbamark'){
            add_farmer.uploadThumbamark = e.target.files[0]; 
        }
        if(elementID == 'uploadSignatureCaptain'){
            add_farmer.uploadSignatureCaptain = e.target.files[0]; 
        }
        if(elementID == 'uploadSignatureAgriculture'){
            add_farmer.uploadSignatureAgriculture = e.target.files[0]; 
        }
        if(elementID == 'uploadSignatureCADC'){
            add_farmer.uploadSignatureCADC = e.target.files[0]; 
        }
    }; 
};

provide("add_farmer", add_farmer);
</script>

<template> 
    <div id="htmlContent">
        <div class="mx-auto sm:px-6 lg:px-8"> 
            <div class="">
                <div class="relative flex justify-between items-center">
                    <div>
                        <PrimaryButton class="my-2 bg-green-600" @click="saveForm()">Update</PrimaryButton>
                    </div>
                    
                    <div class="mt-2 lg:max-w-[20vmin] ">
                        <input id="pic2x2" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"
                                />
                        <div @click="openFile('pic2x2')" class="cursor-pointer relative flex items-center shadow-lg bg-slate-200 p-3 h-[20vmin]">
                            <img v-if="add_farmer.details.pic2x2" class="w-[20vmin] max-h-[20vmin] object-cover" :src="pic2x2" />
                            <div v-else>2x2 picture taken within 6 months</div>
                        </div>
                    </div>
                </div> 
                <div>
                    <p class="text-lg text-center"> Part I: PERSONAL INFORMATION</p>
                </div>
                <div class="flex m-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Surname</InputLabel>
                        <TextInput v-model="add_farmer.details.sname" type="text"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>First Name</InputLabel>
                        <TextInput v-model="add_farmer.details.fname" type="text"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Middle Name</InputLabel>
                        <TextInput v-model="add_farmer.details.mname" type="text"/>
                    </div>
                    <div class="w-1/4">
                        <InputLabel>Extension Name</InputLabel>
                        <TextInput v-model="add_farmer.details.ename" type="text"/>
                    </div>
                </div>

                <hr />
                <div class="flex mt-4 m-2">
                    <div class="w-1/2 mr-2">
                        <label for="Extension Name" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            v-model="add_farmer.details.gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Mobile Number</InputLabel>
                        <TextInput v-model="add_farmer.details.mobile" type="number"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Date of Birth</InputLabel>
                        <TextInput v-model="add_farmer.details.dateBirth" type="date"/>
                    </div>
                </div>
                <hr />
                <p class="text-md">Place of Birth</p>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Region</label>
                        <select @change="getRegionBirth($event,ADD_CATEGORY.provinces)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Region</option>
                            <option v-for="(region,key) in regions" :key="key" :value="JSON.stringify(region)">{{region.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Province</label>
                        <select @change="getRegionBirth($event,ADD_CATEGORY.cities)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Province</option>
                            <option v-for="(province,key) in provinces" :key="key" :value="JSON.stringify(province)">{{province.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2"> 
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Municipality/City</label>
                        <select @change="getRegionBirth($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Municipality/City</option>
                            <option v-for="(city,key) in cities" :key="key" :value="JSON.stringify(city)">{{city.name}}</option> 
                        </select>
                    </div>
                </div>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Baranggay</label>
                        <select @change="getRegionBirth($event,'bara')" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Baranggay</option>
                            <option v-for="(baranggay,key) in baranggays" :key="key" :value="JSON.stringify(baranggay)">{{baranggay.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Street</InputLabel>
                        <TextInput v-model="add_farmer.details.streetBirth" type="text"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>House/Lot</InputLabel>
                        <TextInput v-model="add_farmer.details.lotBirth" type="text"/>
                    </div>
                </div>
                <hr />
                <p class="text-md">Permanent Address</p> 
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Region</label>
                        <select @change="getRegionAddress($event,ADD_CATEGORY.provinces)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Region</option>
                            <option v-for="(region,key) in regions" :key="key" :value="JSON.stringify(region)">{{region.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Province</label>
                        <select @change="getRegionAddress($event,ADD_CATEGORY.cities)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Province</option>
                            <option v-for="(province,key) in provincesAdd" :key="key" :value="JSON.stringify(province)">{{province.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2"> 
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Municipality/City</label>
                        <select @change="getRegionAddress($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Municipality/City</option>
                            <option v-for="(city,key) in citiesAdd" :key="key" :value="JSON.stringify(city)">{{city.name}}</option> 
                        </select>
                    </div>
                </div>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <label for="Region" class="block mb-2 text-sm font-medium text-gray-900" >Baranggay</label>
                        <select @change="getRegionAddress($event,ADD_CATEGORY.baranggays)" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            <option value="" disabled selected>Baranggay</option>
                            <option v-for="(baranggay,key) in baranggaysAdd" :key="key" :value="JSON.stringify(baranggay)">{{baranggay.name}}</option> 
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Street</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.streetAddress"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>House/Lot</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.lotAddress"/>
                    </div>
                </div>
                <hr />
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <label for="Status" class="block mb-2 text-sm font-medium text-gray-900"  >Status</label >
                        <select v-model="add_farmer.details.status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" >
                            <option value="Single">Single</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Maried">Maried</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Religion</InputLabel>
                        <TextInput v-model="add_farmer.details.religion" type="text"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Name of spouse if married</InputLabel>
                        <TextInput v-model="add_farmer.details.nameSpouse" type="text"/>
                    </div>
                </div>
                <hr />
                <div class="flex m-2 mt-2">
                    <div class="mr-2 w-full">
                        <InputLabel>Mother's Maiden Name</InputLabel>
                        <TextInput v-model="add_farmer.details.motherName" type="text"/>
                    </div>
                </div>
                <hr />
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Household head?</InputLabel>
                        <select v-model="add_farmer.details.houseHold"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" >
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>If no, name of household head</InputLabel>
                        <TextInput v-model="add_farmer.details.houseHoldName" type="text"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Relationship</InputLabel>
                        <TextInput v-model="add_farmer.details.houseHoldRelation" type="text"/>
                    </div>
                </div>
                <hr />
                <div class="flex mt-2 m-2">
                    <div class="mr-2 w-1/2">
                        <InputLabel>Number of living household members</InputLabel>
                        <TextInput v-model="add_farmer.details.householdLiving" type="number"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Number of Male</InputLabel>
                        <TextInput v-model="add_farmer.details.numberMale" type="number"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Number of Female</InputLabel>
                        <TextInput v-model="add_farmer.details.numberFemale" type="number"/>
                    </div>
                </div>
                <hr />
                <div class="flex mt-2 m-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Highest Formal Educational</InputLabel >
                        <select v-model="add_farmer.details.formalEducational"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" >
                            <option value="None">None</option>
                            <option value="Elementary">Elementary</option>
                            <option value="High School">High School</option>
                            <option value="Vocational">Vocational</option>
                            <option value="College">College</option>
                            <option value="Post Graduate">Post Graduate</option>
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Person with disability (PWD)</InputLabel>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" v-model="add_farmer.details.pwd">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>4P's Beneficiary?</InputLabel>
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" v-model="add_farmer.details.fourPs">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Member og Indigenous Group?</InputLabel>
                        <select v-model="add_farmer.details.IndigenousGoup"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" >
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel >If yes, specify</InputLabel>
                        <TextInput v-model="add_farmer.details.IndigenousSpecify" type="text"/>
                    </div>
                </div>
                <hr />
                <div class="flex mt-2 m-2">
                    <div class="mr-2 w-1/2">
                        <InputLabel>Person to notify in case of emergency</InputLabel>
                        <TextInput v-model="add_farmer.details.emergencyPerson" type="text"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Contact number</InputLabel>
                        <TextInput v-model="add_farmer.details.emergencyContact" type="number"/>
                    </div>
                </div>
                <hr />
                <div class="mt-2 m-2">
                    <p class="text-lg text-center">Part II: FARM PROFILE</p>
                </div>
                <div class="flex mt-2 m-2">
                    <div class="w-full mr-2">
                        <InputLabel>Main livelihood</InputLabel>
                        <select v-model="add_farmer.details.mianLivelihood"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name=""  id="" >
                            <option value="Farmer">Farmer</option> 
                            <option value="Farmworker">Farmworker</option> 
                            <option value="Fisherfolk">Fisherfolk</option>
                        </select>
                    </div>
                </div>
                <hr />
                <p class="text-md">For Farmer</p>

                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Type of activity</InputLabel>
                        <select v-model="add_farmer.details.farmActivity"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="">
                            <option value="Rice">Rice</option>
                            <option value="Corn">Corn</option>
                            <option value="Other crops">Other crops</option>
                            <option value="Livestock">Livestock</option>
                            <option value="Poultry">Poultry</option>
                        </select>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Please specify</InputLabel>
                        <TextInput v-model="add_farmer.details.farmSpecify"  type="text"/>
                    </div>
                </div>
                <hr />
                <p class="text-md">For Farmworker</p>

                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <InputLabel>Kind of work</InputLabel>
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" v-model="add_farmer.details.farmWork">
                            <option value="Land Preparation">Land Preparation</option>
                            <option value="Planting/Transplanting">Planting/Transplanting
                            </option>
                            <option value="Cultivation">Cultivation</option>
                            <option value="Harvesting">Harvesting</option>
                            <option value="Others">
                                Others, Please specify
                            </option>
                        </select>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Please specify</InputLabel>
                        <TextInput v-model="add_farmer.details.farmWorkSpecify" type="text"/>
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
                        <select  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" v-model="add_farmer.details.fishWork">
                            <option value="Fish Capture">Fish Capture</option>
                            <option value="Fish Processing">Fish Processing</option>
                            <option value="Aquaculture">Aquaculture</option>
                            <option value="Fish Vending">Fish Vending</option>
                            <option value="Gleaning">Gleaning</option>
                            <option value="Others">
                                Others, Please specify
                            </option>
                        </select>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Please specify</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.fishWorkSpecify"/>
                    </div>
                </div>
                <hr />
                <p class="text-md">Gross Annual Income Last Year</p>

                <div class="flex m-2 mt-2">
                    <div class="mr-2 w-1/2">
                        <InputLabel>Farming</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.grossFarming"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Non-farming</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.grossNonFarming"/>
                    </div>
                </div>
                <hr />

                <div class="flex m-2 mt-2">
                    <div class="mr-2 w-1/2">
                        <InputLabel>Number of Parcels</InputLabel>
                        <TextInput v-model="add_farmer.details.grossParcel" type="number"/>
                    </div>
                    <div class="mr-2 w-1/2">
                        <InputLabel>Agrarian Reform Beneficiary (ARB)</InputLabel> 
                        <select  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            name="" id="" v-model="add_farmer.details.grossARB">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <hr />

                <!-- <div class="m-2 mt-2">
                    <PrimaryButton
                        class="bg-green-600 mb-2"
                        @click="addFarmParcel()"
                        >Add Farm Parcel</PrimaryButton
                    >
                    <Parcel />
                </div> -->
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
                        <TextInput  v-model="add_farmer.details.dateApplicant" type="date"/>
                    </div>
                    <div class="w-1/2 mr-2">
                        <InputLabel>Name of Applicant</InputLabel>
                        <TextInput type="text" v-model="add_farmer.details.nameOfApplicant"/>
                    </div>
                </div>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <input id="uploadSignature" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"/>
                        <div v-if="add_farmer.uploadSignature" class="text-green-500">Signature Uploaded</div>
                        <PrimaryButton class="w-full" @click="openFile('uploadSignature')">Upload Signature of applicant</PrimaryButton>
                    </div>
                    <div class="w-1/2 mr-2">
                        <input id="uploadThumbamark" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"/>
                        <div v-if="add_farmer.uploadThumbamark" class="text-green-500">Thumbmark Uploaded</div>
                        <PrimaryButton class="w-full" @click="openFile('uploadThumbamark')">Upload Thumbmark of applicant</PrimaryButton
                        >
                    </div>
                </div>
                <hr />
                <p class="mt-4 text-md">VERIFIED TRUE AND CORRECT BY:</p>
                <div class="flex m-2 mt-2">
                    <div class="w-1/2 mr-2">
                        <input id="uploadSignatureCaptain" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"/> 
                        <div v-if="add_farmer.uploadSignatureCaptain" class="text-green-500">Signature Baranggay Captain Uploaded</div>
                        <PrimaryButton class="w-full" @click="openFile('uploadSignatureCaptain')"
                            >Upload Signature above printed name of Baranggay Captain</PrimaryButton>
                    </div>
                    <div class="w-1/2 mr-2">
                        <input id="uploadSignatureAgriculture" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"/> 
                        <div v-if="add_farmer.uploadSignatureAgriculture" class="text-green-500">Signature City/Municipal Agriculture Office Uploaded</div>
                        <PrimaryButton class="w-full" @click="openFile('uploadSignatureAgriculture')"
                            >Upload Signature above printed name of City/Municipal Agriculture Office</PrimaryButton
                        >
                    </div>
                    <div class="w-1/2 mr-2">
                        <input id="uploadSignatureCADC" type="file" class="hidden" accept="image/png, image/gif, image/jpeg"/> 
                        <div v-if="add_farmer.uploadSignatureCADC" class="text-green-500">Signature CAFC/MAFC Chairman Uploaded</div>
                        <PrimaryButton class="w-full" @click="openFile('uploadSignatureCADC')"
                            >Upload Signature above printed name of CAFC/MAFC Chairman</PrimaryButton>
                    </div>
                </div> 
            </div>
        </div>
    </div> 
</template>

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
import { onMounted, reactive, ref,computed } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import { Inertia } from "@inertiajs/inertia";
import Profile from "./Profile/Profile.vue"; 
import TransactionPlant from "./Profile/Plant.vue";
import Harvest from "./Profile/Harvest.vue";
import EditProfile from "./Profile/EditProfile.vue";

const props = defineProps(["farmer"]);
const farmerProfile = ref(props.farmer);
const currentTab = ref('Profile');

const form = useForm({
        id: "",
    },
    {
        resetOnSuccess: true,
    });
const currentTabComponent = computed(()=>{
    switch(currentTab.value){
        case "Profile":
            return Profile;
        case "TransactionPlant":
            return TransactionPlant;
        case "Harvest":
            return Harvest;
        case "EditProfile":
            return EditProfile
    }   
});

onMounted(()=>{
    form.id = farmerProfile.value.id
})
const changeTab = (name)=>{ 
    currentTab.value = name; 
};

const  deleteProfile = ()=>{
    form.delete(route("farmers.delete", form), {
        preserveScroll: true,
        onSuccess: () => {
            alert("Deleted famer"); 
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
 

</script>
<template>
    <AppLayout title="Farmer">
        <div class="pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto sm:rounded-lg bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 pb-12 mt-2" > 
                    <div>  
                        <div class="grid grid-cols-6 gap-2">
                            <div class=" col-span-1">
                                <div class="grid grid-row-6 gap-2">
                                    <img :src="'/images/farmer/' + farmerProfile.details.pic2x2" alt="" class="object-contain h-48 w-48 border-slate-100 border shadow-lg"/>
                                    <PrimaryButton class="w-full" @click="changeTab('Profile')">Profile</PrimaryButton>
                                    <PrimaryButton class="w-full" @click="changeTab('TransactionPlant')">Plant</PrimaryButton>
                                    <PrimaryButton class="w-full" @click="changeTab('Harvest')">Harvest</PrimaryButton>
                                    <PrimaryButton class="w-full" @click="changeTab('EditProfile')">Edit Profile</PrimaryButton>
                                   <PrimaryButton class="w-full" >Print Profile</PrimaryButton> 
                                    <PrimaryButton class="w-full" @click="deleteProfile">Delete</PrimaryButton>
                                </div>
                            </div>
                            <div class="col-span-5 border shadow-lg p-2 rounded-md">
                                <component v-bind:is="currentTabComponent" :farmers="farmerProfile" ref="analysis"></component>
                                <!-- <Profile :farmer="farmer"/> -->
                            </div> 
                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>        
    
</template>

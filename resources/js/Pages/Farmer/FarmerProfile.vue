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
import Transaction from "./Profile/Transaction.vue";

const props = defineProps(["farmer"]);
const farmer = ref(props.farmer[0]);
const currentTab = ref('Profile');

const currentTabComponent = computed(()=>{
    switch(currentTab.value){
        case "Profile":
            return Profile;
        case "Transaction":
            return Transaction;
        case "Custom Script":
            return Transaction;
    }   
});

const changeTab = (name)=>{ 
    currentTab.value = name; 
};
 

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
                                    <img :src="'/images/farmer/' + farmer.details.pic2x2" alt="" class="object-contain h-48 w-48 border-slate-100 border shadow-lg"/>
                                    <PrimaryButton class="w-full" @click="changeTab('Profile')">Profile</PrimaryButton>
                                    <PrimaryButton class="w-full" @click="changeTab('Transaction')">Transaction</PrimaryButton>
                                    <PrimaryButton class="w-full" >Report</PrimaryButton>
                                    <PrimaryButton class="w-full" >Print Profile</PrimaryButton> 
                                    <PrimaryButton class="w-full" >Edit Profile</PrimaryButton>
                                </div>
                            </div>
                            <div class="col-span-5 border shadow-lg p-2 rounded-md">
                                <component v-bind:is="currentTabComponent" :farmers="farmers" ref="analysis"></component>
                                <!-- <Profile :farmer="farmer"/> -->
                            </div> 
                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>        
    
</template>

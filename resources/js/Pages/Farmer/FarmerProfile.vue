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
import { onMounted, reactive, ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import moment from "moment";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["farmer"]);
</script>
<template>
    <div> 
        <div class="grid grid-cols-6 gap-2">
            <div class="border-slate-100 border shadow-lg col-span-1">
                <img :src="'/images/farmer/' + farmer.details.pic2x2" alt="" class="object-contain h-48 w-48"/>
            </div>
            <div class="col-span-5">
                <div class="grid grid-cols-5 gap-2"> 
                    <div>
                        <div class="text-xs underline">Name</div>
                        {{ farmer.name }}
                    </div>
                    <div>
                        <div class="text-xs underline">Gender</div>
                        {{ farmer.details.gender }}
                    </div>
                    <div>
                        <div class="text-xs underline">Mobile Contact</div>
                        {{ farmer.details.mobile }}
                    </div>
                    <div>
                        <div class="text-xs underline">Date of Birth</div>
                        {{ farmer.details.dateBirth }}
                    </div>
                </div>
                <div class="border-t mt-2 pt-2">
                    <div>Place of Birth</div>
                    <div class="grid grid-cols-5 gap-2"> 
                        <div class="">
                            <div class="text-xs underline">Region</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.regionBirth.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Province</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.provinceBirth.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Municipality/City</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.cityBirth.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Baranggay</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.baranggayBirth.name }}</div>
                            
                        </div>
                    </div>
                    <div class="grid grid-cols-5 gap-2 mt-2"> 
                        <div class="col-span-2">
                            <div class="text-xs underline">Street</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.streetBirth }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline ">House/Lot</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.lotBirth }}</div>
                        </div> 
                    </div>
                </div>
                <div class="border-t mt-2 pt-2">
                    <div>Permanent Address</div>
                    <div class="grid grid-cols-5 gap-2"> 
                        <div class="">
                            <div class="text-xs underline">Region</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.regionAddress.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Province</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.provinceAddress.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Municipality/City</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.cityAddress.name }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline">Baranggay</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.baranggayAddress.name }}</div>
                            
                        </div>
                    </div>
                    <div class="grid grid-cols-5 gap-2 mt-2"> 
                        <div class="col-span-2">
                            <div class="text-xs underline">Street</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.streetAddress }}</div>
                        </div>
                        <div>
                            <div class="text-xs underline ">House/Lot</div>
                            <div class="text-[1.8vmin]">{{ farmer.details.lotAddress }}</div>
                        </div> 
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</template>

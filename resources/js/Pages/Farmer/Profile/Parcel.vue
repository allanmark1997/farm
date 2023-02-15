<template>
    <div class="border-2 border-black mt-5" >
        <div class="grid grid-cols-2"> 
                <div class=" flex items-center gap-2 pl-3 pb-2 grow">
                    <div class="text-[10px] font-bold">No. of Farm Parcels:</div>
                    <div class="text-[12px] border-b border-black w-20 mr-2 pb-1">{{ farmers?.details?.householdLiving || 'N/A' }}</div>
                </div>
                <div class=" pl-2 -mt-1 pt-1 grid grid-cols-4">
                    <div class="text-[10px] font-bold col-span-2">Agrarian Reform Beneficiary (ARB):</div>
                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="YES"/> </div> 
                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.fourPs == 'No'" label="NO"/> </div> 
                </div> 
        </div>
        <div class="border-t-2 border-black"> 
             <table>
                <thead class="border-b-2 border-black">
                    <tr>
                        <th class="w-[5%] text-[10px] border-r-2 border-black">FARM PARCEL NO.</th>
                        <th class="w-[40%] text-[10px] border-r-2 border-black">FARM LAND DESCRIPTION</th>
                        <th class="w-[15%] text-[10px] border-r-2 border-black px-2 pb-1">
                            <div>
                                CROP/COMMODITY  <span class="inline italic text-[9px]">(Rice/Corn/HVC/<br/>Livestock/Poultry/<br/>Agri-fishery) </span><br/>
                                For Livestock & Poultry<br/><span class="inline italic text[9px]">(specify type of animal)</span>
                            </div>
                        </th>
                        <th class="w-[10%] text-[10px] border-r-2 border-black">SIZE (ha)</th>
                        <th class="w-[10%] text-[10px] border-r-2 border-black">NO. OF HEAD <br/> <span class="italic text[9px]">(For Livestock and Poultry)</span></th>
                        <th class="w-[10%] text-[10px] border-r-2 border-black">FARM TYPE<br/>**</th>
                        <th class="w-[10%] text-[10px]">ORGANIC PRACTITIONER (Y/N)</th> 
                    </tr>
                </thead>
                <tr v-for="(parcel,index) in farmLand" :key="index" class="h-[200px]">
                    <td class="border-b border-black center text-xs">{{ `${index + 1}` }}</td>
                    <td class="border-b border-black">
                        <div class="flex flex-col justify-start h-full ml-2">
                            <div class="text-xs">Location (Barangay & Municipality)</div>
                            <div class="border-b w-full box-border border-black h-3"></div>
                            <div class="text-xs">
                                Total Farm Areas:<span class="inline-block w-[full] border-b border-black w-12"></span>ha
                            </div>
                            <div class="text-xs font-bold">*Ownership Document No<span class="inline-block w-[full] border-b border-black w-12"></span></div>
                            <div class="flex"> 
                                    <div class="text-xs pb-2 grow"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="Registered Owner"/> </div> 
                                    <div class="text-xs pb-2 grow"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="Others"/></div>  
                            </div>
                            <div class="text-xs pb-2 grow"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="Tenant"/></div>  
                            <div class="text-xs ml-6 -mt-2">(Name of Land Owner: <span class="inline-block w-[full] border-b border-black w-[50%]"></span>)</div>
                            <div class="text-xs pb-2 grow"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="Lessee"/></div>  
                            <div class="text-xs ml-6 -mt-2">(Name of Land Owner: <span class="inline-block w-[full] border-b border-black w-[50%]"></span>)</div>
                        </div>
                    </td> 
                    <td class="border-b border-black">
                        <div class="flex flex-col p-0 h-[200px]">
                            <div class="h-6 border-b border-black grow lastCell" v-for="(crop, c) in parcel.crops" :key="c"></div> 
                        </div>
                    </td>
                    <td class="border-b border-black">
                        <div class="flex flex-col p-0 h-[200px]" >
                            <div class="h-6 border-b border-black grow lastCell"  v-for="(size, c) in parcel.sizes" :key="c"></div> 
                        </div>
                    </td> 
                    <td class="border-b border-black">
                        <div class="flex flex-col p-0 h-[200px]" >
                            <div class="h-6 border-b border-black grow lastCell"  v-for="(head, c) in parcel.noOfHeads" :key="c"></div> 
                        </div>
                    </td>
                    <td class="border-b border-black">
                        <div class="flex flex-col p-0 h-[200px]"  >
                            <div class="h-6 border-b border-black grow lastCell" v-for="(farm, c) in parcel.farmTypes" :key="c"></div> 
                        </div>
                    </td> 
                    <td class="border-b border-black">
                        <div class="flex flex-col p-0 h-[200px] ">
                            <div class="h-6 border-b border-black grow lastCell" v-for="(organic, c) in parcel.organics" :key="c"></div> 
                        </div>
                    </td> 
                </tr>
             </table>
        </div>
    </div> 
</template>

<script setup>
import CheckTemplate from "@/Components/Check.vue";
import { ref } from "vue";
const props = defineProps({
    parcel:{
        type:Object,
        default:{}
    }
});
const farmLand = ref([{
    land:{},
    crops:[1,2,3,4,5],
    sizes:[1,2,3,4,5],
    noOfHeads:[1,2,3,4,5],
    farmTypes:[1,2,3,4,5],
    organics:[1,2,3,4,5] 
},
{
    land:{},
    crops:[1,2,3,4,5],
    sizes:[1,2,3,4,5],
    noOfHeads:[1,2,3,4,5],
    farmTypes:[1,2,3,4,5],
    organics:[1,2,3,4,5] 
},
{
    land:{},
    crops:[1,2,3,4,5],
    sizes:[1,2,3,4,5],
    noOfHeads:[1,2,3,4,5],
    farmTypes:[1,2,3,4,5],
    organics:[1,2,3,4,5] 
}])
</script>
<style scoped>
td{
    border-right: 2px solid black;
}
tr>td:last-child{
    border-right: none;
}
div>.lastCell:last-child{
    border-bottom: none;
}
</style>

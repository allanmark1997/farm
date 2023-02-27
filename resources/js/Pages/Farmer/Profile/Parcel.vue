<template>
    <div>
        <div class="border-x-2 border-t-2 border-black mt-2" >
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
                            <th class="w-[35%] text-[10px] border-r-2 border-black">FARM LAND DESCRIPTION</th>
                            <th class="w-[20%] text-[10px] border-r-2 border-black px-2 pb-1">
                                <div class="font-black">
                                    CROP/COMMODITY  <br><span class="inline italic text-[9px] font-normal">(Rice/Corn/HVC/Livestock/Poultry/<br/>Agri-fishery) </span><br/>
                                    For Livestock & Poultry<br/><span class="inline italic text[9px] font-normal pb-1">(specify type of animal)</span>
                                </div>
                            </th>
                            <th class="w-[10%] text-[10px] border-r-2 border-black">SIZE (ha)</th>
                            <th class="w-[10%] text-[10px] border-r-2 border-black">NO. OF HEAD <br/> <span class="italic text[9px]">(For Livestock and Poultry)</span></th>
                            <th class="w-[10%] text-[10px] border-r-2 border-black">FARM TYPE<br/>**</th>
                            <th class="w-[10%] text-[10px]">ORGANIC PRACTITIONER (Y/N)</th> 
                        </tr>
                    </thead>
                    <tr v-for="(item,index) in parcel" :key="index">
                        <td class="border-b border-black center text-xs">{{ `${index + 1}` }}</td>
                        <td class="border-b border-black">
                            <div class="flex flex-col justify-start h-full ml-2 text-[10px]">
                                <div class="">Location (Barangay & Municipality)</div>
                                <div class="border-b w-full box-border border-black h-3">{{ item.description?.barangay || '' }}</div>
                                <div class="">
                                    Total Farm Areas:<span class="inline-block w-[full] border-b border-black w-12">{{ item.description?.total_farm_area }}</span>ha
                                </div>
                                <div class="font-bold">*Ownership Document No <span class="inline-block w-[full] border-b border-black w-[58%] text-[8px]">{{ item.description?.ownership_document_no }}</span></div>
                                <div class="flex"> 
                                        <div class="pb-2 grow"><CheckTemplate maxWidth="md" :sizeCheck="md" :showCheck="item.description?.farm_ownership == 'Registered Owner'" label="Registered Owner"/> </div> 
                                        <div class=" pb-2 grow"><CheckTemplate maxWidth="md" :sizeCheck="md" :showCheck="item.description?.farm_ownership == 'Others'" label="Others"/></div>  
                                </div>
                                <div class="pb-2 "><CheckTemplate maxWidth="md" :sizeCheck="md" :showCheck="item.description?.farm_ownership == 'Tenant'" label="Tenant"/></div>  
                                <div class=" ml-6 -mt-2">(Name of Land Owner: <span class="inline-block w-[full] border-b border-black w-[50%]"></span>)</div>
                                <div class="pb-2 "><CheckTemplate maxWidth="md" :sizeCheck="md" :showCheck="item.description?.farm_ownership == 'Lessee'" label="Lessee"/></div>  
                                <div class="ml-6 -mt-2">(Name of Land Owner: <span class="inline-block w-[full] border-b border-black w-[50%]"></span>)</div>
                            </div>
                        </td> 
                        <td class="border-b border-black">
                            <div class="flex flex-col p-0 h-[175px]">
                                <div class="h-6 border-b border-black grow lastCell" v-for="(crop, c) in item.crops" :key="c"></div> 
                            </div>
                        </td>
                        <td class="border-b border-black">
                            <div class="flex flex-col p-0 h-[175px]" >
                                <div class="h-6 border-b border-black grow lastCell"  v-for="(size, c) in item.sizes" :key="c"></div> 
                            </div>
                        </td> 
                        <td class="border-b border-black">
                            <div class="flex flex-col p-0 h-[175px]" >
                                <div class="h-6 border-b border-black grow lastCell"  v-for="(head, c) in item.noOfHeads" :key="c"></div> 
                            </div>
                        </td>
                        <td class="border-b border-black">
                            <div class="flex flex-col p-0 h-[175px]"  >
                                <div class="h-6 border-b border-black grow lastCell" v-for="(farm, c) in item.farmTypes" :key="c"></div> 
                            </div>
                        </td> 
                        <td class="border-b border-black">
                            <div class="flex flex-col p-0 h-[175px] ">
                                <div class="h-6 border-b border-black grow lastCell" v-for="(organic, c) in item.organics" :key="c"></div> 
                            </div>
                        </td> 
                    </tr>
                 </table>
            </div>
        </div>  
        <div class="flex border-2 border-black text-[12px]">
            <div class="grid grid-cols-2 px-2 grow border-r-2 border-black pb-1">
                <div>
                    <div class="font-bold">OWNERSHIP DOCUMENT *</div>
                    <div v-for="(document,index) in documents" :key="index"> 
                        <div v-if="index <= 4" class="flex gap-4">
                            <div>{{ index + 1 }}.</div>
                            <div>{{ document }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div v-for="(document,index) in documents" :key="index"> 
                        <div v-if="index > 4" class="flex gap-4">
                            <div>{{ index + 1 }}.</div>
                            <div>{{ document }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-[38.7%] px-2 pt-3 relative">
                <div class="font-bold text-center">FARM TYPE **</div> 
                <div class="">
                    <div>1 - Irrigated</div>
                    <div>2 - Rainfed Upland</div>
                    <div>3 - Rainfed Lowland</div> 
                </div>
                <div>(NOTE: not applicable to agri-fishery)</div>
            </div>
        </div>
        <div class="border-x-2 border-b-2 border-black  py-2 text-[11px]">
            <p class="indent-4 pl-2">
                I hereby declare that all information indicated above are true and correct, and that they may be used by Department of Agriculture for the purposes of 
            registration to the Registry System for Basic Sectors in Agriculture (RSBSA) and other legitimate interests of the Department pursuant to its mandates.
            </p>
        </div>
        <div class="border-x-2 border-black">
            <div class="grid grid-cols-6 h-12">
                <div class="border-r-2 border-black"></div>
                <div class="col-span-2 border-r-2 border-black"></div>
                <div class="col-span-2 border-r-2 border-black"></div>
                <div></div> 
            </div>
            <div class="grid grid-cols-6 text-white bg-black text-center text-[10px] pb-2 -mt-1">
                <div class="border-r-2 border-black">DATE</div>
                <div class="col-span-2 border-r-2 border-black">PRINTED NAME OF APPLICANT</div>
                <div class="col-span-2 border-r-2 border-black">SIGNATURE OF APPLICANT</div>
                <div>THUMBMARK</div> 
            </div>
        </div>
        <div class="border-x-2 border-black">
            <h5 class="pl-2 text-[12px] font-bold">VERIFIED TRUE AND CORRECT BY:</h5>
            <div class="grid grid-cols-3 h-12 gap-2 px-2 text-[8px] text-center items-end">
                <div class="border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE</div>
                <div class="border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE</div>
                <div class=" border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE</div> 
            </div> 
            <div class="grid grid-cols-3 text-[10px] font-bold text-center pb-2">
                <div class="">BARANGAY CHAIRMAN</div>
                <div class="">CITY/MUNICIPAL AGRICULTURE OFFICE</div>
                <div class=" ">CAFC/MAFC CHAIRMAN</div>
                <div></div> 
            </div>
        </div>
        <div class="border-x-2 border-b-2 border-black">
            <h2 class="font-bold text-center bg-black text-white text-[11px] pb-2 -mt-1">DATA PRIVACY POLICY</h2>
            <div class="text-[10px] pb-2">
                <p class="indent-4 pl-2">The collection of personal information is for documentation, planning, reporting and processing purposes in availing agricultural related interventions. 
                    Processed data shall only be shared to partner agencies for planning, reporting and other use in accordance to the mandate of the agency. This is in 
                    compliance with the Data Sharing Policy of the department.</p>
                    <p class="indent-4 pl-2">
                        You have the right to ask for a copy of your personal data that we hold about you as well as to ask for it to be corrected if you think it is wrong. To 
                        do so, please contact Contact Person and Contact Details.
                    </p>
            </div>
        </div>
        <div class="text-center font-bold text-[12px] mt-2 mb-1">THIS FORM IS NOT FOR SALE</div>
        <div class="border-2 border-black h-36">
            <h5 class="pl-2 text-[12px] font-bold mt-4">VERIFIED TRUE AND CORRECT BY:</h5>
            <div class="grid grid-cols-3 h-[70%] gap-2 px-2 text-[8px] text-center items-end">
                <div class="border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE
                     <span class="block text-[10px] font-bold">BARANGAY CHAIRMAN</span></div>
                <div class="border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE
                    <span class="block text-[10px] font-bold">CITY/MUNICIPAL AGRICULTURE OFFICE</span>
                </div>
                <div class=" border-t border-black">SIGNATURE ABOVE PRINTED NAME / DATE
                    <span class="block text-[10px] font-bold">CAFC/MAFC CHAIRMAN</span>
                </div> 
            </div>  
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

const documents = ref([
    "Certificate of Land Transfer","Emancipation Patent","Individual Certificate of Land Ownership Award (CLOA)","Collective CLOA","Co-ownership CLOA","Agricultural sales patent",
    "Homestead patent","Free Patent","Certificate of Title or Regular Title","Certificate of Ancestral Domain Title","Certificate of Ancestral Land Title","Tax Declaration"
])

</script>
<style scoped> 
td{
    border-right: 2px solid black;
    padding: 0; 
    margin: 0;
    height: 74px;
}
tr{
    padding: 0; 
    margin: 0;
}
tr>td:last-child{
    border-right: none;
}
div>.lastCell:last-child{
    border-bottom: none;
}
table {
    border-collapse: collapse;
}
th, td {
    padding: 0;
}
</style>

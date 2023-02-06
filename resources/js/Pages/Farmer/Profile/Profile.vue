<template>
    <div>   
        <button @click="generatePdf">Print</button>
        <div class="border-2 border-black" id="htmlContent">
            <div class="grid grid-cols-5">
                <div class="col-span-4 p-2">
                    <div class="text-2xl font-bold font-serif">ANI AT KITA</div>
                    <div class="text-3xl font-bold font-serif">RSBSA ENDROLLMENT FORM</div>
                    <div class="text-xs">REGISTRY FOR BASIC SECTORS IN AGRIGCULTURE(RSBSA)</div>
                    <div class="mt-6 flex gap-5 items-center pb-4">
                        <div class="text-xs font-bold">ENDROLLMENT:</div>
                        <div class="text-xs" > <CheckTemplate :showCheck="false" label="New"/> </div>
                        <div class="text-xs"><CheckTemplate :showCheck="true" label="Existing"/> </div>
                    </div>
                    <div class="flex gap-1">
                        <div class="text-xs italic">Reference/Control No.:</div>
                        <div class="w-60 border-b border-black"></div>
                    </div>
                </div>
                <div class="border-l-2 border-black flex justify-center">
                    <img v-if="farmers.details.pic2x2" 
                    class="w-[20vmin] max-h-[20vmin] object-cover" 
                    :src="'/images/farmer/' + farmers.details.pic2x2" />
                </div>
            </div>
            <div class="font-bold text-xs bg-black text-white pb-2">
                PART I: PERSONAL INFORMATION
            </div>
            <div class="">
                <div class="profile pb-2">
                    <div class="grid grid-cols-3 gap-1 pb-1">
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px] ">{{ farmers?.details.sname }}</div>
                            <div class="text-[9px] font-bold">SURENAME</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details.fname }}</div>
                            <div class="text-[9px] font-bold">FIRST NAME</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details.mname }}</div>
                            <div class="text-[9px] font-bold">MIDDLE NAME</div>
                        </div> 
                    </div>
                    <div class="grid grid-cols-3 gap-1">
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details.sname }}</div>
                            <div class="text-xs">SURENAME</div>
                        </div>  
                        <div class="col-span-2 flex gap-4 justify-center border border-black"> 
                            <div class="text-xs font-bold flex items-center">Sex:</div>
                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.gender == 'Male'" label="Male"/> </div>
                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.gender == 'Female'" label="Female"/></div>
                        </div> 
                          
                    </div>
                </div>
                <div class="font-bold text-xs bg-black text-white pb-2 ">
                    ADDRESS
                </div>
                <div class="address">
                    <div class="grid grid-cols-3 gap-1 pb-1">
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.lotAddress || 'N/A' }}</div>
                            <div class="text-[9px] font-bold">HOUSE/LOT/BLDG. NO.</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.streetAddress || 'N/A'}}</div>
                            <div class="text-[9px] font-bold">STREET/SITIO/SUBDV</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.baranggayAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold">BARANGAY</div>
                        </div> 
                    </div>
                    <div class="grid grid-cols-3 gap-1 pb-1">
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.cityAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold">MUNICIPALITY/CITY</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.provinceAddress?.name  || 'N/A'}}</div>
                            <div class="text-[9px] font-bold">PROVINCE</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[14px]">{{ farmers?.details?.regionAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold">REGION</div>
                        </div> 
                    </div>
                </div>
                <div class="infoContact border-t-2 border-black">
                    <div class="font-bold text-xs bg-black text-white pb-2 ">
                    Birth Info
                    </div>
                    <div class="grid grid-cols-5 gap-1 pb-2 pl-3">
                        <div class=" ">  
                            <div class="text-[9px] font-bold "> DATE OF BIRTH:</div>
                            <div class="pb-1 text-[14px]">{{ farmers?.details?.dateBirth || 'N/A'}}</div>
                        </div>  
                        <div class="text-center col-span-4"> 
                            <div class="pb-1 text-[12px] border-b border-black">
                            {{farmers?.details?.lotBirth}}, {{farmers?.details?.streetBirth}},
                            {{farmers?.details?.baranggayBirth.name}}, {{farmers?.details?.cityBirth?.name}},
                            {{farmers?.details?.provinceAddress?.name}},{{farmers?.details?.regionAddress?.name}},
                            </div>
                            <div class="text-[9px] font-bold ">Birth Place</div>
                        </div>  
                    </div> 
                    <div class="grid grid-cols-3 gap-1 pb-1 border-t-2 border-black">
                        <div class=" flex items-center gap-2 pl-3"> 
                            <div class="text-[9px] font-bold">CONTACT NUMBER:</div>
                            <div class="text-text-[14px] underline">{{ farmers?.details?.mobile || 'N/A' }}</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.formalEducational || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">HIGHEST FORMAL EDUCATION</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.pwd || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">PERSON WITH DISABILITY (PWD)</div>
                        </div> 
                    </div> 
                    <div class="grid grid-cols-4 gap-1 pb-1 border-t-2 border-black">
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.religion || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">RELIGION</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.status || 'N/A'}}</div>
                            <div class="text-[9px] font-bold "> CIVIL STATUS</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.nameSpouse || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">NAME OF SPOUSE IF MARRIED</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.motherName || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">MOTHER’S MAIDEN NAME</div>
                        </div> 
                    </div> 
                    <div class="font-bold text-xs bg-black text-white pb-2 ">
                        Indigenous Info
                    </div>
                    <div class="grid grid-cols-4 gap-1 pb-1 border-t-2 border-black">
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.fourPs || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">4P’s Beneficiary?</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.IndigenousGoup || 'N/A'}}</div>
                            <div class="text-[9px] font-bold "> Member of an Indigenous Group?</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.IndigenousSpecify || 'N/A'}}</div>
                            <div class="text-[9px] font-bold "> If yes, specify:</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.govermentID || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">With Government ID?</div>
                        </div> 
                    </div>
                </div>
                <div class="font-bold text-xs bg-black text-white pb-2 ">
                    Household
                </div>
                <div class="household">
                    <div class="grid grid-cols-3 gap-1 pb-1 border-t-2 border-black">
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.houseHold || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">HOUSEHOLD HEAD?</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.houseHoldName || 'N/A'}}</div>
                            <div class="text-[9px] font-bold "> If no, name of household head:</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.houseHoldRelation || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">Relationship</div>
                        </div>  
                    </div> 
                    <div class="grid grid-cols-3 gap-1 pb-1 border-t-2 border-black">
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.householdLiving || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">No. of living household members:</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.numberMale || 'N/A'}}</div>
                            <div class="text-[9px] font-bold "> No. of male:</div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[14px] border-b border-black">{{ farmers?.details?.numberFemale || 'N/A'}}</div>
                            <div class="text-[9px] font-bold ">No. of female:</div>
                        </div>  
                    </div> 
                </div>
                <div class="font-bold text-xs bg-black text-white pb-2 ">
                    PART II: FARM PROFILE
                </div>
                <div class="farmNaNila">
                    <div class="grid grid-cols-4 gap-1 pb-1 border-t-2 border-black items-center pt-2">
                        <div class="text-center"> 
                            <div class="pb-1 text-[11px] font-bold">MAIN LIVELIHOOD</div>
                        </div>  
                        <div class="text-center">  
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Farmer'" label="Farmer"/> </div>
                        </div> 
                        <div class="text-center"> 
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Farmworker'" label="FARMWORKER/LABORER"/></div>
                        </div>  
                        <div class="text-center"> 
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Fisherfolk'" label="FISHERFOLK"/></div>
                        </div> 
                    </div> 

                    <div class="grid grid-cols-3 gap-1 pb-1 border-y-2 border-black justify-center text-[12px]">
                        <div class="border-r-2 border-black"> 
                            <div class="pb-1 font-bold italic underline text-center">For farmers:</div>
                            <div class=" pl-2 pb-1 font-bold"> Type of Farming Activity </div>
                            <div  class=" pl-2 pb-1 grid grid-flow-row">
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Rice'" label="Rice"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Corn'" label="Corn"/> </div>
                                <div class="">
                                    <CheckTemplate :showCheck="farmers?.details?.farmActivity == 'Other crops'" label="Other crops"/>
                                    <div class="flex pl-4 ">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Other crops' ? farmers?.details?.farmSpecify : '' }}</div></div>
                                </div> 
                                <div><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Livestock'" label="Livestock"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Livestock' ? farmers?.details?.farmSpecify : '' }}</div></div>
                                <div><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Poultry'" label="Poultry"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Poultry' ? farmers?.details?.farmSpecify : '' }}</div></div>
                            </div>
                        </div>  
                        <div class="">  
                            <div class="pb-1 text-center font-bold italic underline">For farmworkers:</div>
                            <div class="pb-1 pl-1 font-bold"> Kind of Work </div>
                            <div  class=" pl-2 pb-1">
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Land Preparation'" label="Land Preparation"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == ' Planting/Transplanting'" label=" Planting/Transplanting"/> </div>
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Cultivation'" label="Cultivation"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Harvesting'" label="Harvesting"/> </div>
                                <div><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Livestock'" label="Others"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Livestock' ? farmers?.details?.farmSpecify : '' }}</div></div>
                                 
                            </div>
                        </div> 
                        <div class="border-l-2 border-black "> 
                            <div class="pb-1 text-[10px] font-bold italic underline text-center">For fisherfolk:</div>
                            <div  class="pl-2 pb-1 text-[8px] font-bold">
                                The Lending Conduit shall coordinate with the Bureau of Fisheries and Aquatic Resources (BFAR) in the issuance of
                                a certification that the fisherfolk-borrower under PUNLA/ PLEA is registered under the Municipal Fisherfolk Registration (FishR)
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div> 
      
 
    <!-- <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">farmers, For Farmworker, and Fisherfolk</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Type of activity(For farmers)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.farmActivity || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Please specify(For farmers)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.farmSpecify || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Kind of work(Farmworker)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.farmWork || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Please specify(Farmworker)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.farmWorkSpecify || "N/A"}}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div>
                <div class="text-xs underline">Type of Fishing Activity</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.fishWork || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline ">Please specify(Fisherfolk)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.fishWorkSpecify || "N/A"}}</div>
            </div>  
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Gross Annual Income Last Year</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Farming</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.grossFarming || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Non-farming</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.grossNonFarming || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Number of Parcels</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.grossParcel || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Agrarian Reform Beneficiary (ARB)</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.grossARB || "N/A"}}</div>
                
            </div>
        </div> 
    </div>  -->
    </div>
</template>
<script setup>
import html2pdf from "html2pdf.js";
import CheckTemplate from "@/Components/Check.vue"
 defineProps({
    farmers: {
        type:Object,
        default: {},
    },
 });


 const generatePdf = () => {
        html2pdf(document.getElementById("htmlContent"), {
            margin: 4,
            filename: "i-was-html.pdf", 
        });
}

</script>

<template>
    <div>   
        <div class="text-center text-xl mb-2">PROFILE</div>
        <div class="grid grid-cols-4 gap-2"> 
        <div>
            <div class="text-xs underline">Name</div>
            {{ farmers?.name }}
        </div>
        <div>
            <div class="text-xs underline">Gender</div>
            {{ farmers?.details?.gender }}
        </div>
        <div>
            <div class="text-xs underline">Mobile Contact</div>
            {{ farmers?.details?.mobile }}
        </div>
        <div>
            <div class="text-xs underline">Date of Birth</div>
            {{ farmers?.details?.dateBirth }}
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Place of Birth</div>  
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Region</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.regionBirth?.name || "N/A" }}</div>
            </div>
            <div>
                <div class="text-xs underline">Province</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.provinceBirth?.name || "N/A" }}</div>
            </div>
            <div>
                <div class="text-xs underline">Municipality/City</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.cityBirth?.name || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Baranggay</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.baranggayBirth?.name || "N/A"}}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2"> 
            <div class="col-span-2">
                <div class="text-xs underline">Street</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.streetBirth || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline ">House/Lot</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.lotBirth || "N/A"}}</div>
            </div> 
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Permanent Address</div> 
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Region</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.regionAddress?.name || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Province</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.provinceAddress?.name || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Municipality/City</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.cityAddress?.name || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Baranggay</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.baranggayAddress?.name || "N/A"}}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div class="col-span-2">
                <div class="text-xs underline">Street</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.streetAddress || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline ">House/Lot</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.lotAddress || "N/A"}}</div>
            </div> 
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Household</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Household head</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.houseHold || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">If no, name of household head</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.houseHoldName || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Relationship</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.houseHoldRelation || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline">Number of living household members</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.householdLiving || "N/A"}}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div>
                <div class="text-xs underline">Number of Male</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.numberMale || "N/A"}}</div>
            </div>
            <div>
                <div class="text-xs underline ">Number of Female</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.numberFemale || "N/A"}}</div>
            </div> 
            <div>
                <div class="text-xs underline ">Mother's Maiden Name</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.motherName || "N/A"}}</div>
            </div>
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Part II: FARM PROFILE</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Main livelihood</div>
                <div class="text-[1.8vmin]">{{ farmers?.details?.mianLivelihood || "N/A"}}</div>
            </div> 
        </div> 
    </div>
    <div class="border-t mt-2 pt-2">
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
    </div> 
    </div>
</template>
<script setup>
 defineProps({
    farmers: {
        type:Object,
        default: {},
    },
 });

</script>

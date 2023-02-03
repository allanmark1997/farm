<template>
    <div>   
        <div class="text-center text-xl mb-2">PROFILE</div>
        <div class="grid grid-cols-4 gap-2"> 
        <div>
            <div class="text-xs underline">Name</div>
            {{ farmer?.name }}
        </div>
        <div>
            <div class="text-xs underline">Gender</div>
            {{ farmer?.details?.gender }}
        </div>
        <div>
            <div class="text-xs underline">Mobile Contact</div>
            {{ farmer?.details?.mobile }}
        </div>
        <div>
            <div class="text-xs underline">Date of Birth</div>
            {{ farmer?.details?.dateBirth }}
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Place of Birth</div>  
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Region</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.regionBirth?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Province</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.provinceBirth?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Municipality/City</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.cityBirth?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Baranggay</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.baranggayBirth?.name }}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-5 gap-2 mt-2"> 
            <div class="col-span-2">
                <div class="text-xs underline">Street</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.streetBirth }}</div>
            </div>
            <div>
                <div class="text-xs underline ">House/Lot</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.lotBirth }}</div>
            </div> 
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Permanent Address</div> 
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Region</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.regionAddress?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Province</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.provinceAddress?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Municipality/City</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.cityAddress?.name }}</div>
            </div>
            <div>
                <div class="text-xs underline">Baranggay</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.baranggayAddress?.name }}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div class="col-span-2">
                <div class="text-xs underline">Street</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.streetAddress }}</div>
            </div>
            <div>
                <div class="text-xs underline ">House/Lot</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.lotAddress }}</div>
            </div> 
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Household</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Household head</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.houseHold }}</div>
            </div>
            <div>
                <div class="text-xs underline">If no, name of household head</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.houseHoldName }}</div>
            </div>
            <div>
                <div class="text-xs underline">Relationship</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.houseHoldRelation }}</div>
            </div>
            <div>
                <div class="text-xs underline">Number of living household members</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.householdLiving }}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div>
                <div class="text-xs underline">Number of Male</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.numberMale }}</div>
            </div>
            <div>
                <div class="text-xs underline ">Number of Female</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.numberFemale }}</div>
            </div> 
            <div>
                <div class="text-xs underline ">Mother's Maiden Name</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.motherName }}</div>
            </div>
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Part II: FARM PROFILE</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Main livelihood</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.mianLivelihood }}</div>
            </div> 
        </div> 
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Farmer, For Farmworker, and Fisherfolk</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Type of activity(For Farmer)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.farmActivity }}</div>
            </div>
            <div>
                <div class="text-xs underline">Please specify(For Farmer)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.farmSpecify }}</div>
            </div>
            <div>
                <div class="text-xs underline">Kind of work(Farmworker)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.farmWork }}</div>
            </div>
            <div>
                <div class="text-xs underline">Please specify(Farmworker)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.farmWorkSpecify }}</div>
                
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 mt-2"> 
            <div>
                <div class="text-xs underline">Type of Fishing Activity</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.fishWork }}</div>
            </div>
            <div>
                <div class="text-xs underline ">Please specify(Fisherfolk)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.fishWorkSpecify }}</div>
            </div>  
        </div>
    </div>
    <div class="border-t mt-2 pt-2">
        <div class="text-center text-xl mb-2">Gross Annual Income Last Year</div>
        <div class="grid grid-cols-4 gap-2"> 
            <div class="">
                <div class="text-xs underline">Farming</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.grossFarming }}</div>
            </div>
            <div>
                <div class="text-xs underline">Non-farming</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.grossNonFarming }}</div>
            </div>
            <div>
                <div class="text-xs underline">Number of Parcels</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.grossParcel }}</div>
            </div>
            <div>
                <div class="text-xs underline">Agrarian Reform Beneficiary (ARB)</div>
                <div class="text-[1.8vmin]">{{ farmer?.details?.grossARB }}</div>
                
            </div>
        </div> 
    </div> 
    </div>
</template>
<script setup>
 defineProps({
    farmer: {
        type:Object,
        default: {},
    },
 });

</script>

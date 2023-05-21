<template>
    <div> 
        <div class="text-center text-xl mb-2">Transaction in Harvest</div>
        <table class="w-full text-sm text-left text-gray-500 rounded-lg" >
            <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg" >
                <tr>
                    <th scope="col" class="px-6 py-3">Harvest Date</th>    
                    <th scope="col" class="px-6 py-3">  Expected Income</th> 
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b" v-for="(plants, index ) in plants" :key="index" >
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap" >
                        <div class="pl-3">
                            {{ moment(plants.harvest_at ).format("MMMM Do YYYY") }}
                        </div>
                    </th>     
                    <td class="px-6 py-4">
                        <span class="mr-1"></span>{{ formatter.format(formatNumber(plants.details.expected_income)) }}
                    </td> 
                </tr>
            </tbody>
        </table>
        <!-- <div v-for="(plant,index) in plants" :key="index">
            <div>{{ plant.details.expected_income }}</div>
        </div> -->
    </div>
</template>
<script setup>
import { ref } from 'vue'; 
import moment from "moment";
const props = defineProps(['farmers']);
const plants = ref(
    props.farmers?.transactions.filter(item => item.type === 'harvest')
)
const formatter = new Intl.NumberFormat('en-PH', {
    style: 'currency',
    currency: 'PHP'
});

const formatNumber = (num) => {
    return parseFloat(num).toFixed(2)
}
</script>

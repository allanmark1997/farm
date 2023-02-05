<template>
    <div> 
        <div class="text-center text-xl mb-2">Transaction in Plants</div>
        <table class="w-full text-sm text-left text-gray-500 rounded-lg" >
            <thead class="text-xs text-gray-700 uppercase bg-green-300 rounded-lg" >
                <tr>
                    <th scope="col" class="px-6 py-3">Date</th>   
                    <th scope="col" class="px-6 py-3">Seedlings</th>
                    <th scope="col" class="px-6 py-3">Fertilizers</th>
                    <th scope="col" class="px-6 py-3">  Expected Income</th> 
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b" v-for="(plant, index ) in plants" :key="index" >
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap" >
                        <div class="pl-3">
                            {{ moment(plant.created_at ).format("MMMM Do YYYY") }}
                        </div>
                    </th>    
                    <td class="px-6 py-4">
                        {{ plant.details.inventories.seedling}}
                    </td>
                    <td class="px-6 py-4"> 
                        <template v-for="( fertilizer, fer ) in plant.details.inventories.fertilizer" :key="fer">
                            <p>Name: {{ fertilizer.name }}</p>
                            <p>Unit: {{ fertilizer.unit }}</p>
                            <p></p>
                        </template> 
                    </td>
                    <!-- <td class="px-6 py-4">
                        {{ plant.farm?.map?.name}}
                    </td> -->
                    
                    <td class="px-6 py-4">
                        <span class="mr-1">&#8369;</span>{{ plant.details.expected_income }}
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
    props.farmers?.transactions.filter(item => item.type === 'plant')
)
</script>

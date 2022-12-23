<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import formImg from '../../assets/farm.jpg'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String, 
    timelines: String
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative bg-slate-100">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block z-20">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-blue-700 dark:text-blue-900 underline">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-blue-700 dark:text-gray-500 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
        </div> 
        <div class="relative">   
            <div class="text-white text-[4vmin] font-bold relative bg-hero bg-no-repeat bg-cover bg-center bg-fixed h-[55vh] flex flex-col justify-center items-center" style="background-image: url('http://[::1]:5173/resources/assets/farm.jpg')"> 
                <div>
                    Growing strong, from the ground up.
                </div>
                <div>
                    Nurturing the land, nourishing the soul.
                </div>
                <div>
                    From seed to harvest, we cultivate success.
                </div>
            </div>
            </div>   
            <div class=" bg-slate-100 py-4">
                <div class="flex justify-center items-center font-bold text-xl pb-6">
                    Events
                </div> 
                    <div class="grid grid-cols-8 mx-6 gap-4">
                        <div class="col-span-2 border rounded-md shadow-lg" v-for="timeline, index in timelines" :key="index">
                            <div class="p-2 flex flex-col">
                                <div class="font-bold my-2 flex justify-center items-center">{{ timeline.title }}</div>
                                <div class="p-2">{{  timeline.content }}</div>
                                <div class="flex justify-between text-xs p-x-2 gap-2 py-4 italic">
                                    <div> 
                                        {{  timeline.started_at }}
                                    </div>
                                    <div> 
                                        {{  timeline.ended_at }}
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
            </div>
            <div class=" bg-slate-100 py-4">
                <div class="flex justify-center items-center font-bold text-xl pb-6">
                    Objectives
                </div> 
                <div class="flex justify-center items-center mx-14">
                    <div class="border py-4 px-12 rounded-lg shadow-lg">
                        "Accurate mapping of your land: This will help you to have a clear understanding of the size and shape of your land, as well as the location of different features such as fields, irrigation systems, and buildings.
                        Monitoring crop health and growth: By regularly monitoring your crops, you can identify any issues that may be affecting their health or growth, such as pests, diseases, or nutrient deficiencies.
                        Optimizing crop management practices: By analyzing data on crop health and growth, you can determine which management practices are most effective for your specific crops and conditions. This may include adjusting irrigation schedules, applying fertilizers, or implementing pest control measures.
                        Identifying areas of potential yield loss: By monitoring crops over time, you can identify areas where yields are consistently lower than expected, which may be due to issues such as soil quality, irrigation problems, or pest infestations."
                    </div>
                </div>
                <div>
                    
                </div>
            </div>
            <div class=" bg-slate-100 py-4">
                <div class="flex justify-center items-center font-bold text-xl pb-6">
                    Contacts
                </div> 
            </div>
        </div>  
</template>

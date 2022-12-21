<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import formImg from '../../assets/farm.jpg'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative bg-gray-100 dark:bg-gray-900">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block z-20">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-blue-700 dark:text-blue-900 underline">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-blue-700 dark:text-gray-500 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>
            </template>
        </div> 
        <div class="relative flex flex-col">  
            <div>
                <div class="relative">
                    <div class="absolute top-0 left-0 z-10">
                    <img src="../../assets/farm.jpg" class="w-[1600px]"/>
                </div> 
                </div>
                    <div class="relative z-20 flex justify-center">
                        Test
                    </div>
            </div> 
            <div>Osmer Vinarao</div>
        </div>
    </div> 
</template>

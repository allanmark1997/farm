<template>
    <div v-if="showCheck" class="flex gap-1">
        <div class="border border-2 border-black mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" :class="sizeCheckClass">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
            </svg> 
        </div>
        <div>
            {{ label }}
        </div>
        
    </div>
    <div v-else class="flex gap-1">
        <div class="border border-2 border-black mt-1" :class="maxWidthClass"> 
        </div>
        <div>
            {{ label }}
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue';
const props = defineProps({
    showCheck:{
        type:Boolean,
        default:false
    },
    label:{
        type:String,
        default:false
    },
    maxWidth:{
        type:String,
        default:"lg"
    },
    sizeCheck:{
        type:String,
        default:"lg"
    }
});

const maxWidthClass = computed(() => {
    return { 
        'md': 'w-3 h-3',
        'lg': 'w-4 h-4', 
    }[props.maxWidth];
});

const sizeCheckClass = computed(() => {
    return { 
        'md': 'w-2 h-2',
        'lg': 'w-3 h-3', 
    }[props.sizeCheck];
});
</script>

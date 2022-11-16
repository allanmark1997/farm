<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import {onMounted, ref} from "vue";
import leaflet from "leaflet";

const markers = ref([]); 
const colorInput = ref(null);
let mymap;

onMounted(()=>{ 
  mymap = leaflet.map("mapid").setView([7.997357, 125.027804], 15);
  leaflet.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    maxZoom: 19,
    subdomains:['mt0','mt1','mt2','mt3'],
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(mymap);
  mymap.on('click', onMapClick);
});

const onMapClick = (e)=>{
  var newMarker = new L.marker(e.latlng).addTo(mymap).bindPopup(`<button type="button" class="remove">delete marker</button>`);
  markers.value.push(e.latlng); 
  newMarker.on("popupopen", removeMarker);  
}


function removeMarker() {
  const marker = this;
  const btn = document.querySelector(".remove");
  btn.addEventListener("click", function () {
    mymap.removeLayer(marker);
  });
} 
const handleConnect = ()=>{ 
  let latlngs = markers.value.map(item => [item.lat,item.lng]);  
   var polygon = leaflet.polygon(latlngs, {color: colorInput.value}).addTo(mymap);  
  mymap.fitBounds(polygon.getBounds()); 
  markers.value = [];
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Farmer
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div id="mapid"></div>
                    <div>
                        <label>Pick Color</label>
                        <input type="color"  v-model="colorInput"/>
                    </div>
                    <button @click="handleConnect">Connect</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
#mapid { 
  height: 800px; 
  width: 1500px;
  }
</style>

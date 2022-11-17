<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {onMounted, ref} from "vue";
import leaflet from "leaflet";
import formPDF from "../../../../storage/Form.pdf";
import axios from 'axios'; 
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

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
  var newMarker = new L.marker(e.latlng).addTo(mymap).bindPopup(`<button type="button" class="remove">Cancel</button>`);
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

const downloadItem = (url) => {
  axios({
        method: 'get',
        url,
        responseType: 'arraybuffer',
      })
        .then((response) => {
        forceFileDownload(response, "Form.pdf")
        })
        .catch(() => console.log('error occured'))
}

const forceFileDownload = (response, title) => {
      console.log(title)
      const url = window.URL.createObjectURL(new Blob([response.data]))
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', title)
      document.body.appendChild(link)
      link.click()
    }

</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Farmer
            </h2>
        </template> -->

        <div class="py-12 grid grid-cols-8 px-2">
          <div class="bg-white col-span-2 p-4">
              <div class="flex flex-row-reverse gap-2">
                  <PrimaryButton>Add area</PrimaryButton>
                  <PrimaryButton @click="downloadItem(formPDF)">Form</PrimaryButton>
              </div>
              <div  class="relative z-0 w-full mt-6 group border-none">
                  <select class="truncate block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent  border-ssr-blue2 border-[1.9px]
                                appearance-none focus:outline-none focus:ring-0 peer rounded-lg px-[15px] disabled:cursor-not-allowed"  >
                    <option>Land 1</option>
                    <option>Land 2</option>
                    <option>Land 3</option>
                  </select> 
                  <label class="peer-focus:font-medium absolute text-sm text-gray-600 duration-300 transform -translate-y-6 scale-75 
                      top-3 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-6 ml-2 
                      px-4 peer-placeholder-shown:-z-10 peer-focus:z-20 rounded-lg bg-white">Area of Land</label>
              </div>
              
              <div class="bg-slate-50 border-white shadow-lg rounded-lg my-2 p-2">
                  <div>
                      <div>Owner:</div>
                      <div>Address:</div>
                      <div>Color:</div>
                  </div>
              </div>

              <div class="bg-slate-50 border-white shadow-lg rounded-lg my-2 p-2">
                  <center class="text-2xl">New Area</center>
                  <div class="my-4">
                      <div class="flex flex-col mt-1">
                        <label>Owner</label>
                        <TextInput /> 
                      </div>
                      <div class="flex flex-col mt-2">
                        <label>Address</label>
                        <TextInput/> 
                      </div>
                      <div class="flex gap-4 items-center mt-2">
                        <label>Color</label>
                        <input type="color" v-model="colorInput" class="text-gray-900 rounded-md border-1 placeholder-gray-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-700"/> 
                      </div>
                      <PrimaryButton @click="handleConnect">Connect</PrimaryButton>
                      <div class="flex flex-row-reverse">
                        <PrimaryButton>Save</PrimaryButton>
                      </div>
                  </div>
              </div>

          </div> 
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 col-span-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div id="mapid"></div> 
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

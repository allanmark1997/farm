<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {onMounted, ref} from "vue";
import leaflet from "leaflet";
import formPDF from "../../../../storage/Form.pdf";
import axios from 'axios'; 
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm  } from '@inertiajs/inertia-vue3';
import Icon from '../../Components/Icons.vue'; 

const props = defineProps(['maps','farmers']);
const markers = ref([]); 
const latlngs = ref([]);
const address = ref()
const colorInput = ref('#ed0707');
const dataDisplay = ref({});
let mymap;


const form = useForm({
    farmer_id: null,
    details: {}, 
    }, { 
    resetOnSuccess: true
});

onMounted(()=>{ 
  console.log(props.farmers);
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
  if(markers.value.length){
    latlngs.value = markers.value.map(item => [item.lat,item.lng]);  
    var polygon = leaflet.polygon(latlngs.value, {color: colorInput.value}).addTo(mymap);  
    mymap.fitBounds(polygon.getBounds()); 
    markers.value = [];
  }else{
    alert("No coordinates detect")
  }
}

const areaOfLand = (event) =>{
  let {farmer_id, details} = JSON.parse(event.target.value); 
  let farmer = props.farmers.filter(item => item.id === farmer_id);
  dataDisplay.value = details; 
  dataDisplay.value = {...dataDisplay.value, ...farmer[0]};
  console.log(dataDisplay.value.color );
  var polygon = leaflet.polygon(details.points, {color: details.color}).addTo(mymap);  
  polygon.bindTooltip(details.address,
   {permanent: true, direction:"center"}
  ).openTooltip();
  mymap.fitBounds(polygon.getBounds()); 
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

const addArea = () =>{
  form.details = Object.assign({points:latlngs, color:colorInput.value, address:address.value})
  if(form.farmer_id && Object.keys(form.details).length){
    form.post(route("maps.store"), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Added");
                form.reset('farmer_id');
                form.reset('details');
            },
            onError: () => {
                //code 
                loading.value = false;
            },
            onFinish: () => {
                //code
            }
    });
  }else{
    alert("Empty Data");
  }
  
}

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12 grid grid-cols-8 px-2">
          <div class="bg-white col-span-2 p-4">
              <div class="flex flex-row-reverse gap-2">
                  <PrimaryButton>Add area</PrimaryButton>
                  <PrimaryButton @click="downloadItem(formPDF)">Form</PrimaryButton>
              </div>
              <div  class="relative z-0 w-full mt-6 group border-none">
                  <select class="truncate block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent  border-ssr-blue2 border-[1.9px]
                                appearance-none focus:outline-none focus:ring-0 peer rounded-lg px-[15px] disabled:cursor-not-allowed" @change="areaOfLand($event)">
                    <option selected="true" disabled="disabled">Areas</option>
                    <option v-for="(map, index ) in props.maps" :key="index" :value="JSON.stringify(map)">{{map.details.address}}</option> 
                  </select> 
                  <label class="peer-focus:font-medium absolute text-sm text-gray-600 duration-300 transform -translate-y-6 scale-75 
                      top-3 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-85 peer-focus:-translate-y-6 ml-2 
                      px-4 peer-placeholder-shown:-z-10 peer-focus:z-20 rounded-lg bg-white">Area of Land</label>
              </div>
              
              <div class="bg-slate-50 border-white shadow-lg rounded-lg my-2 p-2">
                  <div> 
                    <div class="flex flex-row-reverse gap-3">
                      <div class="cursor-pointer"><Icon icon="delete"/></div>
                      <div class="cursor-pointer"><Icon icon="edit"/></div>  
                    </div>
                      <div>Owner: {{dataDisplay.name}}</div>
                      <!-- <div>Address: {{dataDisplay?.value?.details?.address}}</div> -->
                      <div>Color: {{dataDisplay.color}}</div>
                  </div>
              </div>

              <div class="bg-slate-50 border-white shadow-lg rounded-lg my-2 p-2">
                  <center class="text-2xl">New Area</center>
                  <div class="my-4">
                      <div class="flex flex-col mt-1">
                        <select class="truncate block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent  border-ssr-blue2 border-[1.9px]
                                appearance-none focus:outline-none focus:ring-0 peer rounded-lg px-[15px] disabled:cursor-not-allowed" @change="form.farmer_id = $event.target.value">
                        <option selected="true" disabled="disabled">Farmers</option>
                        <option v-for="(farmer, index ) in props.farmers" :key="index" :value="farmer.id">{{farmer.name}}</option> 
                      </select>
                      </div>
                      <div class="flex flex-col mt-2">
                        <label>Address</label>
                        <TextInput type="text" class="mt-1 block w-full" v-model="address"/> 
                      </div>
                      <div class="flex gap-4 items-center mt-2">
                        <label>Color</label>
                        <input type="color" v-model="colorInput" class="text-gray-900 rounded-md border-1 placeholder-gray-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-700"/> 
                      </div>
                      <PrimaryButton @click="handleConnect">Connect</PrimaryButton>
                      <div class="flex flex-row-reverse">
                        <PrimaryButton @click="addArea">Save</PrimaryButton>
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

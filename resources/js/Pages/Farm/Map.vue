<script setup>
import { onMounted, ref } from "vue";
import leaflet from "leaflet";

const props = defineProps(["maps", "farmers"]);
const markersLatLngs = ref([]);
const markerData = ref([]);
const latlngs = ref([]);
const address = ref();
const colorInput = ref("#ed0707");
const dataDisplay = ref({});
const showAddCard = ref(false);
let mymap;

onMounted(() => {
    console.log(props.farmers);
    mymap = leaflet.map("mapid").setView([7.997357, 125.027804], 15);
    leaflet
        .tileLayer("http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
            attribution:
                '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        })
        .addTo(mymap);
    mymap.on("click", onMapClick);
});

const onMapClick = (e) => {
    var newMarker = new L.marker(e.latlng)
        .addTo(mymap)
        .bindPopup(`<button type="button" class="remove">Cancel</button>`);
    markersLatLngs.value.push(e.latlng);
    markerData.value.push(newMarker);
    console.log(markerData);
    newMarker.on("popupopen", removeMarker);
};
</script>

<template>
    <div class="px-6">
        <div class="min-w-full min-h-full" id="mapid"></div>
    </div>
</template>
<style scoped>
#mapid {
    height: 800px;
    width: 1500px;
}
</style>

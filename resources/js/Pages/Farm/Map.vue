<script setup>
import { onMounted, ref } from "vue";
import leaflet from "leaflet";

const props = defineProps(["maps", "farmers", "mapCoordinate"]); 
const markersLatLngs = ref([]);
const markerData = ref([]);
const latlngs = ref([]);
const colorInput = ref("#ffffff");
const collectPolygon = ref([]);
let mymap;

onMounted(() => {
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
    markersLatLngs.value.push({points:e.latlng, id:newMarker._leaflet_id});
    markerData.value.push(newMarker);
    handleConnect();
    console.log(markerData);
    newMarker.on("popupopen", removeMarker);
};

function removeMarker() {
    const marker = this;
    const btn = document.querySelector(".remove");
    btn.addEventListener("click", function () {
        let test = markersLatLngs.value.filter(item => item.id != marker._leaflet_id);
        markersLatLngs.value = test;
        handleConnect();
        mymap.removeLayer(marker);
    });
}
const handleConnect = () => {
    if (markersLatLngs.value.length) {
        collectPolygon.value.map((item) => {
            mymap.removeLayer(item);
        });
        latlngs.value = markersLatLngs.value.map((item) => [
            item.points.lat,
            item.points.lng,
        ]);
        var polygon = leaflet
            .polygon(latlngs.value, { color: colorInput.value })
            .addTo(mymap);
        mymap.fitBounds(polygon.getBounds());
        collectPolygon.value.push(polygon);
        props.mapCoordinate(latlngs.value) 
    } else {
        alert("No coordinates detect");
    }
}; 
const clearMarker = ()=>{
    markersLatLngs.value = [];
     markerData.value.map((item) => {
            mymap.removeLayer(item);
        });
}
const doSomething = (map) =>{
    var polygon = leaflet
            .polygon(map.coordinates, { color:"#ffffff"})
            .addTo(mymap);
        polygon.bindTooltip(map.name, { permanent: true, direction: "center" })
        .openTooltip();
        mymap.fitBounds(polygon.getBounds());
}

defineExpose({ doSomething,clearMarker});
</script>

<template>
    <div class="pl-6">
        <div class="rounded-md h-[790px] z-10" id="mapid"></div>
    </div>
</template>

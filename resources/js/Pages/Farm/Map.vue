<script setup>
import { onMounted, ref, watch } from "vue";
import leaflet from "leaflet"; 
import Plant from "../../../assets/plant.png";
import Shadow from "../../../assets/shadow.png";

const props = defineProps(["maps", "inventories", "mapCoordinate","enableEditMap"]); 
const markersLatLngs = ref([]);
const markerData = ref([]);
const latlngs = ref([]);
const colorInput = ref("#ffffff");
const collectPolygon = ref([]);
let mymap;

onMounted(() => {
    mymap = leaflet.map("mapid").setView([7.997357, 125.027804], 15);
    leaflet.tileLayer("http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            subdomains: ["mt0", "mt1", "mt2", "mt3"],
            attribution:
                '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        })
        .addTo(mymap);
});

watch(
  () => props.enableEditMap,
  (n, o) => {
    if(n){
        mymap.on("click", onMapClick);
    }else{
        mymap.on("click", ()=>{});
    } 
  },
  { deep: true }
)

const onMapClick = (e) => {
    if(!props.enableEditMap){
        return;
    }  
    var newMarker = new L.marker(e.latlng)
        .addTo(mymap)
        .bindPopup(`<button type="button" class="remove">Cancel</button>`);
    markersLatLngs.value.push({points:e.latlng, id:newMarker._leaflet_id});
    markerData.value.push(newMarker);
    handleConnect();
    console.log(markerData);
    newMarker.on("popupopen", removeMarker);
    
    mymap.on('zoomend', function() {
    if (mymap.getZoom() <= 10) {
        newMarker.setIconSize([20, 20]);
    }
    });
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
const drawMap = (map,details,owner,status) =>{ 
    var greenIcon = leaflet.icon({
    iconUrl: Plant,
    shadowUrl: Shadow, 
    iconSize:     [38, 95], // size of the icon
}); 

    let {fertilizer, seedling} = details;
    let tagName = '<div>'+
        '<div class="font-bold">Owner: '+ owner +'</div>' + 
        '<div class="font-bold">Name: '+ map.name +'</div>'+ 
        '<div class="font-bold">Status: '+ `${status === "idle" ? "Ready for planting" : "Crops are growing"}` +'</div>'+ 
    '</div>'
    let fertilizerHtml = fertilizer.map(item => 
    '<div class="grid grid-cols-8 gap-2 border p-2">'+
        '<div class="col-span-4">'+ item.name +'</div>' + 
        '<div class="col-span-4">'+ item.unit +'</div>'+ 
    '</div>').join(""); 
    var polygon = leaflet.polygon(map.coordinates, { color:map.color}).addTo(mymap);
        var center = polygon.getBounds().getCenter();
        var marker = leaflet.marker(center,{icon: greenIcon}).bindPopup(`
            <div class="border rounded-md p-2 w-64 shadow-md"> 
                <div class="font-bold my-2">Plant: ${seedling || 'No Plant'}</div>
                <div class="grid grid-cols-8 gap-2 border p-2">
                    <div class="col-span-4">Name</div>
                    <div class="col-span-4">Quantity</div>
                </div>
                ${fertilizerHtml}
                <div>  
                </div>
            </div>`,{maxWidth: 300});
        var polygonAndItsCenter = leaflet.layerGroup([polygon, marker]);
        polygonAndItsCenter.addTo(mymap); 
        mymap.fitBounds(polygon.getBounds());
        
        mymap.on('zoomend' , function (e) {
            var geo = polygon.getCenter(); 
                if (mymap.getZoom()>16.5)
                {
                    marker.setLatLng(geo);
                    marker.addTo(mymap);
                }else {
                    marker.remove();
                }
        }); 
        polygon.on('mouseover', function (e) { 
            polygon.bindTooltip(tagName, {direction: "center" }).openTooltip();
        });
        if(!props.enableEditMap){
            return;
        } 
        polygon.on('click', function(e) { 
            mymap.removeLayer(polygon); 
        });
}
defineExpose({ drawMap,clearMarker});
</script>

<template>
    <div class="pl-6">
        <div class="rounded-md h-[790px] z-10" id="mapid"></div>
    </div>
</template>

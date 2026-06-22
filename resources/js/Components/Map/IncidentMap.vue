<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    incidents: { type: Array, default: () => [] },
    center: { type: Object, default: () => ({ lat: 23.8103, lng: 90.4125 }) },
    zoom: { type: Number, default: 7 },
});

const mapContainer = ref(null);
let map = null;
let markers = [];
let markerClusterer = null;
let infoWindow = null;

function clearMarkers() {
    markers.forEach(m => m.setMap(null));
    markers = [];
    if (markerClusterer) {
        markerClusterer.clearMarkers();
    }
}

function addMarkers(incidents) {
    clearMarkers();
    infoWindow = infoWindow || new google.maps.InfoWindow();

    incidents.forEach(incident => {
        const marker = new google.maps.Marker({
            position: { lat: Number(incident.latitude), lng: Number(incident.longitude) },
            map,
            title: incident.title,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: incident.category_color || '#FF0000',
                fillOpacity: 0.9,
                strokeColor: '#fff',
                strokeWeight: 2,
                scale: incident.severity === 'critical' ? 12 : incident.severity === 'high' ? 10 : 8,
            },
        });

        marker.addListener('click', () => {
            infoWindow.setContent(`
                <div style="max-width:250px">
                    <h3 style="font-weight:600;margin:0 0 4px">${incident.title}</h3>
                    <p style="font-size:13px;color:#666;margin:0 0 4px">${incident.category_name} &middot; ${incident.severity}</p>
                    <p style="font-size:13px;color:#666;margin:0">${incident.district_name}${incident.upazila_name ? ' / ' + incident.upazila_name : ''}</p>
                    <p style="font-size:12px;color:#999;margin:4px 0 0">${new Date(incident.created_at).toLocaleDateString()}</p>
                </div>
            `);
            infoWindow.open(map, marker);
        });

        markers.push(marker);
    });

    // Use MarkerClusterer if available
    if (window.markerClusterer && markers.length > 0) {
        markerClusterer = new markerClusterer.MarkerClusterer({ map, markers });
    }
}

function initMap() {
    map = new google.maps.Map(mapContainer.value, {
        center: props.center,
        zoom: props.zoom,
        mapTypeControl: true,
        streetViewControl: false,
    });

    if (props.incidents.length) {
        addMarkers(props.incidents);
    }
}

onMounted(() => {
    if (window.google?.maps) {
        initMap();
        return;
    }
    // Google Maps loads async — poll until ready
    const poll = setInterval(() => {
        if (window.google?.maps) {
            clearInterval(poll);
            initMap();
        }
    }, 100);
});

watch(() => props.incidents, (val) => {
    if (map) addMarkers(val);
}, { deep: true });

// Expose for live updates
function addSingleMarker(incident) {
    if (!map) return;
    props.incidents.push(incident);
    addMarkers(props.incidents);
}

defineExpose({ addSingleMarker });
</script>

<template>
    <div ref="mapContainer" class="h-full w-full rounded-lg" style="min-height: 500px;"></div>
</template>

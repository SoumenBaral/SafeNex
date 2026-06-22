<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({ lat: 23.8103, lng: 90.4125 }), // Dhaka default
    },
    zoom: { type: Number, default: 8 },
});

const emit = defineEmits(['update:modelValue']);

const mapContainer = ref(null);
let map = null;
let marker = null;

function initMap() {
    const center = { lat: Number(props.modelValue.lat) || 23.8103, lng: Number(props.modelValue.lng) || 90.4125 };

    map = new google.maps.Map(mapContainer.value, {
        center,
        zoom: props.zoom,
        mapTypeControl: false,
        streetViewControl: false,
    });

    marker = new google.maps.Marker({
        position: center,
        map,
        draggable: true,
    });

    marker.addListener('dragend', () => {
        const pos = marker.getPosition();
        emit('update:modelValue', { lat: pos.lat().toFixed(7), lng: pos.lng().toFixed(7) });
    });

    map.addListener('click', (e) => {
        marker.setPosition(e.latLng);
        emit('update:modelValue', { lat: e.latLng.lat().toFixed(7), lng: e.latLng.lng().toFixed(7) });
    });
}

onMounted(() => {
    if (window.google?.maps) {
        initMap();
        return;
    }
    const poll = setInterval(() => {
        if (window.google?.maps) {
            clearInterval(poll);
            initMap();
        }
    }, 100);
});

watch(() => props.modelValue, (val) => {
    if (marker && val.lat && val.lng) {
        const pos = new google.maps.LatLng(Number(val.lat), Number(val.lng));
        marker.setPosition(pos);
        map.panTo(pos);
    }
});
</script>

<template>
    <div ref="mapContainer" class="h-64 w-full rounded-md border border-gray-300"></div>
</template>

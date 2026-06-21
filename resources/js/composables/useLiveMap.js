import { onMounted, onUnmounted, ref } from 'vue';

export function useLiveMap(mapRef) {
    const newIncidents = ref([]);

    let channel = null;

    onMounted(() => {
        if (!window.Echo) return;

        channel = window.Echo.channel('incidents');
        channel.listen('ReportVerified', (e) => {
            newIncidents.value.push(e.incident);
            if (mapRef?.value?.addSingleMarker) {
                mapRef.value.addSingleMarker(e.incident);
            }
        });
    });

    onUnmounted(() => {
        if (channel) {
            window.Echo.leave('incidents');
        }
    });

    return { newIncidents };
}

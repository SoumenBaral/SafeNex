<script setup>
import { Head, Link } from '@inertiajs/vue3';
import IncidentMap from '@/Components/Map/IncidentMap.vue';
import { useLiveMap } from '@/composables/useLiveMap';
import { ref } from 'vue';

const props = defineProps({
    incidents: Array,
});

const mapRef = ref(null);
const { newIncidents } = useLiveMap(mapRef);
</script>

<template>
    <Head title="Live Disaster Map" />

    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">Safenix</Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-sm font-medium text-indigo-600">Live Map</Link>
                        <Link :href="route('news.index')" class="text-sm text-gray-600 hover:text-gray-900">News</Link>
                        <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-6 py-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Live Disaster Map</h1>
                    <p class="text-sm text-gray-500">{{ incidents.length }} verified incident(s)</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
                <IncidentMap ref="mapRef" :incidents="incidents" />
            </div>
        </div>
    </div>
</template>

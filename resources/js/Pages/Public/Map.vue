<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import IncidentMap from '@/Components/Map/IncidentMap.vue';
import { useLiveMap } from '@/composables/useLiveMap';
import { ref } from 'vue';

const props = defineProps({
    incidents: Array,
    districts: Array,
    categories: Array,
    filters: Object,
});

const mapRef = ref(null);
const { newIncidents } = useLiveMap(mapRef);

const districtFilter = ref(props.filters?.district_id ?? '');
const categoryFilter = ref(props.filters?.category_id ?? '');

function applyFilters() {
    router.get(route('map'), {
        district_id: districtFilter.value || undefined,
        category_id: categoryFilter.value || undefined,
    }, { preserveState: true });
}

function clearFilters() {
    districtFilter.value = '';
    categoryFilter.value = '';
    router.get(route('map'));
}
</script>

<template>
    <Head title="Live Disaster Map" />

    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">Safenix</Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-sm font-medium text-indigo-600">Live Map</Link>
                        <Link :href="route('news.index')" class="text-sm text-gray-600 hover:text-gray-900">News</Link>
                        <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Dashboard</Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-6 py-6 lg:px-8">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Live Disaster Map</h1>
                    <p class="text-sm text-gray-500">{{ incidents.length }} verified incident(s)</p>
                </div>
                <div class="flex items-center gap-3">
                    <select v-model="districtFilter" @change="applyFilters"
                        class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Districts</option>
                        <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                    </select>
                    <select v-model="categoryFilter" @change="applyFilters"
                        class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Types</option>
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <button v-if="districtFilter || categoryFilter" @click="clearFilters"
                        class="text-sm text-indigo-600 hover:text-indigo-500">Clear</button>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
                <IncidentMap ref="mapRef" :incidents="incidents" />
            </div>
        </div>
    </div>
</template>

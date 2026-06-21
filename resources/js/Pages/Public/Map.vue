<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import IncidentMap from '@/Components/Map/IncidentMap.vue';
import { useLiveMap } from '@/composables/useLiveMap';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    incidents:  Array,
    districts:  Array,
    categories: Array,
    filters:    Object,
});

const mapRef = ref(null);
const { newIncidents } = useLiveMap(mapRef);

const districtFilter  = ref(props.filters?.district_id ?? '');
const categoryFilter  = ref(props.filters?.category_id ?? '');
const showFilters     = ref(true);

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

const clock = ref('');
let clockInterval;
function tick() {
    clock.value = new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}
onMounted(() => { tick(); clockInterval = setInterval(tick, 1000); });
onUnmounted(() => clearInterval(clockInterval));

const criticalCount = computed(() => props.incidents.filter(i => i.severity === 'critical').length);
const highCount     = computed(() => props.incidents.filter(i => i.severity === 'high').length);
</script>

<template>
    <Head title="Live Disaster Map — Safenix" />

    <div class="h-screen flex flex-col bg-ink-900 overflow-hidden">
        <!-- Situation bar -->
        <div class="bg-ink-900 border-b border-ink-700 h-10 flex items-center justify-between px-4 flex-shrink-0">
            <div class="flex items-center gap-5 font-data text-xs">
                <Link :href="route('home')" class="flex items-center gap-1.5 text-white font-display font-bold text-sm mr-2">
                    <div class="w-6 h-6 rounded bg-bay-600 flex items-center justify-center text-xs font-bold">S</div>
                    Safenix
                </Link>
                <span class="text-[#D62839]">◆ {{ criticalCount }} critical</span>
                <span class="text-[#E5611F]">▲ {{ highCount }} high</span>
                <span class="text-white">{{ incidents.length }} verified</span>
                <span class="text-bay-400 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-bay-400 animate-pulse inline-block"></span> live
                </span>
            </div>
            <div class="flex items-center gap-4">
                <Link :href="route('news.index')" class="text-ink-400 hover:text-white text-xs transition-colors">News</Link>
                <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                    class="bg-bay-600 hover:bg-bay-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-colors">
                    Dashboard
                </Link>
                <Link v-else :href="route('login')" class="text-ink-400 hover:text-white text-xs transition-colors">Sign in</Link>
                <span class="font-data text-xs text-ink-500 hidden sm:block">{{ clock }}</span>
            </div>
        </div>

        <!-- Main area -->
        <div class="flex flex-1 min-h-0">
            <!-- Filter sidebar -->
            <aside
                :class="[
                    'flex-shrink-0 bg-ink-800 border-r border-ink-700 flex flex-col transition-all duration-300 overflow-hidden',
                    showFilters ? 'w-56' : 'w-0',
                ]"
            >
                <div class="p-4 space-y-5 overflow-y-auto dark-scroll flex-1">
                    <div>
                        <p class="text-ink-400 text-xs font-semibold uppercase tracking-wider mb-2">Filters</p>
                        <div class="space-y-3">
                            <div>
                                <label class="text-ink-400 text-xs mb-1 block">District</label>
                                <select v-model="districtFilter" @change="applyFilters"
                                    class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-xs px-3 py-2 focus:border-bay-500 focus:ring-0">
                                    <option value="">All districts</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-ink-400 text-xs mb-1 block">Type</label>
                                <select v-model="categoryFilter" @change="applyFilters"
                                    class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-xs px-3 py-2 focus:border-bay-500 focus:ring-0">
                                    <option value="">All types</option>
                                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                            <button v-if="districtFilter || categoryFilter" @click="clearFilters"
                                class="w-full text-xs text-bay-400 hover:text-bay-300 transition-colors py-1">
                                Clear filters
                            </button>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div>
                        <p class="text-ink-400 text-xs font-semibold uppercase tracking-wider mb-3">Severity legend</p>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-[#2E9E6B] w-4">●</span>
                                <span class="text-ink-300">Low</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-[#E0A100] w-4">△</span>
                                <span class="text-ink-300">Medium</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-[#E5611F] w-4">▲</span>
                                <span class="text-ink-300">High</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-[#D62839] w-4 animate-pulse">◆</span>
                                <span class="text-ink-300">Critical</span>
                            </div>
                        </div>
                    </div>

                    <!-- Report link -->
                    <div class="pt-2 border-t border-ink-700">
                        <Link :href="$page.props.auth?.user ? route('reports.create') : route('register')"
                            class="w-full flex items-center justify-center gap-1.5 bg-bay-600 hover:bg-bay-700 text-white text-xs font-medium py-2.5 rounded-lg transition-colors">
                            + Report incident
                        </Link>
                    </div>
                </div>
            </aside>

            <!-- Toggle filter button -->
            <button
                @click="showFilters = !showFilters"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-ink-700 hover:bg-ink-600 border border-ink-500 text-white w-5 h-10 flex items-center justify-center text-xs transition-all"
                :style="{ left: showFilters ? '224px' : '0' }"
                :aria-label="showFilters ? 'Hide filters' : 'Show filters'"
            >
                {{ showFilters ? '‹' : '›' }}
            </button>

            <!-- Map -->
            <div class="flex-1 relative">
                <IncidentMap ref="mapRef" :incidents="incidents" class="w-full h-full" />

                <!-- Incident count badge (floating) -->
                <div class="absolute top-3 right-3 z-10 bg-ink-900/80 backdrop-blur rounded-lg px-3 py-1.5 border border-ink-600">
                    <p class="font-data text-xs text-white">
                        Showing <span class="text-bay-400 font-semibold">{{ incidents.length }}</span> verified incidents
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

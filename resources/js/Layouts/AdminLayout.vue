<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import NotificationBell from '@/Components/NotificationBell.vue';

const page = usePage();
const pendingCount = computed(() => page.props.pendingReportsCount ?? 0);
const userName = computed(() => page.props.auth.user?.name ?? '');
const initials = computed(() => userName.value.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase());

const sidebarOpen = ref(false);
const showFlash = ref(true);
const clock = ref('');
const flash = computed(() => page.props.flash);
watch(flash, () => { showFlash.value = true; setTimeout(() => showFlash.value = false, 5000); }, { deep: true });

let clockInterval;
function tick() {
    const now = new Date();
    clock.value = now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}

onMounted(() => { tick(); clockInterval = setInterval(tick, 1000); });
onUnmounted(() => clearInterval(clockInterval));

const nav = [
    { label: 'Reports',   routeName: 'admin.reports.index', icon: '📋', badge: true },
    { label: 'Live Map',  routeName: 'map', icon: '🗺' },
    { label: 'Teams',     routeName: 'admin.teams.index', icon: '🚑' },
    { label: 'Alerts',    routeName: 'admin.alerts.index', icon: '🚨' },
    { label: 'News',      routeName: 'admin.news.index', icon: '📰' },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <!-- Situation Bar -->
        <div class="bg-white border-b border-gray-200 px-4 h-10 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-4 text-xs font-data">
                <span class="text-[#D62839] font-semibold">◆ {{ $page.props.situationCritical ?? 0 }} critical</span>
                <span class="text-[#E5611F] font-semibold">▲ {{ $page.props.situationHigh ?? 0 }} high</span>
                <span class="text-[#B7791F] font-semibold">◷ {{ pendingCount }} pending</span>
                <span class="text-bay-600 flex items-center gap-1 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-bay-500 animate-pulse inline-block"></span>
                    live
                </span>
            </div>
            <div class="flex items-center gap-3">
                <NotificationBell />
                <span class="font-data text-xs text-gray-400">{{ clock }}</span>
            </div>
        </div>

        <div class="flex flex-1 min-h-0">
            <!-- Sidebar -->
            <aside
                :class="[
                    'fixed lg:relative inset-y-0 left-0 z-40 flex flex-col bg-white border-r border-gray-200 transition-all duration-300 flex-shrink-0 shadow-sm',
                    sidebarOpen ? 'w-60 translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-60',
                ]"
                style="top: 40px;"
            >
                <!-- Logo -->
                <div class="px-5 py-4 border-b border-gray-200">
                    <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-md bg-bay-600 flex items-center justify-center text-white text-xs font-bold font-display">S</div>
                        <span class="text-gray-900 font-display font-bold text-base tracking-tight">Safenix</span>
                    </Link>
                    <p class="text-gray-400 text-xs mt-0.5 font-data">Admin Panel</p>
                </div>

                <!-- Nav -->
                <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                    <template v-for="item in nav" :key="item.routeName">
                        <Link
                            :href="route(item.routeName)"
                            :class="[
                                'flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all group',
                                route().current(item.routeName + '*') || route().current(item.routeName)
                                    ? 'bg-bay-50 text-bay-700 border-l-[3px] border-bay-500 pl-[calc(0.75rem-3px)]'
                                    : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50',
                            ]"
                        >
                            <span class="flex items-center gap-2.5">
                                <span class="text-base">{{ item.icon }}</span>
                                {{ item.label }}
                            </span>
                            <span
                                v-if="item.badge && pendingCount > 0"
                                class="bg-[#B7791F] text-white text-xs font-data font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center"
                            >{{ pendingCount }}</span>
                        </Link>
                    </template>
                </nav>

                <!-- Bottom -->
                <div class="px-3 py-4 border-t border-gray-200 space-y-0.5">
                    <Link
                        :href="route('profile.edit')"
                        class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-all"
                    >
                        <div class="w-6 h-6 rounded-full bg-bay-600 flex items-center justify-center text-white text-xs font-bold">{{ initials }}</div>
                        <span class="truncate">{{ userName }}</span>
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-all"
                    >
                        <span>↩</span> Log out
                    </Link>
                </div>
            </aside>

            <!-- Mobile sidebar backdrop -->
            <div
                v-if="sidebarOpen"
                class="fixed inset-0 z-30 bg-black/30 lg:hidden"
                @click="sidebarOpen = false"
            />

            <!-- Main content -->
            <div class="flex-1 min-w-0 flex flex-col">
                <!-- Mobile top bar -->
                <div class="lg:hidden flex items-center gap-3 bg-white border-b border-gray-200 px-4 py-3">
                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-gray-900 p-1"
                        aria-label="Toggle menu"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="text-gray-900 font-display font-bold text-sm">Safenix Admin</span>
                </div>

                <main class="flex-1 overflow-auto p-6 animate-fade-in">
                    <!-- Flash messages -->
                    <div v-if="showFlash && (flash?.success || flash?.error)" class="mb-4">
                        <div v-if="flash?.success" class="flex items-center gap-3 bg-[#157F6B]/10 border border-[#157F6B]/30 text-[#157F6B] rounded-xl px-4 py-3 text-sm">
                            <span>✓</span>
                            <span class="flex-1">{{ flash.success }}</span>
                            <button @click="showFlash = false" class="text-[#157F6B]/60 hover:text-[#157F6B]">✕</button>
                        </div>
                        <div v-if="flash?.error" class="flex items-center gap-3 bg-[#D62839]/10 border border-[#D62839]/30 text-[#D62839] rounded-xl px-4 py-3 text-sm">
                            <span>✕</span>
                            <span class="flex-1">{{ flash.error }}</span>
                            <button @click="showFlash = false" class="text-[#D62839]/60 hover:text-[#D62839]">✕</button>
                        </div>
                    </div>
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

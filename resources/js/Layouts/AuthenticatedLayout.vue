<script setup>
import { ref, computed, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import NotificationBell from '@/Components/NotificationBell.vue';

const showMobileMenu = ref(false);
const showFlash = ref(true);
const page = usePage();
const roles = computed(() => page.props.auth.roles ?? []);
const isAdmin = computed(() => roles.value.includes('admin'));
const isResponder = computed(() => roles.value.includes('responder'));
const user = computed(() => page.props.auth.user);
const initials = computed(() => user.value?.name?.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase() ?? '?');
const roleLabel = computed(() => isAdmin.value ? 'Admin' : isResponder.value ? 'Responder' : 'User');
const flash = computed(() => page.props.flash);
watch(flash, () => { showFlash.value = true; setTimeout(() => showFlash.value = false, 5000); }, { deep: true });

const roleBadgeClass = computed(() => ({
    'Admin':     'bg-[#D62839]/10 text-[#D62839]',
    'Responder': 'bg-[#E5611F]/10 text-[#E5611F]',
    'User':      'bg-bay-50 text-bay-700',
})[roleLabel.value]);
</script>

<template>
    <div class="min-h-screen bg-paper">
        <!-- Top Nav -->
        <nav class="sticky top-0 z-30 bg-white border-b border-line shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo + Nav Links -->
                    <div class="flex items-center gap-8">
                        <Link :href="isAdmin ? route('admin.dashboard') : isResponder ? route('responder.dashboard') : route('dashboard')">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-bay-600 flex items-center justify-center text-white text-sm font-bold font-display">S</div>
                                <span class="font-display font-bold text-gray-900 text-base tracking-tight">Safenix</span>
                            </div>
                        </Link>

                        <!-- Desktop nav -->
                        <div class="hidden md:flex items-center gap-1">
                            <template v-if="isResponder">
                                <Link
                                    :href="route('responder.dashboard')"
                                    :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('responder.dashboard') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                                >Dashboard</Link>
                            </template>
                            <template v-else>
                                <Link
                                    :href="route('dashboard')"
                                    :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('dashboard') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                                >Dashboard</Link>
                                <Link
                                    :href="route('reports.create')"
                                    :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('reports.create') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                                >Submit Report</Link>
                                <Link
                                    :href="route('my-reports')"
                                    :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('my-reports') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                                >My Reports</Link>
                            </template>
                            <Link
                                :href="route('map')"
                                :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('map') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                            >Live Map</Link>
                            <Link
                                :href="route('news.index')"
                                :class="['px-3 py-2 rounded-lg text-sm font-medium transition-colors', route().current('news.*') ? 'text-bay-600 bg-bay-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50']"
                            >News</Link>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center gap-3">
                        <NotificationBell />

                        <!-- Avatar + dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 p-1 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-bay-700 flex items-center justify-center text-white text-xs font-bold">{{ initials }}</div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-800 leading-none">{{ user?.name }}</p>
                                    <span :class="['text-xs font-medium px-1.5 py-0.5 rounded-full', roleBadgeClass]">{{ roleLabel }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute right-0 top-full mt-1 w-44 bg-white rounded-xl shadow-lift border border-line py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                                <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</Link>
                                <div class="border-t border-gray-100 my-1"></div>
                                <Link :href="route('logout')" method="post" as="button" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log out</Link>
                            </div>
                        </div>

                        <!-- Mobile menu button -->
                        <button @click="showMobileMenu = !showMobileMenu" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path v-if="!showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div v-if="showMobileMenu" class="md:hidden border-t border-line bg-white px-4 py-3 space-y-1">
                <template v-if="isResponder">
                    <Link :href="route('responder.dashboard')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</Link>
                </template>
                <template v-else>
                    <Link :href="route('dashboard')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</Link>
                    <Link :href="route('reports.create')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Submit Report</Link>
                    <Link :href="route('my-reports')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">My Reports</Link>
                </template>
                <Link :href="route('map')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Live Map</Link>
                <Link :href="route('news.index')" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">News</Link>
            </div>
        </nav>

        <!-- Page Header slot -->
        <header v-if="$slots.header" class="bg-white border-b border-line">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5">
                <slot name="header" />
            </div>
        </header>

        <!-- Flash messages -->
        <div v-if="showFlash && (flash?.success || flash?.error)" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
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

        <!-- Main content -->
        <main class="animate-fade-in">
            <slot />
        </main>
    </div>
</template>

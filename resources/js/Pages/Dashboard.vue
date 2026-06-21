<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from '@/Components/UI/StatCard.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import StatusBadge from '@/Components/UI/StatusBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    stats:         Object,
    recentReports: Array,
});

const user = computed(() => usePage().props.auth.user);
const firstName = computed(() => user.value?.name?.split(' ')[0] ?? 'there');
</script>

<template>
    <Head title="Dashboard — Safenix" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 space-y-8">
            <!-- Welcome banner -->
            <div class="bg-gradient-to-r from-bay-600 to-bay-700 rounded-2xl p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div>
                    <h1 class="font-display font-bold text-white text-2xl mb-1">Hello, {{ firstName }} 👋</h1>
                    <p class="text-bay-100 text-sm">Report incidents, track your submissions, and stay informed.</p>
                </div>
                <Link :href="route('reports.create')"
                    class="flex-shrink-0 inline-flex items-center gap-2 bg-white text-bay-700 font-semibold px-5 py-2.5 rounded-xl hover:bg-bay-50 transition-colors text-sm shadow-sm">
                    <span>+</span> Report an incident
                </Link>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <StatCard label="Total Reports"    :value="stats?.total_reports ?? 0" icon="📋" icon-bg="bg-gray-100" />
                <StatCard label="Awaiting review"  :value="stats?.pending ?? 0"       icon="◷"  icon-bg="bg-[#B7791F]/10" />
                <StatCard label="Verified"         :value="stats?.verified ?? 0"      icon="✓"  icon-bg="bg-[#157F6B]/10" />
                <StatCard label="Not verified"     :value="stats?.rejected ?? 0"      icon="✕"  icon-bg="bg-[#B03A4A]/10" />
            </div>

            <!-- Quick links -->
            <div class="grid sm:grid-cols-3 gap-4">
                <Link :href="route('reports.create')"
                    class="group bg-white rounded-xl border border-line shadow-card hover:shadow-lift hover:border-bay-300 transition-all p-5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-bay-50 rounded-xl flex items-center justify-center text-2xl group-hover:bg-bay-100 transition-colors">📋</div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm font-display">Submit report</p>
                        <p class="text-gray-500 text-xs mt-0.5">Report a new incident</p>
                    </div>
                </Link>
                <Link :href="route('my-reports')"
                    class="group bg-white rounded-xl border border-line shadow-card hover:shadow-lift hover:border-bay-300 transition-all p-5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-2xl group-hover:bg-green-100 transition-colors">📁</div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm font-display">My reports</p>
                        <p class="text-gray-500 text-xs mt-0.5">Track your submissions</p>
                    </div>
                </Link>
                <Link :href="route('map')"
                    class="group bg-white rounded-xl border border-line shadow-card hover:shadow-lift hover:border-bay-300 transition-all p-5 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-2xl group-hover:bg-blue-100 transition-colors">🗺</div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm font-display">Live map</p>
                        <p class="text-gray-500 text-xs mt-0.5">View verified incidents</p>
                    </div>
                </Link>
            </div>

            <!-- Recent reports -->
            <div v-if="recentReports?.length">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-display font-semibold text-gray-900 text-base">Your recent reports</h2>
                    <Link :href="route('my-reports')" class="text-sm text-bay-600 hover:text-bay-700 font-medium">View all →</Link>
                </div>
                <div class="space-y-3">
                    <div
                        v-for="report in recentReports"
                        :key="report.id"
                        class="bg-white rounded-xl border border-line shadow-card p-4 flex items-center gap-4"
                    >
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate">{{ report.title }}</p>
                            <p class="text-gray-500 text-xs mt-0.5 font-data">{{ report.category?.name }} · {{ report.district?.name }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <SeverityBadge :level="report.severity" />
                            <StatusBadge :status="report.status" />
                            <TimeAgo :date="report.created_at" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

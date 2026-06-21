<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import StatusBadge from '@/Components/UI/StatusBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    reports: Object,
    currentStatus: String,
    pendingCount: Number,
});

const tabs = [
    { value: 'pending',  label: 'Pending',  badge: true },
    { value: 'verified', label: 'Verified'  },
    { value: 'rejected', label: 'Rejected'  },
    { value: 'all',      label: 'All'       },
];

function filterByStatus(status) {
    router.get(route('admin.reports.index'), { status }, { preserveState: true });
}
</script>

<template>
    <Head title="Reports — Safenix Admin" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-white text-2xl">Report Queue</h1>
                    <p class="text-ink-400 text-sm mt-1">Review and verify submitted incident reports</p>
                </div>
            </div>

            <!-- Filter tabs -->
            <div class="flex items-center gap-1 bg-ink-800 rounded-xl p-1 border border-ink-600 self-start w-fit">
                <button
                    v-for="tab in tabs" :key="tab.value"
                    @click="filterByStatus(tab.value)"
                    :class="[
                        'flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all',
                        currentStatus === tab.value
                            ? 'bg-bay-600 text-white shadow-sm'
                            : 'text-ink-400 hover:text-white hover:bg-ink-700',
                    ]"
                >
                    {{ tab.label }}
                    <span
                        v-if="tab.badge && pendingCount"
                        class="bg-[#B7791F] text-white text-xs font-data px-1.5 py-0.5 rounded-full"
                    >{{ pendingCount }}</span>
                </button>
            </div>

            <!-- Reports list -->
            <div class="bg-ink-800 rounded-xl border border-ink-600 overflow-hidden">
                <!-- Empty state -->
                <div v-if="!reports.data.length" class="py-16 flex flex-col items-center justify-center">
                    <div class="text-4xl mb-4">✅</div>
                    <p class="text-white font-semibold font-display">
                        {{ currentStatus === 'pending' ? 'Queue clear. No reports waiting for review.' : 'No reports found.' }}
                    </p>
                    <p class="text-ink-400 text-sm mt-1">
                        {{ currentStatus === 'pending' ? 'You\'re all caught up.' : 'Try a different filter.' }}
                    </p>
                </div>

                <template v-else>
                    <!-- Table header -->
                    <div class="grid grid-cols-[1fr_auto_auto_auto_auto] gap-4 px-5 py-3 border-b border-ink-700">
                        <span class="text-xs font-semibold text-ink-400 uppercase tracking-wider">Report</span>
                        <span class="text-xs font-semibold text-ink-400 uppercase tracking-wider">Severity</span>
                        <span class="text-xs font-semibold text-ink-400 uppercase tracking-wider">Status</span>
                        <span class="text-xs font-semibold text-ink-400 uppercase tracking-wider">Submitted</span>
                        <span class="text-xs font-semibold text-ink-400 uppercase tracking-wider sr-only">Action</span>
                    </div>

                    <Link
                        v-for="report in reports.data"
                        :key="report.id"
                        :href="route('admin.reports.show', report.id)"
                        class="grid grid-cols-[1fr_auto_auto_auto_auto] gap-4 items-center px-5 py-4 border-b border-ink-700 last:border-0 hover:bg-ink-700/50 transition-colors group"
                    >
                        <div class="min-w-0">
                            <p class="text-white text-sm font-medium truncate group-hover:text-bay-300 transition-colors">{{ report.title }}</p>
                            <p class="text-ink-400 text-xs font-data mt-0.5">
                                {{ report.category?.name }}
                                <span v-if="report.district"> · {{ report.district.name }}</span>
                                <span v-if="report.upazila"> / {{ report.upazila.name }}</span>
                                · by {{ report.user?.name }}
                            </p>
                        </div>
                        <SeverityBadge :level="report.severity" />
                        <StatusBadge :status="report.status" />
                        <TimeAgo :date="report.created_at" />
                        <span class="text-bay-400 text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity">Review →</span>
                    </Link>
                </template>

                <!-- Pagination -->
                <div v-if="reports.last_page > 1" class="flex justify-center gap-1 px-5 py-4 border-t border-ink-700">
                    <Link
                        v-for="link in reports.links" :key="link.label"
                        :href="link.url ?? '#'"
                        :class="[
                            'px-3 py-1.5 rounded-lg text-xs font-medium transition-colors',
                            link.active  ? 'bg-bay-600 text-white' : 'text-ink-400 hover:text-white hover:bg-ink-700',
                            !link.url    ? 'opacity-40 pointer-events-none' : '',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

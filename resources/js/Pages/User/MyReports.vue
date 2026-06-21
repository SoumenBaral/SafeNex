<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import StatusBadge from '@/Components/UI/StatusBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    reports:       Object,
    currentStatus: String,
});

const tabs = [
    { value: 'all',      label: 'All'      },
    { value: 'pending',  label: 'Pending'  },
    { value: 'verified', label: 'Verified' },
    { value: 'rejected', label: 'Rejected' },
];

function filter(status) {
    router.get(route('my-reports'), { status }, { preserveState: true });
}

const statusTimeline = {
    pending:  [true,  false, false],
    verified: [true,  true,  false],
    rejected: [true,  false, true],
};
</script>

<template>
    <Head title="My Reports — Safenix" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-gray-900 text-2xl">My Reports</h1>
                    <p class="text-gray-500 text-sm mt-1">Track the status of your submitted incidents</p>
                </div>
                <Link :href="route('reports.create')"
                    class="inline-flex items-center gap-1.5 bg-bay-600 hover:bg-bay-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    + New report
                </Link>
            </div>

            <!-- Filter tabs -->
            <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1 self-start">
                <button
                    v-for="tab in tabs" :key="tab.value"
                    @click="filter(tab.value)"
                    :class="[
                        'px-4 py-2 rounded-lg text-sm font-medium transition-all',
                        (currentStatus ?? 'all') === tab.value
                            ? 'bg-white text-gray-900 shadow-sm'
                            : 'text-gray-500 hover:text-gray-700',
                    ]"
                >{{ tab.label }}</button>
            </div>

            <!-- Empty state -->
            <EmptyState
                v-if="!reports.data.length"
                icon="📭"
                title="No reports yet"
                description="Report an incident and it will appear here with its review status."
                action-label="Submit your first report"
                :action-href="route('reports.create')"
            />

            <!-- Report cards -->
            <div v-else class="space-y-4">
                <div
                    v-for="report in reports.data"
                    :key="report.id"
                    class="bg-white rounded-xl border border-line shadow-card hover:shadow-lift transition-all overflow-hidden"
                >
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <h3 class="font-semibold text-gray-900 font-display truncate">{{ report.title }}</h3>
                                </div>
                                <p class="text-gray-500 text-xs font-data">
                                    {{ report.category?.name }}
                                    <span v-if="report.district"> · {{ report.district.name }}</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <SeverityBadge :level="report.severity" />
                                <StatusBadge :status="report.status" />
                            </div>
                        </div>

                        <!-- Status timeline -->
                        <div class="flex items-center gap-0 mt-4">
                            <template v-for="(step, i) in [
                                { label: 'Submitted',      done: true },
                                { label: 'Under review',   done: report.status !== 'pending' },
                                { label: report.status === 'rejected' ? 'Not verified' : 'Verified',
                                  done: report.status === 'verified' || report.status === 'rejected',
                                  red:  report.status === 'rejected' },
                            ]" :key="i">
                                <div class="flex flex-col items-center">
                                    <div :class="[
                                        'w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold',
                                        step.red  ? 'bg-[#B03A4A] text-white' :
                                        step.done ? 'bg-[#157F6B] text-white' : 'bg-gray-200 text-gray-400',
                                    ]">{{ step.done ? (step.red ? '✕' : '✓') : '' }}</div>
                                    <span :class="['text-xs mt-1 whitespace-nowrap', step.done ? (step.red ? 'text-[#B03A4A]' : 'text-[#157F6B]') : 'text-gray-400']">
                                        {{ step.label }}
                                    </span>
                                </div>
                                <div v-if="i < 2" :class="['h-0.5 w-12 sm:w-20 mx-1 mb-4', step.done ? 'bg-[#157F6B]' : 'bg-gray-200']" />
                            </template>
                        </div>

                        <!-- Submitted time -->
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <TimeAgo :date="report.created_at" />
                            <span class="text-gray-400 text-xs font-data">#RPT-{{ String(report.id).padStart(4, '0') }}</span>
                        </div>
                    </div>

                    <!-- Rejection reason box -->
                    <div v-if="report.status === 'rejected' && report.rejection_reason"
                        class="bg-[#B03A4A]/5 border-t border-[#B03A4A]/20 px-5 py-3">
                        <p class="text-xs font-semibold text-[#B03A4A] mb-1">Reason for rejection</p>
                        <p class="text-gray-700 text-sm">{{ report.rejection_reason }}</p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="reports.last_page > 1" class="flex justify-center gap-1">
                <Link
                    v-for="link in reports.links" :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
                        link.active  ? 'bg-bay-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                        !link.url    ? 'opacity-40 pointer-events-none' : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

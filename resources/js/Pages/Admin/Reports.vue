<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    reports: Object,
    currentStatus: String,
});

const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    verified: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
};

const severityColors = {
    low: 'bg-blue-100 text-blue-800',
    medium: 'bg-yellow-100 text-yellow-800',
    high: 'bg-orange-100 text-orange-800',
    critical: 'bg-red-100 text-red-800',
};

const tabs = [
    { value: 'pending', label: 'Pending' },
    { value: 'verified', label: 'Verified' },
    { value: 'rejected', label: 'Rejected' },
    { value: 'all', label: 'All' },
];

function filterByStatus(status) {
    router.get(route('admin.reports.index'), { status }, { preserveState: true });
}
</script>

<template>
    <Head title="Admin - Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Report Review Queue</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Tabs -->
                <div class="mb-4 flex gap-2">
                    <button v-for="tab in tabs" :key="tab.value"
                        @click="filterByStatus(tab.value)"
                        :class="[
                            'rounded-md px-4 py-2 text-sm font-medium',
                            currentStatus === tab.value
                                ? 'bg-indigo-600 text-white'
                                : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
                        ]">
                        {{ tab.label }}
                    </button>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="reports.data.length === 0" class="p-6 text-center text-gray-500">
                        No {{ currentStatus !== 'all' ? currentStatus : '' }} reports found.
                    </div>

                    <div v-else class="divide-y divide-gray-200">
                        <Link v-for="report in reports.data" :key="report.id"
                            :href="route('admin.reports.show', report.id)"
                            class="block p-6 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-semibold text-gray-900 truncate">{{ report.title }}</h3>
                                        <span :class="statusColors[report.status]"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ report.status }}
                                        </span>
                                        <span :class="severityColors[report.severity]"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ report.severity }}
                                        </span>
                                    </div>
                                    <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
                                        <span v-if="report.category">{{ report.category.name }}</span>
                                        <span v-if="report.district">{{ report.district.name }}</span>
                                        <span v-if="report.upazila">/ {{ report.upazila.name }}</span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-400">
                                        By {{ report.user?.name }} &middot; {{ new Date(report.created_at).toLocaleString() }}
                                    </div>
                                </div>
                                <svg class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div v-if="reports.links && reports.last_page > 1" class="border-t border-gray-200 px-6 py-3 flex justify-center gap-1">
                        <Link v-for="link in reports.links" :key="link.label"
                            :href="link.url ?? '#'"
                            :class="[
                                'px-3 py-1 rounded text-sm',
                                link.active ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                                !link.url ? 'opacity-50 pointer-events-none' : ''
                            ]"
                            v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

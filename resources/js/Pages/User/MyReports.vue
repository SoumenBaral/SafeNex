<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    reports: Object,
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
</script>

<template>
    <Head title="My Reports" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">My Reports</h2>
                <Link :href="route('reports.create')"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    + New Report
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="reports.data.length === 0" class="p-6 text-center text-gray-500">
                        You haven't submitted any reports yet.
                        <Link :href="route('reports.create')" class="text-indigo-600 hover:text-indigo-500"> Submit your first report.</Link>
                    </div>

                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="report in reports.data" :key="report.id" class="p-6 flex items-start justify-between gap-4">
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
                                    <span>{{ new Date(report.created_at).toLocaleDateString() }}</span>
                                </div>
                                <p v-if="report.status === 'rejected' && report.rejection_reason"
                                    class="mt-2 text-sm text-red-600">
                                    Rejected: {{ report.rejection_reason }}
                                </p>
                            </div>
                        </div>
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

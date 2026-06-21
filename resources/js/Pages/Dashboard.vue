<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total Reports</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ stats?.total_reports ?? 0 }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Pending</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-yellow-600">{{ stats?.pending ?? 0 }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Verified</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">{{ stats?.verified ?? 0 }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Rejected</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-red-600">{{ stats?.rejected ?? 0 }}</dd>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <Link :href="route('reports.create')"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Submit New Report
                    </Link>
                    <Link :href="route('my-reports')"
                        class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
                        View My Reports
                    </Link>
                    <Link :href="route('map')"
                        class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
                        Live Map
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

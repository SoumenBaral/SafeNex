<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Admin Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <Link :href="route('admin.reports.index', { status: 'pending' })"
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Pending Reports</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-yellow-600">{{ stats?.pending_reports ?? 0 }}</dd>
                    </Link>

                    <Link :href="route('admin.reports.index', { status: 'verified' })"
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Verified Reports</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-green-600">{{ stats?.verified_reports ?? 0 }}</dd>
                    </Link>

                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total Reports</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ stats?.total_reports ?? 0 }}</dd>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Registered Users</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ stats?.total_users ?? 0 }}</dd>
                    </div>

                    <Link :href="route('admin.teams.index')"
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Rescue Teams</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-indigo-600">{{ stats?.total_teams ?? 0 }}</dd>
                    </Link>

                    <Link :href="route('admin.news.index')"
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow-sm ring-1 ring-gray-200 hover:shadow-md transition sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Published News</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-indigo-600">{{ stats?.published_news ?? 0 }}</dd>
                    </Link>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <Link :href="route('admin.reports.index', { status: 'pending' })"
                            class="inline-flex items-center rounded-md bg-yellow-50 px-4 py-2 text-sm font-medium text-yellow-700 ring-1 ring-yellow-600/20 hover:bg-yellow-100">
                            Review Pending Reports
                        </Link>
                        <Link :href="route('admin.teams.index')"
                            class="inline-flex items-center rounded-md bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 ring-1 ring-indigo-600/20 hover:bg-indigo-100">
                            Manage Teams
                        </Link>
                        <Link :href="route('admin.alerts.index')"
                            class="inline-flex items-center rounded-md bg-red-50 px-4 py-2 text-sm font-medium text-red-700 ring-1 ring-red-600/20 hover:bg-red-100">
                            Send Alert
                        </Link>
                        <Link :href="route('admin.news.create')"
                            class="inline-flex items-center rounded-md bg-green-50 px-4 py-2 text-sm font-medium text-green-700 ring-1 ring-green-600/20 hover:bg-green-100">
                            Write Article
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

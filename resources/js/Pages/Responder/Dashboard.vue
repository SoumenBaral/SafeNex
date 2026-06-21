<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    assignments: Object,
});

const statusColors = {
    assigned: 'bg-blue-100 text-blue-800',
    en_route: 'bg-yellow-100 text-yellow-800',
    on_site: 'bg-orange-100 text-orange-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-gray-100 text-gray-800',
};

const severityColors = {
    low: 'bg-blue-100 text-blue-800',
    medium: 'bg-yellow-100 text-yellow-800',
    high: 'bg-orange-100 text-orange-800',
    critical: 'bg-red-100 text-red-800',
};

const nextStatuses = {
    assigned: { value: 'en_route', label: 'Mark En Route' },
    en_route: { value: 'on_site', label: 'Mark On Site' },
    on_site: { value: 'completed', label: 'Mark Completed' },
};

function updateStatus(assignment, newStatus) {
    useForm({ status: newStatus }).post(route('responder.assignments.update-status', assignment.id));
}
</script>

<template>
    <Head title="Responder Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">My Assignments</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="!assignments?.data?.length" class="p-6 text-center text-gray-500">
                        No assignments yet. You will see incidents here when a team you belong to is assigned.
                    </div>

                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="a in assignments.data" :key="a.id" class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-semibold text-gray-900">{{ a.report?.title }}</h3>
                                        <span :class="statusColors[a.status]"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ a.status.replace('_', ' ') }}
                                        </span>
                                        <span v-if="a.report" :class="severityColors[a.report.severity]"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ a.report.severity }}
                                        </span>
                                    </div>

                                    <div class="mt-1 text-sm text-gray-500">
                                        <span v-if="a.report?.category">{{ a.report.category.name }}</span>
                                        <span v-if="a.report?.district"> &middot; {{ a.report.district.name }}</span>
                                        <span v-if="a.report?.upazila"> / {{ a.report.upazila.name }}</span>
                                    </div>

                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-medium">Reason:</span> {{ a.reason }}
                                    </p>

                                    <div class="mt-2 flex items-center gap-3 text-xs text-gray-400">
                                        <span>Team: {{ a.team?.name }}</span>
                                        <span>Assigned by: {{ a.assigned_by_user?.name ?? 'Admin' }}</span>
                                        <span>{{ new Date(a.created_at).toLocaleString() }}</span>
                                    </div>

                                    <div v-if="a.report" class="mt-2">
                                        <a :href="`https://maps.google.com/?q=${a.report.latitude},${a.report.longitude}`"
                                            target="_blank" class="text-sm text-indigo-600 hover:text-indigo-500">
                                            View on Google Maps &rarr;
                                        </a>
                                    </div>
                                </div>

                                <!-- Status Update Button -->
                                <div v-if="nextStatuses[a.status]" class="flex-shrink-0">
                                    <button @click="updateStatus(a, nextStatuses[a.status].value)"
                                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                        {{ nextStatuses[a.status].label }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="assignments?.links && assignments.last_page > 1" class="border-t border-gray-200 px-6 py-3 flex justify-center gap-1">
                        <a v-for="link in assignments.links" :key="link.label"
                            :href="link.url ?? '#'"
                            :class="['px-3 py-1 rounded text-sm', link.active ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 pointer-events-none' : '']"
                            v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

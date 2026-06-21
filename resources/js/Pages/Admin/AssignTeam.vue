<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    report: Object,
    teams: Array,
    existingAssignments: Array,
});

const form = useForm({
    rescue_team_id: '',
    reason: '',
});

function submit() {
    form.post(route('admin.assignments.store', props.report.id), {
        onSuccess: () => form.reset(),
    });
}

const statusColors = {
    assigned: 'bg-blue-100 text-blue-800',
    en_route: 'bg-yellow-100 text-yellow-800',
    on_site: 'bg-orange-100 text-orange-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-gray-100 text-gray-800',
};
</script>

<template>
    <Head :title="`Assign Team: ${report.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('admin.reports.show', report.id)" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Assign Rescue Team</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">
                <!-- Incident Summary -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900">{{ report.title }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ report.category?.name }} &middot; {{ report.severity }}
                        &middot; {{ report.district?.name }}{{ report.upazila ? ' / ' + report.upazila.name : '' }}
                    </p>
                </div>

                <!-- Assign Form -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign a Team</h3>

                    <div v-if="teams.length === 0" class="text-gray-500 text-sm">
                        No available teams. <Link :href="route('admin.teams.index')" class="text-indigo-600">Create one first.</Link>
                    </div>

                    <form v-else @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Select Team *</label>
                            <select v-model="form.rescue_team_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Choose a team</option>
                                <option v-for="team in teams" :key="team.id" :value="team.id">
                                    {{ team.name }} ({{ team.members_count }} members)
                                    {{ team.district ? '- ' + team.district?.name : '' }}
                                </option>
                            </select>
                            <p v-if="form.errors.rescue_team_id" class="mt-1 text-sm text-red-600">{{ form.errors.rescue_team_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assignment Reason *</label>
                            <textarea v-model="form.reason" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Why this team? Instructions for the team..."></textarea>
                            <p v-if="form.errors.reason" class="mt-1 text-sm text-red-600">{{ form.errors.reason }}</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50">
                                {{ form.processing ? 'Assigning...' : 'Assign Team & Send Emails' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Existing Assignments -->
                <div v-if="existingAssignments.length" class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Existing Assignments</h3>
                    <div class="divide-y divide-gray-200">
                        <div v-for="a in existingAssignments" :key="a.id" class="py-3">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-900">{{ a.team?.name }}</span>
                                <span :class="statusColors[a.status]"
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                    {{ a.status.replace('_', ' ') }}
                                </span>
                                <span v-if="a.emailed_at" class="text-xs text-green-600">Emailed</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ a.reason }}</p>
                            <p class="mt-1 text-xs text-gray-400">Assigned by {{ a.assigned_by_user?.name }} &middot; {{ new Date(a.created_at).toLocaleString() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

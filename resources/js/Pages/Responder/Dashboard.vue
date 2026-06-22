<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    assignments: Object,
});

const nextStatuses = {
    assigned: { value: 'en_route',  label: 'Mark en route' },
    en_route: { value: 'on_site',   label: 'Mark on site' },
    on_site:  { value: 'completed', label: 'Mark completed' },
};

const statusMap = {
    assigned:  { label: 'Assigned',  classes: 'bg-bay-600/10 text-bay-400',      dot: 'bg-bay-500' },
    en_route:  { label: 'En route',  classes: 'bg-[#E5611F]/10 text-[#E5611F]',  dot: 'bg-[#E5611F]' },
    on_site:   { label: 'On site',   classes: 'bg-[#D62839]/10 text-[#D62839]',  dot: 'bg-[#D62839]' },
    completed: { label: 'Completed', classes: 'bg-[#157F6B]/10 text-[#157F6B]',  dot: 'bg-[#157F6B]' },
    cancelled: { label: 'Cancelled', classes: 'bg-gray-200/10 text-gray-400',      dot: 'bg-gray-400' },
};

function updateStatus(assignment, newStatus) {
    useForm({ status: newStatus }).post(route('responder.assignments.update-status', assignment.id));
}
</script>

<template>
    <Head title="My Assignments — Safenix" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            <!-- Header -->
            <div>
                <h1 class="font-display font-bold text-gray-900 text-2xl">My Assignments</h1>
                <p class="text-gray-500 text-sm mt-1">Active incidents assigned to your team</p>
            </div>

            <!-- Empty state -->
            <EmptyState
                v-if="!assignments?.data?.length"
                icon="🚑"
                title="No assignments yet"
                description="When an admin assigns your team to an incident, it will appear here."
            />

            <!-- Assignment cards -->
            <div v-else class="space-y-4">
                <div
                    v-for="a in assignments.data"
                    :key="a.id"
                    class="bg-white rounded-xl border border-line shadow-card overflow-hidden"
                >
                    <!-- Status header bar -->
                    <div :class="['h-1', statusMap[a.status]?.dot ? 'bg-current' : 'bg-gray-200']"
                        :style="{ background: { assigned: '#109AA6', en_route: '#E5611F', on_site: '#D62839', completed: '#157F6B', cancelled: '#9CA3AF' }[a.status] }">
                    </div>

                    <div class="p-5">
                        <!-- Title + badges -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <h2 class="font-display font-semibold text-gray-900 leading-snug">{{ a.report?.title }}</h2>
                                <p class="text-gray-500 text-xs mt-0.5 font-data">
                                    {{ a.report?.category?.name }}
                                    <span v-if="a.report?.district"> · {{ a.report.district.name }}</span>
                                    <span v-if="a.report?.upazila"> / {{ a.report.upazila.name }}</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <SeverityBadge v-if="a.report?.severity" :level="a.report.severity" />
                                <span :class="['text-xs font-medium px-2.5 py-1 rounded-full', statusMap[a.status]?.classes]">
                                    {{ statusMap[a.status]?.label }}
                                </span>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="bg-gray-50 rounded-lg px-3 py-2.5 mb-4">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Assignment reason</p>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ a.reason }}</p>
                        </div>

                        <!-- Meta -->
                        <div class="flex items-center gap-4 text-xs text-gray-400 font-data mb-4">
                            <span>Team: {{ a.team?.name }}</span>
                            <span>·</span>
                            <span>By {{ a.assigned_by_user?.name ?? 'Admin' }}</span>
                            <span>·</span>
                            <TimeAgo :date="a.created_at" />
                        </div>

                        <!-- Coordinates + map link -->
                        <div v-if="a.report?.latitude" class="flex items-center justify-between mb-4">
                            <span class="font-data text-xs text-bay-600">{{ a.report.latitude }}, {{ a.report.longitude }}</span>
                            <a :href="`https://maps.google.com/?q=${a.report.latitude},${a.report.longitude}`"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-xs text-bay-600 hover:text-bay-700 font-medium transition-colors">
                                📍 Open in Maps →
                            </a>
                        </div>

                        <!-- Progress control (big, thumb-friendly) -->
                        <div v-if="nextStatuses[a.status]">
                            <button
                                @click="updateStatus(a, nextStatuses[a.status].value)"
                                class="w-full bg-bay-600 hover:bg-bay-700 text-white font-semibold py-4 rounded-xl transition-colors text-sm min-h-[3.5rem]"
                            >
                                {{ nextStatuses[a.status].label }}
                            </button>
                        </div>
                        <div v-else-if="a.status === 'completed'" class="w-full bg-[#157F6B]/10 text-[#157F6B] font-semibold py-4 rounded-xl text-sm text-center">
                            ✓ Assignment completed
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="assignments?.last_page > 1" class="flex justify-center gap-1">
                <a v-for="link in assignments.links" :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
                        link.active ? 'bg-bay-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                        !link.url   ? 'opacity-40 pointer-events-none' : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

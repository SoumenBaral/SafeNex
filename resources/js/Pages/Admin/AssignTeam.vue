<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import ConfirmModal from '@/Components/UI/ConfirmModal.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    report:              Object,
    teams:               Array,
    existingAssignments: Array,
});

const showConfirm = ref(false);

const form = useForm({
    rescue_team_id: '',
    reason: '',
});

const selectedTeam = computed(() => props.teams.find(t => t.id == form.rescue_team_id));

function submit() {
    form.post(route('admin.assignments.store', props.report.id), {
        onSuccess: () => { form.reset(); showConfirm.value = false; },
    });
}

const assignmentStatusMap = {
    assigned:  { label: 'Assigned',   classes: 'bg-bay-600/10 text-bay-400' },
    en_route:  { label: 'En route',   classes: 'bg-[#E5611F]/10 text-[#E5611F]' },
    on_site:   { label: 'On site',    classes: 'bg-[#D62839]/10 text-[#D62839]' },
    completed: { label: 'Completed',  classes: 'bg-[#157F6B]/10 text-[#157F6B]' },
    cancelled: { label: 'Cancelled',  classes: 'bg-gray-100 text-gray-500' },
};
</script>

<template>
    <Head :title="`Assign Team — ${report.title}`" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Back + header -->
            <div class="flex items-center gap-3">
                <Link :href="route('admin.reports.show', report.id)" class="text-gray-500 hover:text-gray-900 transition-colors p-1.5 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </Link>
                <div>
                    <h1 class="font-display font-bold text-gray-900 text-xl">Assign rescue team</h1>
                    <p class="text-gray-500 text-xs font-data mt-0.5">#RPT-{{ String(report.id).padStart(4, '0') }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-[1fr_340px] gap-6 items-start">
                <!-- Left: incident summary + assignments -->
                <div class="space-y-5">
                    <!-- Incident card -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex-1 min-w-0">
                                <h2 class="font-display font-semibold text-gray-900">{{ report.title }}</h2>
                                <p class="text-gray-500 text-xs mt-1 font-data">
                                    {{ report.district?.name }}<span v-if="report.upazila"> / {{ report.upazila.name }}</span>
                                    · {{ report.category?.name }}
                                </p>
                            </div>
                            <SeverityBadge :level="report.severity" size="md" />
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ report.description }}</p>
                        <p class="font-data text-xs text-bay-600 mt-3">{{ report.latitude }}, {{ report.longitude }}</p>
                    </div>

                    <!-- Existing assignments -->
                    <div v-if="existingAssignments.length" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <h3 class="font-display font-semibold text-gray-900 text-sm">Previous assignments</h3>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <div v-for="a in existingAssignments" :key="a.id" class="px-5 py-4">
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <span class="text-gray-900 font-medium text-sm">{{ a.team?.name }}</span>
                                    <div class="flex items-center gap-2">
                                        <span v-if="a.emailed_at" class="text-xs text-[#157F6B] font-medium">✓ Emailed</span>
                                        <span :class="['text-xs font-medium px-2.5 py-1 rounded-full', assignmentStatusMap[a.status]?.classes]">
                                            {{ assignmentStatusMap[a.status]?.label ?? a.status }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-gray-500 text-xs leading-relaxed">{{ a.reason }}</p>
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-data">
                                    <span>Assigned by {{ a.assigned_by_user?.name }}</span>
                                    <span>·</span>
                                    <TimeAgo :date="a.created_at" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: assign form -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden lg:sticky lg:top-6">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="font-display font-semibold text-gray-900 text-sm">🚑 Assign a team</h3>
                    </div>

                    <div v-if="!teams.length" class="p-6 text-center">
                        <p class="text-gray-500 text-sm mb-3">No available teams.</p>
                        <Link :href="route('admin.teams.index')" class="text-bay-600 hover:text-bay-700 text-sm font-medium">Create a team first →</Link>
                    </div>

                    <form v-else @submit.prevent="showConfirm = true" class="p-5 space-y-4">
                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1.5">Select team <span class="text-[#D62839]">*</span></label>
                            <select v-model="form.rescue_team_id"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 focus:border-bay-500 focus:ring-0">
                                <option value="">Choose a team</option>
                                <option v-for="team in teams" :key="team.id" :value="team.id">
                                    {{ team.name }} ({{ team.members_count }} members){{ team.district ? ' · ' + team.district.name : '' }}
                                </option>
                            </select>
                            <p v-if="form.errors.rescue_team_id" class="mt-1 text-xs text-[#D62839]">{{ form.errors.rescue_team_id }}</p>
                        </div>

                        <!-- Team members preview -->
                        <div v-if="selectedTeam?.members?.length" class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">
                                {{ selectedTeam.members.length }} member{{ selectedTeam.members.length !== 1 ? 's' : '' }} will be emailed:
                            </p>
                            <div class="space-y-1">
                                <p v-for="m in selectedTeam.members" :key="m.id" class="text-gray-600 text-xs">
                                    · {{ m.name }}<span v-if="m.role_in_team" class="text-gray-400"> ({{ m.role_in_team }})</span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-600 text-xs font-medium mb-1.5">Assignment reason <span class="text-[#D62839]">*</span></label>
                            <textarea v-model="form.reason" rows="4"
                                class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0 resize-none"
                                placeholder="Describe the situation and instructions for the team…"></textarea>
                            <p v-if="form.errors.reason" class="mt-1 text-xs text-[#D62839]">{{ form.errors.reason }}</p>
                        </div>

                        <button type="submit" :disabled="form.processing || !form.rescue_team_id || !form.reason"
                            class="w-full bg-bay-600 hover:bg-bay-700 disabled:opacity-50 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            🚑 Assign &amp; email team
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <ConfirmModal
            :show="showConfirm"
            title="Assign & email team?"
            :description="`This will assign ${selectedTeam?.name} and send emails to all ${selectedTeam?.members?.length ?? 0} team members. They will be notified immediately.`"
            confirm-label="Assign & email team"
            @confirm="submit"
            @cancel="showConfirm = false"
        />
    </AdminLayout>
</template>

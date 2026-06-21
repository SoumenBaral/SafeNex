<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import StatusBadge from '@/Components/UI/StatusBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import ConfirmModal from '@/Components/UI/ConfirmModal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ report: Object });

const showVerifyModal  = ref(false);
const showRejectPanel  = ref(false);
const lightboxSrc      = ref(null);

const rejectForm = useForm({ rejection_reason: '' });

const quickReasons = ['Duplicate report', 'Insufficient evidence', 'Out of scope', 'Incorrect location', 'Fake/spam'];

function verify() {
    useForm({}).post(route('admin.reports.verify', props.report.id));
    showVerifyModal.value = false;
}

function reject() {
    rejectForm.post(route('admin.reports.reject', props.report.id), {
        onSuccess: () => { showRejectPanel.value = false; rejectForm.reset(); },
    });
}
</script>

<template>
    <Head :title="`Review: ${report.title} — Safenix`" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Back + title -->
            <div class="flex items-center gap-3">
                <Link :href="route('admin.reports.index')" class="text-ink-400 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-ink-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </Link>
                <div>
                    <h1 class="font-display font-bold text-white text-xl">Review Report</h1>
                    <p class="text-ink-400 text-xs font-data mt-0.5">#RPT-{{ String(report.id).padStart(4, '0') }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-[1fr_300px] gap-6">
                <!-- Left: report details -->
                <div class="space-y-5">
                    <!-- Title + badges -->
                    <div class="bg-ink-800 rounded-xl border border-ink-600 p-6">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex-1 min-w-0">
                                <h2 class="font-display font-bold text-white text-lg leading-snug">{{ report.title }}</h2>
                                <p class="text-ink-400 text-sm mt-1 font-data">
                                    {{ report.district?.name }}<span v-if="report.upazila"> / {{ report.upazila.name }}</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <SeverityBadge :level="report.severity" size="md" />
                                <StatusBadge :status="report.status" size="md" />
                            </div>
                        </div>

                        <!-- Meta grid -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-ink-700">
                            <div>
                                <p class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-1">Category</p>
                                <p class="text-white text-sm">{{ report.category?.name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-1">Reported by</p>
                                <p class="text-white text-sm">{{ report.user?.name }}</p>
                                <p class="text-ink-500 text-xs font-data">{{ report.user?.email }}</p>
                            </div>
                            <div>
                                <p class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-1">Coordinates</p>
                                <p class="text-bay-400 text-sm font-data">{{ report.latitude }}, {{ report.longitude }}</p>
                            </div>
                            <div>
                                <p class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-1">Submitted</p>
                                <TimeAgo :date="report.created_at" />
                                <p class="text-ink-500 text-xs font-data mt-0.5">{{ new Date(report.created_at).toLocaleString() }}</p>
                            </div>
                            <div v-if="report.address" class="col-span-2">
                                <p class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-1">Address</p>
                                <p class="text-white text-sm">{{ report.address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-ink-800 rounded-xl border border-ink-600 p-6">
                        <h3 class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-3">Description</h3>
                        <p class="text-white text-sm leading-relaxed whitespace-pre-wrap">{{ report.description }}</p>
                    </div>

                    <!-- Media gallery -->
                    <div v-if="report.media?.length" class="bg-ink-800 rounded-xl border border-ink-600 p-6">
                        <h3 class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-4">Evidence ({{ report.media.length }} file{{ report.media.length !== 1 ? 's' : '' }})</h3>
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            <div v-for="m in report.media" :key="m.id" class="flex-shrink-0">
                                <button v-if="m.type === 'image'" @click="lightboxSrc = `/storage/${m.path}`" class="block">
                                    <img
                                        :src="`/storage/${m.thumbnail_path || m.path}`"
                                        class="w-36 h-28 rounded-lg object-cover ring-1 ring-ink-600 hover:ring-bay-500 transition-all"
                                        alt="Report evidence"
                                    />
                                </button>
                                <video v-else :src="`/storage/${m.path}`" controls
                                    class="w-36 h-28 rounded-lg object-cover bg-ink-900 ring-1 ring-ink-600"/>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection reason (if rejected) -->
                    <div v-if="report.rejection_reason" class="bg-[#B03A4A]/10 border border-[#B03A4A]/30 rounded-xl p-5">
                        <h3 class="text-[#B03A4A] text-xs font-semibold uppercase tracking-wider mb-2">Rejection reason</h3>
                        <p class="text-white/80 text-sm">{{ report.rejection_reason }}</p>
                    </div>

                    <!-- Verified info -->
                    <div v-if="report.verified_by_user" class="bg-[#157F6B]/10 border border-[#157F6B]/30 rounded-xl p-5">
                        <h3 class="text-[#157F6B] text-xs font-semibold uppercase tracking-wider mb-2">Verified</h3>
                        <p class="text-white/80 text-sm">
                            By {{ report.verified_by_user.name }} · {{ new Date(report.verified_at).toLocaleString() }}
                        </p>
                    </div>
                </div>

                <!-- Right: action panel (sticky) -->
                <div class="space-y-4">
                    <!-- Inline reject panel -->
                    <div v-if="showRejectPanel && report.status === 'pending'" class="bg-ink-800 rounded-xl border border-[#B03A4A]/40 p-5 space-y-4">
                        <h3 class="font-display font-semibold text-white text-sm">Reject report</h3>
                        <p class="text-ink-400 text-xs">The reporter will be notified with your reason.</p>

                        <!-- Quick-pick chips -->
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="r in quickReasons" :key="r"
                                @click="rejectForm.rejection_reason = r"
                                :class="[
                                    'text-xs px-3 py-1.5 rounded-full border transition-colors',
                                    rejectForm.rejection_reason === r
                                        ? 'bg-[#B03A4A] border-[#B03A4A] text-white'
                                        : 'border-ink-600 text-ink-400 hover:text-white hover:border-ink-500',
                                ]"
                            >{{ r }}</button>
                        </div>

                        <textarea
                            v-model="rejectForm.rejection_reason"
                            rows="3"
                            placeholder="Or type a custom reason…"
                            class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 placeholder-ink-500 focus:border-bay-500 focus:ring-0 resize-none"
                        ></textarea>
                        <p v-if="rejectForm.errors.rejection_reason" class="text-[#D62839] text-xs">{{ rejectForm.errors.rejection_reason }}</p>

                        <div class="flex gap-2">
                            <button @click="showRejectPanel = false; rejectForm.reset()"
                                class="flex-1 text-sm font-medium text-ink-400 hover:text-white border border-ink-600 px-3 py-2 rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button @click="reject" :disabled="rejectForm.processing || !rejectForm.rejection_reason"
                                class="flex-1 text-sm font-semibold text-white bg-[#B03A4A] hover:bg-[#D62839] disabled:opacity-50 px-3 py-2 rounded-lg transition-colors">
                                {{ rejectForm.processing ? 'Rejecting…' : 'Confirm reject' }}
                            </button>
                        </div>
                    </div>

                    <!-- Primary action buttons -->
                    <div v-if="report.status === 'pending'" class="bg-ink-800 rounded-xl border border-ink-600 p-5 space-y-3">
                        <h3 class="font-display font-semibold text-white text-sm mb-1">Review actions</h3>
                        <button @click="showVerifyModal = true"
                            class="w-full flex items-center justify-center gap-2 bg-[#157F6B] hover:bg-[#2E9E6B] text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            ✓ Verify report
                        </button>
                        <button @click="showRejectPanel = !showRejectPanel"
                            class="w-full flex items-center justify-center gap-2 border border-[#B03A4A]/60 hover:bg-[#B03A4A]/10 text-[#B03A4A] hover:text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            ✕ Reject report
                        </button>
                    </div>

                    <!-- Post-verify actions -->
                    <div v-if="report.status === 'verified'" class="bg-ink-800 rounded-xl border border-ink-600 p-5 space-y-3">
                        <h3 class="font-display font-semibold text-white text-sm mb-1">Next steps</h3>
                        <Link :href="route('admin.assignments.create', report.id)"
                            class="w-full flex items-center justify-center gap-2 bg-bay-600 hover:bg-bay-700 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            🚑 Assign rescue team
                        </Link>
                        <Link :href="route('admin.news.create', { from_report: report.id })"
                            class="w-full flex items-center justify-center gap-2 border border-ink-600 hover:bg-ink-700 text-white font-medium py-3 rounded-xl transition-colors text-sm">
                            📰 Convert to article
                        </Link>
                    </div>

                    <!-- Reporter card -->
                    <div class="bg-ink-800 rounded-xl border border-ink-600 p-5">
                        <h3 class="text-ink-400 text-xs font-medium uppercase tracking-wider mb-3">Reporter</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-bay-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ report.user?.name?.charAt(0)?.toUpperCase() }}
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ report.user?.name }}</p>
                                <p class="text-ink-400 text-xs font-data">{{ report.user?.email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verify confirm modal -->
        <ConfirmModal
            :show="showVerifyModal"
            title="Verify this report?"
            description="This report will become publicly visible on the map and news feed. The reporter will be notified."
            confirm-label="Verify report"
            @confirm="verify"
            @cancel="showVerifyModal = false"
        />

        <!-- Lightbox -->
        <Teleport to="body">
            <div v-if="lightboxSrc" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4" @click="lightboxSrc = null">
                <img :src="lightboxSrc" class="max-h-full max-w-full rounded-xl object-contain" @click.stop />
                <button @click="lightboxSrc = null" class="absolute top-4 right-4 text-white/60 hover:text-white text-2xl">✕</button>
            </div>
        </Teleport>
    </AdminLayout>
</template>

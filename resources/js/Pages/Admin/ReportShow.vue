<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    report: Object,
});

const showRejectModal = ref(false);

const rejectForm = useForm({
    rejection_reason: '',
});

function verify() {
    if (confirm('Are you sure you want to verify this report? It will become publicly visible.')) {
        useForm({}).post(route('admin.reports.verify', props.report.id));
    }
}

function reject() {
    rejectForm.post(route('admin.reports.reject', props.report.id), {
        onSuccess: () => {
            showRejectModal.value = false;
            rejectForm.reset();
        },
    });
}

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
    <Head :title="`Review: ${report.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('admin.reports.index')" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Review Report</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">
                <!-- Report Details -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ report.title }}</h3>
                            <div class="mt-1 flex items-center gap-2 flex-wrap">
                                <span :class="statusColors[report.status]"
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                    {{ report.status }}
                                </span>
                                <span :class="severityColors[report.severity]"
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                    {{ report.severity }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div v-if="report.status === 'verified'" class="flex-shrink-0">
                            <Link :href="route('admin.assignments.create', report.id)"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Assign Rescue Team
                            </Link>
                        </div>
                        <div v-if="report.status === 'pending'" class="flex gap-2 flex-shrink-0">
                            <button @click="verify"
                                class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                Verify
                            </button>
                            <button @click="showRejectModal = true"
                                class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                Reject
                            </button>
                        </div>
                    </div>

                    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ report.category?.name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ report.district?.name }}
                                <span v-if="report.upazila"> / {{ report.upazila.name }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ report.address || 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coordinates</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ report.latitude }}, {{ report.longitude }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Reported By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ report.user?.name }} ({{ report.user?.email }})</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Submitted At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ new Date(report.created_at).toLocaleString() }}</dd>
                        </div>
                        <div v-if="report.occurred_at">
                            <dt class="text-sm font-medium text-gray-500">Occurred At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ new Date(report.occurred_at).toLocaleString() }}</dd>
                        </div>
                        <div v-if="report.verified_by_user">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ report.verified_by_user?.name }} at {{ new Date(report.verified_at).toLocaleString() }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ report.description }}</p>
                    </div>

                    <!-- Media Gallery -->
                    <div v-if="report.media && report.media.length" class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500">Attached Media</h4>
                        <div class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            <div v-for="m in report.media" :key="m.id">
                                <a v-if="m.type === 'image'" :href="`/storage/${m.path}`" target="_blank">
                                    <img :src="`/storage/${m.thumbnail_path || m.path}`"
                                        class="h-32 w-full rounded-md object-cover hover:opacity-90 transition" />
                                </a>
                                <video v-else :src="`/storage/${m.path}`" controls
                                    class="h-32 w-full rounded-md object-cover bg-black"></video>
                            </div>
                        </div>
                    </div>

                    <div v-if="report.rejection_reason" class="mt-6 rounded-md bg-red-50 p-4">
                        <h4 class="text-sm font-medium text-red-800">Rejection Reason</h4>
                        <p class="mt-1 text-sm text-red-700">{{ report.rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <Teleport to="body">
            <div v-if="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900">Reject Report</h3>
                    <p class="mt-1 text-sm text-gray-500">Please provide a reason for rejection. The user will be notified.</p>

                    <textarea v-model="rejectForm.rejection_reason" rows="4"
                        class="mt-4 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Reason for rejection..."></textarea>
                    <p v-if="rejectForm.errors.rejection_reason" class="mt-1 text-sm text-red-600">{{ rejectForm.errors.rejection_reason }}</p>

                    <div class="mt-4 flex justify-end gap-3">
                        <button @click="showRejectModal = false; rejectForm.reset()"
                            class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button @click="reject" :disabled="rejectForm.processing"
                            class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 disabled:opacity-50">
                            {{ rejectForm.processing ? 'Rejecting...' : 'Reject Report' }}
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    alerts: Object,
    districts: Array,
});

const form = useForm({
    title: '',
    message: '',
    district_id: '',
    upazila_id: '',
});

const selectedDistrict = computed(() => props.districts.find(d => d.id == form.district_id));
const upazilas = computed(() => selectedDistrict.value?.upazilas ?? []);

function submit() {
    form.post(route('admin.alerts.store'), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Emergency Alerts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Emergency Alerts</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">
                <!-- Send Alert Form -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Send Emergency Alert</h3>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alert Title *</label>
                            <input v-model="form.title" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g. Flood Warning - Sylhet" />
                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target District</label>
                                <select v-model="form.district_id" @change="form.upazila_id = ''"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All districts</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Target Upazila</label>
                                <select v-model="form.upazila_id" :disabled="!upazilas.length"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100">
                                    <option value="">All upazilas</option>
                                    <option v-for="u in upazilas" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Message *</label>
                            <textarea v-model="form.message" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Describe the emergency..."></textarea>
                            <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 disabled:opacity-50">
                                {{ form.processing ? 'Sending...' : 'Send Alert' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Past Alerts -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sent Alerts</h3>
                    <div v-if="alerts.data.length === 0" class="text-gray-500 text-sm">No alerts sent yet.</div>
                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="alert in alerts.data" :key="alert.id" class="py-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ alert.title }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ alert.message }}</p>
                                    <div class="mt-1 text-xs text-gray-400">
                                        <span v-if="alert.district">{{ alert.district.name }}</span>
                                        <span v-else>All districts</span>
                                        &middot; By {{ alert.sent_by_user?.name ?? 'Admin' }}
                                        &middot; {{ new Date(alert.sent_at).toLocaleString() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

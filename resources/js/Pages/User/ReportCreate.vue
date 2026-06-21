<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    categories: Array,
    districts: Array,
});

const form = useForm({
    title: '',
    description: '',
    category_id: '',
    district_id: '',
    upazila_id: '',
    address: '',
    latitude: '',
    longitude: '',
    severity: 'medium',
    occurred_at: '',
});

const selectedDistrict = computed(() => {
    return props.districts.find(d => d.id == form.district_id);
});

const upazilas = computed(() => {
    return selectedDistrict.value?.upazilas ?? [];
});

const gettingLocation = ref(false);

function useMyLocation() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser.');
        return;
    }
    gettingLocation.value = true;
    navigator.geolocation.getCurrentPosition(
        (pos) => {
            form.latitude = pos.coords.latitude.toFixed(7);
            form.longitude = pos.coords.longitude.toFixed(7);
            gettingLocation.value = false;
        },
        () => {
            alert('Unable to get your location.');
            gettingLocation.value = false;
        }
    );
}

function submit() {
    form.post(route('reports.store'));
}
</script>

<template>
    <Head title="Submit Report" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Submit Disaster Report
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input v-model="form.title" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g. Flood in Sylhet City" />
                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <!-- Category & Severity -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Disaster Type *</label>
                                <select v-model="form.category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select type</option>
                                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                                </select>
                                <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-600">{{ form.errors.category_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Severity *</label>
                                <select v-model="form.severity"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                                <p v-if="form.errors.severity" class="mt-1 text-sm text-red-600">{{ form.errors.severity }}</p>
                            </div>
                        </div>

                        <!-- District & Upazila -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">District *</label>
                                <select v-model="form.district_id" @change="form.upazila_id = ''"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select district</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                                <p v-if="form.errors.district_id" class="mt-1 text-sm text-red-600">{{ form.errors.district_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upazila</label>
                                <select v-model="form.upazila_id" :disabled="!upazilas.length"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100">
                                    <option value="">Select upazila</option>
                                    <option v-for="u in upazilas" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                                <p v-if="form.errors.upazila_id" class="mt-1 text-sm text-red-600">{{ form.errors.upazila_id }}</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address / Landmark</label>
                            <input v-model="form.address" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Near XYZ market..." />
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location (Lat / Lng) *</label>
                            <div class="mt-1 grid grid-cols-2 gap-4">
                                <input v-model="form.latitude" type="number" step="any"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Latitude" />
                                <input v-model="form.longitude" type="number" step="any"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Longitude" />
                            </div>
                            <button type="button" @click="useMyLocation" :disabled="gettingLocation"
                                class="mt-2 inline-flex items-center rounded-md bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200 disabled:opacity-50">
                                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ gettingLocation ? 'Getting location...' : 'Use my location' }}
                            </button>
                            <p v-if="form.errors.latitude" class="mt-1 text-sm text-red-600">{{ form.errors.latitude }}</p>
                            <p v-if="form.errors.longitude" class="mt-1 text-sm text-red-600">{{ form.errors.longitude }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description *</label>
                            <textarea v-model="form.description" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Describe the situation in detail..."></textarea>
                            <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                        </div>

                        <!-- Occurred At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">When did it happen?</label>
                            <input v-model="form.occurred_at" type="datetime-local"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end gap-4">
                            <p v-if="form.recentlySuccessful" class="text-sm text-green-600">Report submitted!</p>
                            <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50">
                                {{ form.processing ? 'Submitting...' : 'Submit Report' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

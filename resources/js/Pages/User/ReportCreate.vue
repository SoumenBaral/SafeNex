<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StepIndicator from '@/Components/UI/StepIndicator.vue';
import LocationPicker from '@/Components/Map/LocationPicker.vue';
import MediaUploader from '@/Components/Report/MediaUploader.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted } from 'vue';

const props = defineProps({
    categories: Array,
    districts:  Array,
});

const currentStep = ref(1);

const steps = [
    { label: 'What happened?' },
    { label: 'Where?' },
    { label: 'Evidence' },
];

const categories = computed(() => {
    const iconMap = {
        'flood':            { emoji: '🌊', color: 'bg-blue-50 border-blue-200' },
        'fire':             { emoji: '🔥', color: 'bg-red-50 border-red-200' },
        'cyclone':          { emoji: '🌀', color: 'bg-purple-50 border-purple-200' },
        'road-accident':    { emoji: '🚗', color: 'bg-orange-50 border-orange-200' },
        'building-collapse':{ emoji: '🏚', color: 'bg-gray-50 border-gray-200' },
        'other':            { emoji: '❓', color: 'bg-green-50 border-green-200' },
    };
    return (props.categories ?? []).map(cat => ({
        ...cat,
        ...(iconMap[cat.slug] ?? { emoji: '⚠', color: 'bg-gray-50 border-gray-200' }),
    }));
});

const severities = [
    { value: 'low',      icon: '●', label: 'Low',      color: 'text-[#2E9E6B]', activeBg: 'bg-[#2E9E6B]/10 border-[#2E9E6B]' },
    { value: 'medium',   icon: '△', label: 'Medium',   color: 'text-[#E0A100]', activeBg: 'bg-[#E0A100]/10 border-[#E0A100]' },
    { value: 'high',     icon: '▲', label: 'High',     color: 'text-[#E5611F]', activeBg: 'bg-[#E5611F]/10 border-[#E5611F]' },
    { value: 'critical', icon: '◆', label: 'Critical', color: 'text-[#D62839]', activeBg: 'bg-[#D62839]/10 border-[#D62839]' },
];

const form = useForm({
    title: '', description: '', category_id: '', district_id: '',
    upazila_id: '', address: '', latitude: '', longitude: '',
    severity: 'medium', occurred_at: '', media: [],
});

const mapLocation = ref({ lat: 23.8103, lng: 90.4125 });
const gettingLocation = ref(false);
const usedGps = ref(false);

watch(mapLocation, (val) => {
    form.latitude  = val.lat;
    form.longitude = val.lng;
}, { deep: true });

const selectedDistrict = computed(() => props.districts?.find(d => d.id == form.district_id));
const upazilas = computed(() => selectedDistrict.value?.upazilas ?? []);
const selectedUpazila = computed(() => upazilas.value.find(u => u.id == form.upazila_id));

// When upazila changes and user hasn't used GPS, center map on upazila
watch(() => form.upazila_id, (id) => {
    if (usedGps.value || !id) return;
    const uz = upazilas.value.find(u => u.id == id);
    if (uz?.lat && uz?.lng) {
        mapLocation.value = { lat: +uz.lat, lng: +uz.lng };
    }
});

function useMyLocation() {
    if (!navigator.geolocation) return;
    gettingLocation.value = true;
    navigator.geolocation.getCurrentPosition(
        (pos) => {
            form.latitude  = pos.coords.latitude.toFixed(7);
            form.longitude = pos.coords.longitude.toFixed(7);
            mapLocation.value = { lat: +form.latitude, lng: +form.longitude };
            usedGps.value = true;
            gettingLocation.value = false;
        },
        () => { gettingLocation.value = false; }
    );
}

const stepErrors = ref('');

function nextStep() {
    stepErrors.value = '';
    if (currentStep.value === 1) {
        if (!form.category_id) { stepErrors.value = 'Please select a disaster type.'; return; }
        if (!form.title.trim()) { stepErrors.value = 'Please enter a title.'; return; }
        if (!form.description.trim()) { stepErrors.value = 'Please enter a description.'; return; }
    }
    if (currentStep.value === 2) {
        if (!form.district_id) { stepErrors.value = 'Please select a district.'; return; }
    }
    if (currentStep.value < 3) currentStep.value++;
}

function prevStep() {
    stepErrors.value = '';
    if (currentStep.value > 1) currentStep.value--;
}

function submit() {
    stepErrors.value = '';
    form.post(route('reports.store'), {
        forceFormData: true,
        onError: () => {
            // Navigate back to first step with errors
            if (form.errors.category_id || form.errors.title || form.errors.description || form.errors.severity) {
                currentStep.value = 1;
            } else if (form.errors.district_id || form.errors.latitude || form.errors.longitude) {
                currentStep.value = 2;
            }
        },
    });
}
</script>

<template>
    <Head title="Submit Report — Safenix" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-8">
                <h1 class="font-display font-bold text-gray-900 text-2xl mb-1">Report an incident</h1>
                <p class="text-gray-500 text-sm">Takes under a minute. Help your district respond faster.</p>
            </div>

            <StepIndicator :steps="steps" :current="currentStep" />

            <div class="bg-white rounded-2xl border border-line shadow-card overflow-hidden">
                <form @submit.prevent="submit">
                    <!-- ── Step 1: What happened? ── -->
                    <div v-if="currentStep === 1" class="p-6 space-y-6">
                        <div>
                            <h2 class="font-display font-semibold text-gray-900 text-lg mb-5">What happened?</h2>

                            <!-- Category icon grid -->
                            <label class="block text-sm font-medium text-gray-700 mb-3">Disaster type <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-3 gap-3">
                                <button
                                    v-for="cat in categories" :key="cat.id"
                                    type="button"
                                    @click="form.category_id = cat.id"
                                    :class="[
                                        'flex flex-col items-center gap-2 p-4 rounded-xl border-2 text-center transition-all',
                                        form.category_id == cat.id
                                            ? 'border-bay-600 bg-bay-50 ring-2 ring-bay-200'
                                            : 'border-gray-200 bg-gray-50 hover:border-gray-300 hover:bg-white',
                                    ]"
                                >
                                    <span class="text-2xl">{{ cat.emoji }}</span>
                                    <span class="text-xs font-medium text-gray-700 leading-tight">{{ cat.name }}</span>
                                </button>
                            </div>
                            <p v-if="form.errors.category_id" class="mt-2 text-xs text-red-600">{{ form.errors.category_id }}</p>
                        </div>

                        <!-- Severity segmented control -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Severity <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-4 gap-2">
                                <button
                                    v-for="sev in severities" :key="sev.value"
                                    type="button"
                                    @click="form.severity = sev.value"
                                    :class="[
                                        'flex flex-col items-center gap-1 py-3 px-2 rounded-xl border-2 text-center transition-all',
                                        form.severity === sev.value
                                            ? sev.activeBg
                                            : 'border-gray-200 bg-gray-50 hover:border-gray-300',
                                    ]"
                                >
                                    <span :class="['text-base', sev.color]">{{ sev.icon }}</span>
                                    <span class="text-xs font-medium text-gray-700">{{ sev.label }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                            <input v-model="form.title" type="text"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500"
                                placeholder="e.g. Flood in Sylhet City" />
                            <p v-if="form.errors.title" class="mt-1 text-xs text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                            <textarea v-model="form.description" rows="4"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 resize-none"
                                placeholder="Describe the situation in detail — what you see, how many people affected, what help is needed…"></textarea>
                            <p v-if="form.errors.description" class="mt-1 text-xs text-red-600">{{ form.errors.description }}</p>
                        </div>
                    </div>

                    <!-- ── Step 2: Where? ── -->
                    <div v-if="currentStep === 2" class="p-6 space-y-5">
                        <h2 class="font-display font-semibold text-gray-900 text-lg mb-2">Where did this happen?</h2>

                        <!-- Use my location -->
                        <button type="button" @click="useMyLocation" :disabled="gettingLocation"
                            class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ gettingLocation ? 'Getting location…' : '⊕ Use my location' }}
                        </button>

                        <!-- Map picker -->
                        <LocationPicker v-model="mapLocation" />

                        <!-- Coordinate readout -->
                        <div v-if="form.latitude && form.longitude" class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2 border border-gray-200">
                            <span class="text-xs text-gray-500">Coordinates:</span>
                            <span class="font-data text-xs text-bay-700">{{ form.latitude }}, {{ form.longitude }}</span>
                        </div>

                        <!-- District + Upazila -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">District <span class="text-red-500">*</span></label>
                                <select v-model="form.district_id" @change="form.upazila_id = ''"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500">
                                    <option value="">Select district</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                                <p v-if="form.errors.district_id" class="mt-1 text-xs text-red-600">{{ form.errors.district_id }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upazila</label>
                                <select v-model="form.upazila_id" :disabled="!upazilas.length"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 disabled:bg-gray-100 disabled:text-gray-400">
                                    <option value="">Select upazila</option>
                                    <option v-for="u in upazilas" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Address / Landmark</label>
                            <input v-model="form.address" type="text"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500"
                                placeholder="Near XYZ market, road number…" />
                        </div>

                        <!-- Occurred at -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">When did it happen?</label>
                            <input v-model="form.occurred_at" type="datetime-local"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500" />
                        </div>
                    </div>

                    <!-- ── Step 3: Evidence ── -->
                    <div v-if="currentStep === 3" class="p-6 space-y-6">
                        <div>
                            <h2 class="font-display font-semibold text-gray-900 text-lg mb-1">Add evidence</h2>
                            <p class="text-gray-500 text-sm">Photos and video help admins verify faster. Optional but recommended.</p>
                        </div>
                        <MediaUploader v-model="form.media" :errors="form.errors" />
                    </div>

                    <!-- Step / server errors -->
                    <div v-if="stepErrors || Object.keys(form.errors).length" class="mx-6 mb-0 mt-0 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                        {{ stepErrors || Object.values(form.errors)[0] }}
                    </div>

                    <!-- ── Navigation footer ── -->
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 border-t border-line">
                        <button v-if="currentStep > 1" type="button" @click="prevStep"
                            class="flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Back
                        </button>
                        <div v-else></div>

                        <button v-if="currentStep < 3" type="button" @click="nextStep"
                            class="inline-flex items-center gap-1.5 bg-bay-600 hover:bg-bay-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>

                        <button v-else type="submit" :disabled="form.processing"
                            class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                            {{ form.processing ? 'Submitting…' : 'Submit report' }}
                            <svg v-if="!form.processing" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

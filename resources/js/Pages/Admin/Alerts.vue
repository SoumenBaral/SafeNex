<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ConfirmModal from '@/Components/UI/ConfirmModal.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    alerts:    Object,
    districts: Array,
});

const showConfirm = ref(false);

const form = useForm({
    title: '', message: '', district_id: '', upazila_id: '',
});

const selectedDistrict = computed(() => props.districts.find(d => d.id == form.district_id));
const upazilas = computed(() => selectedDistrict.value?.upazilas ?? []);

function submit() {
    form.post(route('admin.alerts.store'), {
        onSuccess: () => { form.reset(); showConfirm.value = false; },
    });
}
</script>

<template>
    <Head title="Emergency Alerts — Safenix Admin" />
    <AdminLayout>
        <div class="space-y-6">
            <div>
                <h1 class="font-display font-bold text-white text-2xl">Emergency Alerts</h1>
                <p class="text-ink-400 text-sm mt-1">Broadcast emergency notifications to users in targeted districts</p>
            </div>

            <div class="grid lg:grid-cols-[1fr_360px] gap-6 items-start">
                <!-- Alert history -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 overflow-hidden">
                    <div class="px-5 py-4 border-b border-ink-700">
                        <h2 class="font-display font-semibold text-white text-sm">Sent alerts</h2>
                    </div>
                    <div v-if="!alerts.data.length" class="py-12 flex flex-col items-center justify-center">
                        <p class="text-3xl mb-3">📢</p>
                        <p class="text-ink-400 text-sm">No alerts sent yet</p>
                    </div>
                    <div v-else class="divide-y divide-ink-700">
                        <div v-for="alert in alerts.data" :key="alert.id" class="px-5 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-medium text-sm">{{ alert.title }}</p>
                                    <p class="text-ink-400 text-xs mt-1 leading-relaxed">{{ alert.message }}</p>
                                    <div class="flex items-center gap-3 mt-2 font-data text-xs text-ink-500">
                                        <span>{{ alert.district?.name ?? 'All districts' }}</span>
                                        <span>·</span>
                                        <span>{{ alert.sent_by_user?.name ?? 'Admin' }}</span>
                                        <span>·</span>
                                        <TimeAgo :date="alert.sent_at" />
                                    </div>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-[#D62839]/10 flex items-center justify-center text-sm flex-shrink-0">🚨</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Compose form (sticky) -->
                <div class="bg-ink-800 rounded-xl border border-[#D62839]/30 overflow-hidden lg:sticky lg:top-6">
                    <div class="px-5 py-4 border-b border-ink-700 flex items-center gap-2">
                        <span class="text-base">🚨</span>
                        <h2 class="font-display font-semibold text-white text-sm">Compose alert</h2>
                    </div>
                    <form @submit.prevent="showConfirm = true" class="p-5 space-y-4">
                        <div>
                            <label class="block text-ink-300 text-xs font-medium mb-1.5">Alert title <span class="text-[#D62839]">*</span></label>
                            <input v-model="form.title" type="text"
                                class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 placeholder-ink-500 focus:border-bay-500 focus:ring-0"
                                placeholder="e.g. Flood Warning — Sylhet" />
                            <p v-if="form.errors.title" class="mt-1 text-xs text-[#D62839]">{{ form.errors.title }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-ink-300 text-xs font-medium mb-1.5">Target district</label>
                                <select v-model="form.district_id" @change="form.upazila_id = ''"
                                    class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-xs px-3 py-2 focus:border-bay-500 focus:ring-0">
                                    <option value="">All districts</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-ink-300 text-xs font-medium mb-1.5">Target upazila</label>
                                <select v-model="form.upazila_id" :disabled="!upazilas.length"
                                    class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-xs px-3 py-2 focus:border-bay-500 focus:ring-0 disabled:opacity-50">
                                    <option value="">All upazilas</option>
                                    <option v-for="u in upazilas" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-ink-300 text-xs font-medium mb-1.5">Message <span class="text-[#D62839]">*</span></label>
                            <textarea v-model="form.message" rows="5"
                                class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 placeholder-ink-500 focus:border-bay-500 focus:ring-0 resize-none"
                                placeholder="Describe the emergency. Be specific about what people should do…"></textarea>
                            <p v-if="form.errors.message" class="mt-1 text-xs text-[#D62839]">{{ form.errors.message }}</p>
                        </div>

                        <!-- Reach preview -->
                        <div v-if="form.district_id" class="bg-ink-900 rounded-lg px-3 py-2.5 border border-ink-600">
                            <p class="text-ink-400 text-xs">
                                <span class="text-white font-medium">Target:</span>
                                {{ selectedDistrict?.name }}
                                <template v-if="form.upazila_id"> / {{ upazilas.find(u => u.id == form.upazila_id)?.name }}</template>
                            </p>
                        </div>
                        <div v-else class="bg-ink-900 rounded-lg px-3 py-2.5 border border-ink-600">
                            <p class="text-ink-400 text-xs"><span class="text-white font-medium">Target:</span> All users nationwide</p>
                        </div>

                        <button type="submit" :disabled="form.processing"
                            class="w-full bg-[#D62839] hover:bg-[#B03A4A] disabled:opacity-60 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            🚨 Send emergency alert
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <ConfirmModal
            :show="showConfirm"
            title="Send emergency alert?"
            description="This will immediately notify users in the targeted area. This action cannot be undone."
            confirm-label="Send alert"
            :danger="true"
            @confirm="submit"
            @cancel="showConfirm = false"
        />
    </AdminLayout>
</template>

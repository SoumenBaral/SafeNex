<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SlideOver from '@/Components/UI/SlideOver.vue';
import ConfirmModal from '@/Components/UI/ConfirmModal.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    teams:     Object,
    districts: Array,
});

const showSlideOver = ref(false);
const deleteId      = ref(null);

const form = useForm({
    name: '', leader_name: '', leader_phone: '', leader_email: '', district_id: '',
    members: [{ name: '', email: '', phone: '', role_in_team: '' }],
});

function addMember()     { form.members.push({ name: '', email: '', phone: '', role_in_team: '' }); }
function removeMember(i) { form.members.splice(i, 1); }

function submit() {
    form.post(route('admin.teams.store'), {
        onSuccess: () => {
            form.reset();
            form.members = [{ name: '', email: '', phone: '', role_in_team: '' }];
            showSlideOver.value = false;
        },
    });
}

function confirmDelete(id) { deleteId.value = id; }
function deleteTeam() {
    router.delete(route('admin.teams.destroy', deleteId.value));
    deleteId.value = null;
}

const statusMap = {
    available: { label: 'Available', classes: 'bg-[#157F6B]/10 text-[#157F6B]' },
    busy:      { label: 'Busy',      classes: 'bg-[#E0A100]/10 text-[#E0A100]' },
    offline:   { label: 'Offline',   classes: 'bg-gray-100 text-gray-500' },
};
</script>

<template>
    <Head title="Rescue Teams — Safenix Admin" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-gray-900 text-2xl">Rescue Teams</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage teams and assign them to verified incidents</p>
                </div>
                <button @click="showSlideOver = true"
                    class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    + New team
                </button>
            </div>

            <!-- Empty state -->
            <div v-if="!teams.data.length" class="bg-white rounded-xl border border-gray-200 shadow-sm py-16 flex flex-col items-center justify-center">
                <p class="text-3xl mb-3">🚑</p>
                <p class="text-gray-900 font-semibold font-display">No rescue teams yet</p>
                <p class="text-gray-500 text-sm mt-1">Add your first team to start dispatching responders.</p>
                <button @click="showSlideOver = true" class="mt-5 bg-bay-600 hover:bg-bay-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                    + Create first team
                </button>
            </div>

            <!-- Team cards grid -->
            <div v-else class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                <div
                    v-for="team in teams.data" :key="team.id"
                    class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:border-gray-300 transition-all"
                >
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-display font-semibold text-gray-900 truncate">{{ team.name }}</h3>
                            <p class="text-gray-500 text-xs mt-0.5">{{ team.district?.name ?? 'No district' }}</p>
                        </div>
                        <span :class="['text-xs font-medium px-2.5 py-1 rounded-full flex-shrink-0', statusMap[team.status]?.classes ?? 'bg-gray-100 text-gray-500']">
                            {{ statusMap[team.status]?.label ?? team.status }}
                        </span>
                    </div>

                    <!-- Leader -->
                    <div class="flex items-center gap-2.5 mb-4 pb-4 border-b border-gray-200">
                        <div class="w-8 h-8 rounded-full bg-bay-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ team.leader_name?.charAt(0)?.toUpperCase() }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-gray-900 text-sm font-medium truncate">{{ team.leader_name }}</p>
                            <p class="text-gray-500 text-xs font-data truncate">{{ team.leader_email }}</p>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="space-y-1.5 mb-4">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">
                            {{ team.members?.length ?? 0 }} member{{ (team.members?.length ?? 0) !== 1 ? 's' : '' }}
                        </p>
                        <div v-if="team.members?.length" class="space-y-1">
                            <p v-for="m in team.members.slice(0, 3)" :key="m.id" class="text-gray-600 text-xs truncate">
                                {{ m.name }}<span v-if="m.role_in_team" class="text-gray-400"> · {{ m.role_in_team }}</span>
                            </p>
                            <p v-if="team.members.length > 3" class="text-gray-400 text-xs">+{{ team.members.length - 3 }} more</p>
                        </div>
                    </div>

                    <button @click="confirmDelete(team.id)"
                        class="text-xs text-[#B03A4A] hover:text-[#D62839] transition-colors font-medium">
                        Delete team
                    </button>
                </div>
            </div>
        </div>

        <!-- Create team slide-over -->
        <SlideOver :show="showSlideOver" title="Create rescue team" width="max-w-lg" @close="showSlideOver = false; form.reset()">
            <form @submit.prevent="submit" class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">Team name <span class="text-[#D62839]">*</span></label>
                        <input v-model="form.name" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" placeholder="Mirpur Flood Unit" />
                        <p v-if="form.errors.name" class="mt-1 text-xs text-[#D62839]">{{ form.errors.name }}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">District</label>
                        <select v-model="form.district_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 focus:border-bay-500 focus:ring-0">
                            <option value="">Select district</option>
                            <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">Leader name <span class="text-[#D62839]">*</span></label>
                        <input v-model="form.leader_name" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">Leader phone</label>
                        <input v-model="form.leader_phone" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 uppercase tracking-wider mb-1.5">Leader email</label>
                        <input v-model="form.leader_email" type="email" class="w-full bg-gray-50 border border-gray-200 rounded-lg text-gray-900 text-sm px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                    </div>
                </div>

                <!-- Members -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-xs font-medium text-gray-600 uppercase tracking-wider">Team members</label>
                        <button type="button" @click="addMember" class="text-xs text-bay-600 hover:text-bay-700 font-medium">+ Add member</button>
                    </div>
                    <div class="space-y-3">
                        <div v-for="(member, i) in form.members" :key="i" class="bg-gray-50 border border-gray-200 rounded-xl p-3 space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <input v-model="member.name"  type="text"  placeholder="Name *" class="bg-white border border-gray-200 rounded-lg text-gray-900 text-xs px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                                <input v-model="member.email" type="email" placeholder="Email *" class="bg-white border border-gray-200 rounded-lg text-gray-900 text-xs px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                                <input v-model="member.phone" type="text"  placeholder="Phone"   class="bg-white border border-gray-200 rounded-lg text-gray-900 text-xs px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                                <input v-model="member.role_in_team" type="text" placeholder="Role (Diver, Medic…)" class="bg-white border border-gray-200 rounded-lg text-gray-900 text-xs px-3 py-2 placeholder-gray-400 focus:border-bay-500 focus:ring-0" />
                            </div>
                            <button v-if="form.members.length > 1" type="button" @click="removeMember(i)"
                                class="text-xs text-[#D62839] hover:text-red-400">Remove</button>
                        </div>
                    </div>
                </div>
            </form>

            <template #footer>
                <div class="flex gap-3">
                    <button @click="showSlideOver = false; form.reset()" class="flex-1 text-sm font-medium text-gray-600 border border-gray-200 px-4 py-2.5 rounded-xl hover:bg-gray-100 hover:text-gray-900 transition-colors">
                        Cancel
                    </button>
                    <button @click="submit" :disabled="form.processing"
                        class="flex-1 text-sm font-semibold bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white px-4 py-2.5 rounded-xl transition-colors">
                        {{ form.processing ? 'Creating…' : 'Create team' }}
                    </button>
                </div>
            </template>
        </SlideOver>

        <ConfirmModal
            :show="!!deleteId"
            title="Delete rescue team?"
            description="This will permanently remove the team and all its members. This cannot be undone."
            confirm-label="Delete team"
            :danger="true"
            @confirm="deleteTeam"
            @cancel="deleteId = null"
        />
    </AdminLayout>
</template>

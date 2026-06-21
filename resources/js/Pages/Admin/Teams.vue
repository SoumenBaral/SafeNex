<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    teams: Object,
    districts: Array,
});

const showCreateModal = ref(false);

const form = useForm({
    name: '',
    leader_name: '',
    leader_phone: '',
    leader_email: '',
    district_id: '',
    members: [{ name: '', email: '', phone: '', role_in_team: '' }],
});

function addMember() {
    form.members.push({ name: '', email: '', phone: '', role_in_team: '' });
}

function removeMember(i) {
    form.members.splice(i, 1);
}

function submit() {
    form.post(route('admin.teams.store'), {
        onSuccess: () => {
            form.reset();
            form.members = [{ name: '', email: '', phone: '', role_in_team: '' }];
            showCreateModal.value = false;
        },
    });
}

function deleteTeam(id) {
    if (confirm('Delete this rescue team?')) {
        router.delete(route('admin.teams.destroy', id));
    }
}

const statusColors = {
    available: 'bg-green-100 text-green-800',
    busy: 'bg-yellow-100 text-yellow-800',
    offline: 'bg-gray-100 text-gray-800',
};
</script>

<template>
    <Head title="Rescue Teams" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Rescue Teams</h2>
                <button @click="showCreateModal = true"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    + New Team
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="teams.data.length === 0" class="p-6 text-center text-gray-500">No rescue teams yet.</div>
                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="team in teams.data" :key="team.id" class="p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-base font-semibold text-gray-900">{{ team.name }}</h3>
                                        <span :class="statusColors[team.status]"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ team.status }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Leader: {{ team.leader_name }}
                                        <span v-if="team.leader_phone"> &middot; {{ team.leader_phone }}</span>
                                        <span v-if="team.district"> &middot; {{ team.district.name }}</span>
                                    </p>
                                    <p class="mt-1 text-sm text-gray-400">{{ team.members_count }} member(s)</p>

                                    <div v-if="team.members.length" class="mt-2">
                                        <p class="text-xs font-medium text-gray-500 uppercase">Members:</p>
                                        <ul class="mt-1 text-sm text-gray-600 space-y-0.5">
                                            <li v-for="m in team.members" :key="m.id">
                                                {{ m.name }} ({{ m.email }})
                                                <span v-if="m.role_in_team" class="text-gray-400">- {{ m.role_in_team }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <button @click="deleteTeam(team.id)" class="text-sm text-red-600 hover:text-red-500">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Team Modal -->
        <Teleport to="body">
            <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto py-8">
                <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl mx-4">
                    <h3 class="text-lg font-semibold text-gray-900">Create Rescue Team</h3>

                    <form @submit.prevent="submit" class="mt-4 space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Team Name *</label>
                                <input v-model="form.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">District</label>
                                <select v-model="form.district_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Leader Name *</label>
                                <input v-model="form.leader_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Leader Phone</label>
                                <input v-model="form.leader_phone" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Leader Email</label>
                                <input v-model="form.leader_email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <!-- Members -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">Team Members</label>
                                <button type="button" @click="addMember" class="text-sm text-indigo-600 hover:text-indigo-500">+ Add Member</button>
                            </div>
                            <div v-for="(member, i) in form.members" :key="i" class="mt-2 grid grid-cols-5 gap-2 items-end">
                                <input v-model="member.name" type="text" placeholder="Name *" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <input v-model="member.email" type="email" placeholder="Email *" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <input v-model="member.phone" type="text" placeholder="Phone" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <input v-model="member.role_in_team" type="text" placeholder="Role (Driver, Medic...)" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <button v-if="form.members.length > 1" type="button" @click="removeMember(i)"
                                    class="text-red-500 hover:text-red-700 text-sm pb-2">&times;</button>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="showCreateModal = false; form.reset()"
                                class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">Cancel</button>
                            <button type="submit" :disabled="form.processing"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50">
                                {{ form.processing ? 'Creating...' : 'Create Team' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </AuthenticatedLayout>
</template>

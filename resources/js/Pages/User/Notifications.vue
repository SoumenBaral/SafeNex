<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    notifications: Object,
});

async function markAsRead(id) {
    await axios.post(route('notifications.read', id));
    router.reload();
}

async function markAllRead() {
    await axios.post(route('notifications.mark-all-read'));
    router.reload();
}
</script>

<template>
    <Head title="Notifications" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Notifications</h2>
                <button v-if="notifications.data.length" @click="markAllRead"
                    class="text-sm text-indigo-600 hover:text-indigo-500">
                    Mark all as read
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="notifications.data.length === 0" class="p-6 text-center text-gray-500">
                        No notifications yet.
                    </div>

                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="n in notifications.data" :key="n.id"
                            :class="['p-4 flex items-start gap-3', !n.read_at ? 'bg-indigo-50' : '']">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">{{ n.data.message }}</p>
                                <p class="mt-1 text-xs text-gray-400">{{ new Date(n.created_at).toLocaleString() }}</p>
                            </div>
                            <button v-if="!n.read_at" @click="markAsRead(n.id)"
                                class="text-xs text-indigo-600 hover:text-indigo-500 whitespace-nowrap">
                                Mark read
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

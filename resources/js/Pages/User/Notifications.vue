<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import EmptyState from '@/Components/UI/EmptyState.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    notifications: Object,
});

async function markAsRead(id) {
    await axios.post(route('notifications.read', id));
    router.reload({ only: ['notifications'] });
}

async function markAllRead() {
    await axios.post(route('notifications.mark-all-read'));
    router.reload({ only: ['notifications'] });
}

const typeIcon = {
    'report_approved': '✓',
    'report_rejected': '✕',
    'emergency_alert': '🚨',
};

function getIcon(type) {
    return typeIcon[type] ?? 'ℹ';
}

function getIconClass(type) {
    if (type === 'report_approved') return 'bg-[#157F6B]/10 text-[#157F6B]';
    if (type === 'report_rejected') return 'bg-[#B03A4A]/10 text-[#B03A4A]';
    if (type === 'emergency_alert') return 'bg-[#D62839]/10 text-[#D62839]';
    return 'bg-bay-50 text-bay-600';
}

// Group notifications by date label
function groupLabel(dateStr) {
    const d = new Date(dateStr);
    const today = new Date();
    const yesterday = new Date(today); yesterday.setDate(today.getDate() - 1);
    if (d.toDateString() === today.toDateString())     return 'Today';
    if (d.toDateString() === yesterday.toDateString()) return 'Yesterday';
    const diffDays = Math.floor((today - d) / 86400000);
    if (diffDays < 7) return 'This week';
    return 'Earlier';
}

const grouped = computed(() => {
    const groups = {};
    (props.notifications.data ?? []).forEach(n => {
        const label = groupLabel(n.created_at);
        if (!groups[label]) groups[label] = [];
        groups[label].push(n);
    });
    return groups;
});
</script>

<script>
import { computed } from 'vue';
export default { name: 'Notifications' };
</script>

<template>
    <Head title="Notifications — Safenix" />
    <AuthenticatedLayout>
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-10 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-gray-900 text-2xl">Notifications</h1>
                    <p class="text-gray-500 text-sm mt-1">Updates on your reports and emergency alerts</p>
                </div>
                <button v-if="notifications.data.length" @click="markAllRead"
                    class="text-sm text-bay-600 hover:text-bay-700 font-medium transition-colors">
                    Mark all as read
                </button>
            </div>

            <!-- Empty state -->
            <EmptyState
                v-if="!notifications.data.length"
                icon="🔔"
                title="No notifications yet"
                description="You'll be notified when your reports are reviewed or when there are emergency alerts in your area."
            />

            <!-- Grouped list -->
            <div v-else class="space-y-6">
                <div v-for="(items, label) in grouped" :key="label">
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">{{ label }}</h2>
                    <div class="bg-white rounded-xl border border-line shadow-card overflow-hidden divide-y divide-gray-100">
                        <div
                            v-for="n in items" :key="n.id"
                            :class="[
                                'flex items-start gap-4 p-4 transition-colors',
                                !n.read_at ? 'bg-bay-50/50 border-l-[3px] border-bay-500' : 'hover:bg-gray-50',
                            ]"
                        >
                            <!-- Icon -->
                            <div :class="['w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5', getIconClass(n.type)]">
                                {{ getIcon(n.type) }}
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-900 text-sm leading-snug">{{ n.data?.message ?? n.data?.title }}</p>
                                <p class="text-gray-400 text-xs font-data mt-1">{{ new Date(n.created_at).toLocaleString() }}</p>
                            </div>

                            <!-- Unread dot + mark read -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span v-if="!n.read_at" class="w-2 h-2 rounded-full bg-bay-500"></span>
                                <button v-if="!n.read_at" @click="markAsRead(n.id)"
                                    class="text-xs text-bay-600 hover:text-bay-700 font-medium">
                                    Read
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="notifications.last_page > 1" class="flex justify-center gap-1">
                <a
                    v-for="link in notifications.links" :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
                        link.active ? 'bg-bay-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                        !link.url   ? 'opacity-40 pointer-events-none' : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

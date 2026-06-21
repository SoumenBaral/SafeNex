<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const count = ref(0);
const open = ref(false);

async function fetchCount() {
    try {
        const res = await axios.get(route('notifications.unread-count'));
        count.value = res.data.count;
    } catch {}
}

onMounted(() => {
    fetchCount();

    // Listen for real-time notifications via Echo
    if (window.Echo) {
        const userId = document.querySelector('meta[name="user-id"]')?.content;
        if (userId) {
            window.Echo.private(`App.Models.User.${userId}`)
                .notification(() => {
                    count.value++;
                });
        }
    }

    // Refresh count periodically as fallback
    setInterval(fetchCount, 30000);
});
</script>

<template>
    <Link :href="route('notifications')" class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span v-if="count > 0"
            class="absolute -right-0.5 -top-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
            {{ count > 99 ? '99+' : count }}
        </span>
    </Link>
</template>

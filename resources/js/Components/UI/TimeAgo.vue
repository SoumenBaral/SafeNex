<script setup>
import { computed } from 'vue';

const props = defineProps({
    date: { type: String, required: true },
});

const label = computed(() => {
    const diff = Math.floor((Date.now() - new Date(props.date)) / 1000);
    if (diff < 60)   return `${diff}s ago`;
    if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
    return `${Math.floor(diff / 86400)}d ago`;
});
</script>

<template>
    <time :datetime="date" class="font-data text-xs text-gray-400" :title="date">{{ label }}</time>
</template>

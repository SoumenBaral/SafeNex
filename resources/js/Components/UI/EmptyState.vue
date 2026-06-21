<script setup>
defineProps({
    icon:        { type: String, default: '📭' },
    title:       { type: String, required: true },
    description: { type: String, default: '' },
    actionLabel: { type: String, default: '' },
    actionHref:  { type: String, default: '' },
});

const emit = defineEmits(['action']);
</script>

<template>
    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
        <div class="text-5xl mb-4 select-none" aria-hidden="true">{{ icon }}</div>
        <h3 class="text-base font-semibold font-display text-gray-800 mb-1">{{ title }}</h3>
        <p v-if="description" class="text-sm text-gray-500 max-w-xs">{{ description }}</p>
        <a
            v-if="actionHref"
            :href="actionHref"
            class="mt-5 inline-flex items-center gap-1.5 bg-bay-600 hover:bg-bay-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"
        >
            {{ actionLabel }}
        </a>
        <button
            v-else-if="actionLabel"
            @click="emit('action')"
            class="mt-5 inline-flex items-center gap-1.5 bg-bay-600 hover:bg-bay-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors"
        >
            {{ actionLabel }}
        </button>
    </div>
</template>

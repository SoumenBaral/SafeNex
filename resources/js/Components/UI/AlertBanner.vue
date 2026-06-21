<script setup>
import { ref } from 'vue';

defineProps({
    message: { type: String, required: true },
    variant: { type: String, default: 'success' }, // success | info | warning | error
});

const dismissed = ref(false);

const map = {
    success: { bg: 'bg-[#157F6B]/10 border-[#157F6B]/30 text-[#157F6B]', icon: '✓' },
    info:    { bg: 'bg-bay-50 border-bay-200 text-bay-700',               icon: 'ℹ' },
    warning: { bg: 'bg-[#B7791F]/10 border-[#B7791F]/30 text-[#B7791F]', icon: '⚠' },
    error:   { bg: 'bg-[#B03A4A]/10 border-[#B03A4A]/30 text-[#B03A4A]', icon: '✕' },
};
</script>

<template>
    <div
        v-if="!dismissed"
        :class="['flex items-center gap-3 px-4 py-3 rounded-lg border text-sm font-medium mb-4', map[variant]?.bg]"
        role="alert"
    >
        <span>{{ map[variant]?.icon }}</span>
        <span class="flex-1">{{ message }}</span>
        <button @click="dismissed = true" class="opacity-60 hover:opacity-100 ml-2" aria-label="Dismiss">✕</button>
    </div>
</template>

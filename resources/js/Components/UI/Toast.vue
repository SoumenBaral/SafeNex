<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    message:  { type: String, required: true },
    variant:  { type: String, default: 'success' }, // success | info | alert | error
    duration: { type: Number, default: 4000 },
});

const emit = defineEmits(['close']);
const visible = ref(false);

const variantMap = {
    success: { bg: 'bg-[#157F6B]',  icon: '✓' },
    info:    { bg: 'bg-bay-600',     icon: 'ℹ' },
    alert:   { bg: 'bg-[#B7791F]',  icon: '⚠' },
    error:   { bg: 'bg-[#B03A4A]',  icon: '✕' },
};

onMounted(() => {
    requestAnimationFrame(() => { visible.value = true; });
    setTimeout(() => { visible.value = false; setTimeout(() => emit('close'), 300); }, props.duration);
});
</script>

<template>
    <div
        :class="[
            'fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-lg text-white text-sm font-medium shadow-lift transition-all duration-300',
            variantMap[variant]?.bg ?? 'bg-gray-800',
            visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2',
        ]"
        role="alert"
    >
        <span class="text-base">{{ variantMap[variant]?.icon }}</span>
        {{ message }}
        <button @click="emit('close')" class="ml-2 opacity-70 hover:opacity-100" aria-label="Dismiss">✕</button>
    </div>
</template>

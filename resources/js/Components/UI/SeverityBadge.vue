<script setup>
defineProps({
    level: { type: String, required: true }, // low | medium | high | critical
    size:  { type: String, default: 'sm' },  // sm | md
});

const map = {
    low:      { icon: '●', label: 'Low',      classes: 'bg-[#2E9E6B]/10 text-[#2E9E6B]' },
    medium:   { icon: '△', label: 'Medium',   classes: 'bg-[#E0A100]/10 text-[#E0A100]' },
    high:     { icon: '▲', label: 'High',     classes: 'bg-[#E5611F]/10 text-[#E5611F]' },
    critical: { icon: '◆', label: 'Critical', classes: 'bg-[#D62839]/10 text-[#D62839]' },
};
</script>

<template>
    <span
        :class="[
            'inline-flex items-center gap-1 font-medium rounded-full',
            map[level]?.classes ?? 'bg-gray-100 text-gray-600',
            size === 'md' ? 'px-3 py-1 text-sm' : 'px-2 py-0.5 text-xs',
        ]"
        :title="map[level]?.label"
    >
        <span aria-hidden="true">{{ map[level]?.icon }}</span>
        {{ map[level]?.label ?? level }}
    </span>
</template>

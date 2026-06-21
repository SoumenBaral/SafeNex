<script setup>
defineProps({
    status: { type: String, required: true }, // pending | verified | rejected
    size:   { type: String, default: 'sm' },
});

const map = {
    pending:  { icon: '◷', label: 'Awaiting review', classes: 'bg-[#B7791F]/10 text-[#B7791F]' },
    verified: { icon: '✓', label: 'Verified',        classes: 'bg-[#157F6B]/10 text-[#157F6B]' },
    rejected: { icon: '✕', label: 'Not verified',    classes: 'bg-[#B03A4A]/10 text-[#B03A4A]' },
};
</script>

<template>
    <span
        :class="[
            'inline-flex items-center gap-1 font-medium rounded-full',
            map[status]?.classes ?? 'bg-gray-100 text-gray-600',
            size === 'md' ? 'px-3 py-1 text-sm' : 'px-2 py-0.5 text-xs',
        ]"
    >
        <span aria-hidden="true">{{ map[status]?.icon }}</span>
        {{ map[status]?.label ?? status }}
    </span>
</template>

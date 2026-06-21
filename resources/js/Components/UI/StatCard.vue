<script setup>
defineProps({
    label:  { type: String,  required: true },
    value:  { type: [Number, String], required: true },
    icon:   { type: String,  default: '' },
    iconBg: { type: String,  default: 'bg-gray-100' },
    trend:  { type: String,  default: '' },   // e.g. "↑ 4 today"
    trendUp:{ type: Boolean, default: true },
    href:   { type: String,  default: '' },
    dark:   { type: Boolean, default: false },
});
</script>

<template>
    <component
        :is="href ? 'a' : 'div'"
        :href="href || undefined"
        :class="[
            'group rounded-xl p-5 ring-1 transition-all duration-200 flex items-start gap-4',
            dark
                ? 'bg-ink-800 ring-ink-600 hover:ring-bay-500'
                : 'bg-white ring-gray-200 shadow-card hover:shadow-lift hover:ring-bay-400',
        ]"
    >
        <!-- Icon -->
        <div v-if="icon" :class="['w-11 h-11 rounded-lg flex items-center justify-center text-xl flex-shrink-0', iconBg]">
            {{ icon }}
        </div>
        <!-- Text -->
        <div class="min-w-0">
            <p :class="['text-xs font-medium uppercase tracking-wider truncate', dark ? 'text-ink-500' : 'text-gray-500']">
                {{ label }}
            </p>
            <p :class="['font-data text-3xl font-semibold mt-0.5 leading-none', dark ? 'text-white' : 'text-gray-900']">
                {{ value }}
            </p>
            <p v-if="trend" :class="['text-xs mt-1.5 font-medium', trendUp ? 'text-[#2E9E6B]' : 'text-[#D62839]']">
                {{ trend }}
            </p>
        </div>
    </component>
</template>

<script setup>
defineProps({
    steps:   { type: Array, required: true },  // [{ label: 'What happened?' }, ...]
    current: { type: Number, required: true },  // 1-based
});
</script>

<template>
    <nav aria-label="Progress" class="flex items-center justify-center gap-0 mb-8">
        <template v-for="(step, i) in steps" :key="i">
            <!-- Step circle -->
            <div class="flex flex-col items-center">
                <div
                    :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold transition-colors',
                        i + 1 < current  ? 'bg-bay-600 text-white' :
                        i + 1 === current ? 'bg-bay-600 text-white ring-4 ring-bay-100' :
                                            'bg-gray-100 text-gray-400',
                    ]"
                    :aria-current="i + 1 === current ? 'step' : undefined"
                >
                    <span v-if="i + 1 < current">✓</span>
                    <span v-else>{{ i + 1 }}</span>
                </div>
                <span
                    :class="[
                        'mt-1.5 text-xs font-medium whitespace-nowrap hidden sm:block',
                        i + 1 === current ? 'text-bay-600' : 'text-gray-400',
                    ]"
                >{{ step.label }}</span>
            </div>
            <!-- Connector line -->
            <div
                v-if="i < steps.length - 1"
                :class="[
                    'h-0.5 w-12 sm:w-20 mx-1 mb-5 transition-colors',
                    i + 1 < current ? 'bg-bay-600' : 'bg-gray-200',
                ]"
            />
        </template>
    </nav>
</template>

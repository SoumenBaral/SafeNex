<script setup>
defineProps({
    show:        { type: Boolean, required: true },
    title:       { type: String,  default: 'Are you sure?' },
    description: { type: String,  default: 'This action cannot be undone.' },
    confirmLabel:{ type: String,  default: 'Confirm' },
    cancelLabel: { type: String,  default: 'Cancel' },
    danger:      { type: Boolean, default: false },
});

const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/50" @click="emit('cancel')" />
                <!-- Panel -->
                <div class="relative bg-white rounded-xl shadow-lift p-6 max-w-md w-full mx-4 animate-fade-in">
                    <h3 class="text-base font-semibold font-display text-gray-900 mb-2">{{ title }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ description }}</p>
                    <div class="flex gap-3 justify-end">
                        <button
                            @click="emit('cancel')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            {{ cancelLabel }}
                        </button>
                        <button
                            @click="emit('confirm')"
                            :class="[
                                'px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors',
                                danger ? 'bg-red-600 hover:bg-red-700' : 'bg-bay-600 hover:bg-bay-700',
                            ]"
                        >
                            {{ confirmLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

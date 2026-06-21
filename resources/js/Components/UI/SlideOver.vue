<script setup>
defineProps({
    show:  { type: Boolean, required: true },
    title: { type: String,  default: '' },
    width: { type: String,  default: 'max-w-md' },
});

const emit = defineEmits(['close']);
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="show" class="fixed inset-0 z-50 flex">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/40" @click="emit('close')" />
                <!-- Panel slides in from right -->
                <div :class="['relative ml-auto h-full bg-white shadow-lift flex flex-col w-full', width]">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h2 class="text-base font-semibold font-display text-gray-900">{{ title }}</h2>
                        <button
                            @click="emit('close')"
                            class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded"
                            aria-label="Close"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto px-6 py-5">
                        <slot />
                    </div>
                    <div v-if="$slots.footer" class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

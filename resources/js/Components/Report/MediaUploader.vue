<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: { type: Array, default: () => [] },
    maxFiles: { type: Number, default: 6 },
    errors: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['update:modelValue']);

const previews = ref([]);

function handleFiles(event) {
    const files = Array.from(event.target.files);
    const current = props.modelValue;

    if (current.length + files.length > props.maxFiles) {
        alert(`Maximum ${props.maxFiles} files allowed.`);
        return;
    }

    const newFiles = [...current, ...files];
    emit('update:modelValue', newFiles);

    // Generate previews
    files.forEach(file => {
        const url = URL.createObjectURL(file);
        previews.value.push({
            url,
            name: file.name,
            type: file.type.startsWith('video/') ? 'video' : 'image',
            size: (file.size / 1024 / 1024).toFixed(2),
        });
    });

    // Reset input
    event.target.value = '';
}

function removeFile(index) {
    const newFiles = [...props.modelValue];
    newFiles.splice(index, 1);
    emit('update:modelValue', newFiles);

    URL.revokeObjectURL(previews.value[index].url);
    previews.value.splice(index, 1);
}

const hasErrors = computed(() => {
    return Object.keys(props.errors).some(k => k.startsWith('media'));
});
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-gray-700">Photos / Video (max {{ maxFiles }})</label>

        <div class="mt-2">
            <label v-if="modelValue.length < maxFiles"
                class="flex cursor-pointer items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-6 text-center hover:border-indigo-400 transition">
                <div>
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">Click to upload images or video</p>
                    <p class="text-xs text-gray-400">JPG, PNG, WebP (5MB) or MP4 (30MB)</p>
                </div>
                <input type="file" multiple accept="image/jpeg,image/png,image/webp,video/mp4" class="hidden" @change="handleFiles" />
            </label>
        </div>

        <!-- Previews -->
        <div v-if="previews.length" class="mt-3 grid grid-cols-3 gap-3">
            <div v-for="(preview, i) in previews" :key="i" class="relative group">
                <img v-if="preview.type === 'image'" :src="preview.url" class="h-24 w-full rounded-md object-cover" />
                <div v-else class="flex h-24 items-center justify-center rounded-md bg-gray-100 text-sm text-gray-500">
                    Video ({{ preview.size }}MB)
                </div>
                <button @click="removeFile(i)" type="button"
                    class="absolute -right-1 -top-1 hidden group-hover:flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-white text-xs">
                    &times;
                </button>
            </div>
        </div>

        <!-- Errors -->
        <template v-if="hasErrors">
            <p v-for="(msg, key) in errors" :key="key" class="mt-1 text-sm text-red-600">
                <template v-if="key.startsWith('media')">{{ msg }}</template>
            </p>
        </template>
    </div>
</template>

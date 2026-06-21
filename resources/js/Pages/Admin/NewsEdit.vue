<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    article: Object,
    categories: Array,
    districts: Array,
});

const form = useForm({
    title: props.article.title,
    excerpt: props.article.excerpt ?? '',
    body: props.article.body,
    category_id: props.article.category_id ?? '',
    district_id: props.article.district_id ?? '',
    status: props.article.status,
    cover_image: null,
});

function submit() {
    form.post(route('admin.news.update', props.article.id), {
        forceFormData: true,
        _method: 'put',
    });
}
</script>

<template>
    <Head :title="`Edit: ${article.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Article</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input v-model="form.title" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <select v-model="form.category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">None</option>
                                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">District</label>
                                <select v-model="form.district_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">None</option>
                                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Excerpt</label>
                            <textarea v-model="form.excerpt" rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Body *</label>
                            <textarea v-model="form.body" rows="12"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <p v-if="form.errors.body" class="mt-1 text-sm text-red-600">{{ form.errors.body }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cover Image</label>
                            <img v-if="article.cover_image" :src="`/storage/${article.cover_image}`"
                                class="mb-2 h-32 w-auto rounded-md object-cover" />
                            <input type="file" accept="image/*" @change="form.cover_image = $event.target.files[0]"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-2 flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" v-model="form.status" value="draft" class="text-indigo-600 focus:ring-indigo-500" />
                                    <span class="text-sm text-gray-700">Draft</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" v-model="form.status" value="published" class="text-indigo-600 focus:ring-indigo-500" />
                                    <span class="text-sm text-gray-700">Published</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" :disabled="form.processing"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:opacity-50">
                                {{ form.processing ? 'Saving...' : 'Update Article' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    articles: Object,
    currentStatus: String,
});

const tabs = [
    { value: 'all', label: 'All' },
    { value: 'published', label: 'Published' },
    { value: 'draft', label: 'Drafts' },
];

function filterByStatus(status) {
    router.get(route('admin.news.index'), { status: status === 'all' ? undefined : status }, { preserveState: true });
}

function deleteArticle(id) {
    if (confirm('Delete this article?')) {
        router.delete(route('admin.news.destroy', id));
    }
}
</script>

<template>
    <Head title="Admin - News" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">News Management</h2>
                <Link :href="route('admin.news.create')"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    + New Article
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-4 flex gap-2">
                    <button v-for="tab in tabs" :key="tab.value" @click="filterByStatus(tab.value)"
                        :class="['rounded-md px-4 py-2 text-sm font-medium', currentStatus === tab.value ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300']">
                        {{ tab.label }}
                    </button>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="articles.data.length === 0" class="p-6 text-center text-gray-500">No articles found.</div>
                    <div v-else class="divide-y divide-gray-200">
                        <div v-for="article in articles.data" :key="article.id" class="p-6 flex items-start justify-between gap-4">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ article.title }}</h3>
                                    <span :class="article.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                        {{ article.status }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    By {{ article.author?.name }}
                                    <span v-if="article.category"> &middot; {{ article.category.name }}</span>
                                    <span v-if="article.district"> &middot; {{ article.district.name }}</span>
                                    &middot; {{ article.views }} views
                                </div>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <Link :href="route('admin.news.edit', article.id)" class="text-sm text-indigo-600 hover:text-indigo-500">Edit</Link>
                                <button @click="deleteArticle(article.id)" class="text-sm text-red-600 hover:text-red-500">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

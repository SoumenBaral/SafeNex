<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    article: Object,
});
</script>

<template>
    <Head :title="article.title" />

    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">Safenix</Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-sm text-gray-600 hover:text-gray-900">Live Map</Link>
                        <Link :href="route('news.index')" class="text-sm text-gray-600 hover:text-gray-900">News</Link>
                    </div>
                </div>
            </div>
        </nav>

        <article class="mx-auto max-w-3xl px-6 py-12 lg:px-8">
            <Link :href="route('news.index')" class="text-sm text-indigo-600 hover:text-indigo-500">&larr; Back to News</Link>

            <div class="mt-6">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span v-if="article.category">{{ article.category.name }}</span>
                    <span v-if="article.district">&middot; {{ article.district.name }}</span>
                    <span>&middot; {{ article.views }} views</span>
                </div>

                <h1 class="mt-3 text-3xl font-bold text-gray-900">{{ article.title }}</h1>

                <div class="mt-2 text-sm text-gray-500">
                    By {{ article.author?.name }} &middot; {{ new Date(article.published_at).toLocaleDateString() }}
                </div>
            </div>

            <div v-if="article.cover_image" class="mt-6">
                <img :src="`/storage/${article.cover_image}`" :alt="article.title"
                    class="w-full rounded-lg object-cover" style="max-height: 400px;" />
            </div>

            <div class="mt-8 prose prose-indigo max-w-none text-gray-800 whitespace-pre-wrap">
                {{ article.body }}
            </div>
        </article>
    </div>
</template>

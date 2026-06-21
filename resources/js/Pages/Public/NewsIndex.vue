<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    articles: Object,
    districts: Array,
    categories: Array,
    filters: Object,
});

const districtFilter = ref(props.filters?.district_id ?? '');
const categoryFilter = ref(props.filters?.category_id ?? '');

function applyFilters() {
    router.get(route('news.index'), {
        district_id: districtFilter.value || undefined,
        category_id: categoryFilter.value || undefined,
    }, { preserveState: true });
}

function clearFilters() {
    districtFilter.value = '';
    categoryFilter.value = '';
    router.get(route('news.index'));
}
</script>

<template>
    <Head title="Disaster News" />

    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">Safenix</Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-sm text-gray-600 hover:text-gray-900">Live Map</Link>
                        <Link :href="route('news.index')" class="text-sm font-medium text-indigo-600">News</Link>
                        <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Dashboard</Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                            <Link :href="route('register')" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Register</Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Disaster News</h1>

            <!-- Filters -->
            <div v-if="districts" class="mt-4 flex flex-wrap items-center gap-3">
                <select v-model="districtFilter" @change="applyFilters"
                    class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Districts</option>
                    <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                </select>
                <select v-model="categoryFilter" @change="applyFilters"
                    class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Categories</option>
                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
                <button v-if="districtFilter || categoryFilter" @click="clearFilters"
                    class="text-sm text-indigo-600 hover:text-indigo-500">Clear filters</button>
            </div>

            <div v-if="!articles?.data?.length" class="mt-8 rounded-lg bg-white p-12 text-center shadow-sm ring-1 ring-gray-200">
                <p class="text-gray-500">No news articles found.</p>
            </div>

            <div v-else class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Link v-for="article in articles.data" :key="article.id"
                    :href="route('news.show', article.slug)"
                    class="group overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200 hover:shadow-md transition">
                    <div v-if="article.cover_image" class="h-48 overflow-hidden">
                        <img :src="`/storage/${article.cover_image}`" :alt="article.title"
                            class="h-full w-full object-cover group-hover:scale-105 transition duration-300" />
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span v-if="article.category" :style="{ color: article.category.color }">{{ article.category.name }}</span>
                            <span v-if="article.district">&middot; {{ article.district.name }}</span>
                        </div>
                        <h2 class="mt-2 text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2">
                            {{ article.title }}
                        </h2>
                        <p v-if="article.excerpt" class="mt-2 text-sm text-gray-600 line-clamp-3">{{ article.excerpt }}</p>
                        <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                            <span>{{ article.author?.name }}</span>
                            <span>{{ new Date(article.published_at).toLocaleDateString() }}</span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="articles?.links && articles.last_page > 1" class="mt-8 flex justify-center gap-1">
                <Link v-for="link in articles.links" :key="link.label"
                    :href="link.url ?? '#'"
                    :class="['px-3 py-1 rounded text-sm', link.active ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100', !link.url ? 'opacity-50 pointer-events-none' : '']"
                    v-html="link.label" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    articles:   Object,
    districts:  Array,
    categories: Array,
    filters:    Object,
});

const districtFilter  = ref(props.filters?.district_id ?? '');
const categoryFilter  = ref(props.filters?.category_id ?? '');

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

const heroArticle = computed(() => props.articles?.data?.[0] ?? null);
const restArticles = computed(() => props.articles?.data?.slice(1) ?? []);

function isBreaking(dateStr) {
    return (Date.now() - new Date(dateStr)) < 86400000;
}
</script>

<template>
    <Head title="Disaster News — Safenix" />

    <div class="min-h-screen bg-paper">
        <!-- Navbar -->
        <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-line shadow-sm">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-bay-600 flex items-center justify-center text-white text-xs font-bold font-display">S</div>
                        <span class="font-display font-bold text-gray-900 text-base">Safenix</span>
                    </Link>
                    <div class="flex items-center gap-2">
                        <Link :href="route('map')" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">Live Map</Link>
                        <Link :href="route('news.index')" class="px-3 py-2 text-sm font-medium text-bay-600 bg-bay-50 rounded-lg">News</Link>
                        <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                            class="px-4 py-2 text-sm font-medium bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">Sign in</Link>
                            <Link :href="route('register')" class="px-4 py-2 text-sm font-medium bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors">Register</Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10">
            <!-- Header + filters -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5 mb-8">
                <div>
                    <h1 class="font-display font-bold text-gray-900 text-3xl">Disaster News</h1>
                    <p class="text-gray-500 text-sm mt-1">Verified incident reports and emergency updates</p>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <select v-model="districtFilter" @change="applyFilters"
                        class="rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 bg-white">
                        <option value="">All districts</option>
                        <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                    </select>
                    <select v-model="categoryFilter" @change="applyFilters"
                        class="rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 bg-white">
                        <option value="">All types</option>
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <button v-if="districtFilter || categoryFilter" @click="clearFilters"
                        class="text-sm text-bay-600 hover:text-bay-700 font-medium px-3 py-2 rounded-lg hover:bg-bay-50 transition-colors">
                        Clear
                    </button>
                </div>
            </div>

            <!-- Empty state -->
            <div v-if="!articles?.data?.length" class="bg-white rounded-2xl border border-line shadow-card py-16 text-center">
                <p class="text-4xl mb-4">📰</p>
                <p class="font-display font-semibold text-gray-900 mb-1">No articles found</p>
                <p class="text-gray-500 text-sm">
                    {{ districtFilter || categoryFilter ? 'Try clearing the filters.' : 'No news articles published yet.' }}
                </p>
            </div>

            <template v-else>
                <!-- Hero article (latest, full width) -->
                <Link v-if="heroArticle" :href="route('news.show', heroArticle.slug)"
                    class="group block rounded-2xl overflow-hidden bg-white border border-line shadow-card hover:shadow-lift transition-all mb-8 relative"
                >
                    <div class="relative h-64 sm:h-80 bg-gray-900 overflow-hidden">
                        <img v-if="heroArticle.cover_image"
                            :src="`/storage/${heroArticle.cover_image}`"
                            :alt="heroArticle.title"
                            class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition duration-500"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span v-if="isBreaking(heroArticle.published_at)" class="bg-[#D62839] text-white text-xs font-bold px-2.5 py-1 rounded-full">BREAKING</span>
                                <span v-if="heroArticle.category" class="text-white/70 text-xs font-medium">{{ heroArticle.category.name }}</span>
                                <span v-if="heroArticle.district" class="text-white/50 text-xs">· {{ heroArticle.district.name }}</span>
                            </div>
                            <h2 class="font-display font-bold text-white text-xl sm:text-2xl leading-snug group-hover:text-bay-200 transition-colors">
                                {{ heroArticle.title }}
                            </h2>
                            <p v-if="heroArticle.excerpt" class="text-white/60 text-sm mt-1 line-clamp-2">{{ heroArticle.excerpt }}</p>
                            <p class="text-white/40 text-xs mt-2 font-data">
                                {{ heroArticle.author?.name }} · {{ new Date(heroArticle.published_at).toLocaleDateString() }}
                            </p>
                        </div>
                    </div>
                </Link>

                <!-- Rest: 3-col grid -->
                <div v-if="restArticles.length" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <Link v-for="article in restArticles" :key="article.id"
                        :href="route('news.show', article.slug)"
                        class="group bg-white rounded-xl border border-line shadow-card hover:shadow-lift transition-all overflow-hidden flex flex-col"
                    >
                        <div class="relative h-44 bg-gray-100 overflow-hidden flex-shrink-0">
                            <img v-if="article.cover_image"
                                :src="`/storage/${article.cover_image}`"
                                :alt="article.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center text-4xl bg-gray-100">📰</div>
                            <span v-if="isBreaking(article.published_at)"
                                class="absolute top-3 left-3 bg-[#D62839] text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                BREAKING
                            </span>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <div class="flex items-center gap-1.5 text-xs mb-2">
                                <span v-if="article.category" class="font-medium text-bay-600">{{ article.category.name }}</span>
                                <span v-if="article.district" class="text-gray-400">· {{ article.district.name }}</span>
                            </div>
                            <h3 class="font-display font-semibold text-gray-900 text-base leading-snug line-clamp-2 group-hover:text-bay-700 transition-colors mb-2 flex-1">
                                {{ article.title }}
                            </h3>
                            <p v-if="article.excerpt" class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-3">{{ article.excerpt }}</p>
                            <div class="flex items-center justify-between text-xs text-gray-400 font-data mt-auto pt-3 border-t border-gray-100">
                                <span>{{ article.author?.name }}</span>
                                <span>{{ new Date(article.published_at).toLocaleDateString() }}</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Pagination -->
                <div v-if="articles.last_page > 1" class="flex justify-center gap-1 mt-10">
                    <Link
                        v-for="link in articles.links" :key="link.label"
                        :href="link.url ?? '#'"
                        :class="[
                            'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
                            link.active ? 'bg-bay-600 text-white' : 'text-gray-600 hover:bg-gray-100',
                            !link.url   ? 'opacity-40 pointer-events-none' : '',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </template>
        </div>

        <!-- Footer -->
        <footer class="border-t border-line bg-white py-8 mt-10">
            <div class="mx-auto max-w-6xl px-4 text-center text-xs text-gray-400 font-data">
                Safenix — Real-Time Disaster Monitoring. Built by Nurnahar Nuri &amp; Riazul Islam Mubin, DIIT CSE.
            </div>
        </footer>
    </div>
</template>

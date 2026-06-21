<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    article: Object,
});

function isBreaking(dateStr) {
    return (Date.now() - new Date(dateStr)) < 86400000;
}
</script>

<template>
    <Head :title="`${article.title} — Safenix`" />

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

        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-10">
            <!-- Back link -->
            <Link :href="route('news.index')" class="inline-flex items-center gap-1.5 text-sm text-bay-600 hover:text-bay-700 font-medium mb-8 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to News
            </Link>

            <article>
                <!-- Meta row -->
                <div class="flex items-center gap-2 mb-4 flex-wrap">
                    <span v-if="isBreaking(article.published_at)"
                        class="bg-[#D62839] text-white text-xs font-bold px-2.5 py-1 rounded-full">BREAKING</span>
                    <span v-if="article.category"
                        class="text-xs font-semibold text-bay-600 bg-bay-50 px-2.5 py-1 rounded-full">{{ article.category.name }}</span>
                    <span v-if="article.district" class="text-xs text-gray-500 font-data">· {{ article.district.name }}</span>
                    <span v-if="article.upazila" class="text-xs text-gray-400 font-data">/ {{ article.upazila.name }}</span>
                </div>

                <!-- Title -->
                <h1 class="font-display font-bold text-gray-900 text-3xl sm:text-4xl leading-tight mb-4">
                    {{ article.title }}
                </h1>

                <!-- Excerpt -->
                <p v-if="article.excerpt" class="text-gray-500 text-lg leading-relaxed mb-6 border-l-4 border-bay-500 pl-4">
                    {{ article.excerpt }}
                </p>

                <!-- Byline -->
                <div class="flex items-center gap-3 mb-8 pb-8 border-b border-line">
                    <div class="w-8 h-8 rounded-full bg-bay-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ article.author?.name?.[0]?.toUpperCase() ?? 'S' }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ article.author?.name ?? 'Safenix Editorial' }}</p>
                        <p class="font-data text-xs text-gray-400">
                            {{ new Date(article.published_at).toLocaleDateString('en-BD', { year: 'numeric', month: 'long', day: 'numeric' }) }}
                            <span class="mx-1">·</span>{{ article.views }} views
                        </p>
                    </div>
                </div>

                <!-- Cover image -->
                <div v-if="article.cover_image" class="mb-8 rounded-2xl overflow-hidden">
                    <img :src="`/storage/${article.cover_image}`" :alt="article.title"
                        class="w-full object-cover max-h-96" />
                </div>

                <!-- Body -->
                <div class="prose prose-lg prose-gray max-w-none bn leading-relaxed text-gray-800 whitespace-pre-wrap">
                    {{ article.body }}
                </div>

                <!-- Provenance — if born from a report -->
                <div v-if="article.report_id" class="mt-10 pt-6 border-t border-line">
                    <div class="bg-bay-50 border border-bay-200 rounded-xl px-4 py-3 flex items-start gap-3">
                        <span class="text-bay-600 text-lg mt-0.5">📋</span>
                        <div>
                            <p class="text-bay-800 text-sm font-medium">Based on a verified field report</p>
                            <p class="text-bay-600 text-xs mt-0.5 font-data">
                                Report <span class="font-semibold">#RPT-{{ String(article.report_id).padStart(4, '0') }}</span> — verified by Safenix administrators.
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Footer -->
        <footer class="border-t border-line bg-white py-8 mt-10">
            <div class="mx-auto max-w-6xl px-4 text-center text-xs text-gray-400 font-data">
                Safenix — Real-Time Disaster Monitoring. Built by Nurnahar Nuri &amp; Riazul Islam Mubin, DIIT CSE.
            </div>
        </footer>
    </div>
</template>

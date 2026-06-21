<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import ConfirmModal from '@/Components/UI/ConfirmModal.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    articles:      Object,
    currentStatus: String,
});

const tabs = [
    { value: 'all',       label: 'All' },
    { value: 'published', label: 'Published' },
    { value: 'draft',     label: 'Drafts' },
];

function filterByStatus(status) {
    router.get(route('admin.news.index'), { status: status === 'all' ? undefined : status }, { preserveState: true });
}

const deleteTarget = ref(null);

function confirmDelete(id) {
    deleteTarget.value = id;
}

function doDelete() {
    router.delete(route('admin.news.destroy', deleteTarget.value), {
        onFinish: () => { deleteTarget.value = null; },
    });
}
</script>

<template>
    <Head title="News Management — Safenix Admin" />
    <AdminLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="font-display font-bold text-white text-2xl">News Management</h1>
                    <p class="text-ink-400 text-sm mt-1">Manage published articles and drafts</p>
                </div>
                <Link :href="route('admin.news.create')"
                    class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New article
                </Link>
            </div>

            <!-- Filter tabs -->
            <div class="inline-flex bg-ink-800 rounded-xl p-1 border border-ink-600">
                <button v-for="tab in tabs" :key="tab.value"
                    @click="filterByStatus(tab.value)"
                    :class="[
                        'px-4 py-1.5 rounded-lg text-sm font-medium transition-colors',
                        (currentStatus ?? 'all') === tab.value
                            ? 'bg-bay-600 text-white shadow-sm'
                            : 'text-ink-400 hover:text-white',
                    ]">
                    {{ tab.label }}
                </button>
            </div>

            <!-- Articles list -->
            <div class="bg-ink-800 rounded-xl border border-ink-600 overflow-hidden">
                <!-- Empty state -->
                <div v-if="!articles.data.length" class="py-16 flex flex-col items-center justify-center">
                    <p class="text-3xl mb-3">📰</p>
                    <p class="text-ink-300 font-semibold text-sm">No articles found</p>
                    <p class="text-ink-500 text-xs mt-1">
                        {{ currentStatus === 'draft' ? 'No drafts saved.' : currentStatus === 'published' ? 'No published articles yet.' : 'Write the first article.' }}
                    </p>
                </div>

                <div v-else class="divide-y divide-ink-700">
                    <div v-for="article in articles.data" :key="article.id"
                        class="flex items-start gap-4 px-5 py-4 hover:bg-ink-700/40 transition-colors">

                        <!-- Cover thumbnail -->
                        <div class="w-16 h-14 rounded-lg overflow-hidden bg-ink-900 flex-shrink-0">
                            <img v-if="article.cover_image"
                                :src="`/storage/${article.cover_image}`"
                                :alt="article.title"
                                class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center text-2xl">📰</div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span :class="[
                                    'text-xs font-semibold px-2 py-0.5 rounded-full',
                                    article.status === 'published'
                                        ? 'bg-[#157F6B]/15 text-[#157F6B]'
                                        : 'bg-ink-600 text-ink-400',
                                ]">
                                    {{ article.status === 'published' ? '✓ Published' : '⏸ Draft' }}
                                </span>
                                <span v-if="article.category" class="text-xs text-bay-400 font-medium">{{ article.category.name }}</span>
                                <span v-if="article.district" class="text-xs text-ink-500 font-data">· {{ article.district.name }}</span>
                            </div>
                            <h3 class="font-display font-semibold text-white text-sm leading-snug line-clamp-1">{{ article.title }}</h3>
                            <p v-if="article.excerpt" class="text-ink-400 text-xs mt-0.5 line-clamp-1">{{ article.excerpt }}</p>
                            <div class="flex items-center gap-3 mt-1.5 font-data text-xs text-ink-500">
                                <span>{{ article.author?.name ?? 'Admin' }}</span>
                                <span>·</span>
                                <span>{{ article.views }} views</span>
                                <span v-if="article.published_at">·</span>
                                <TimeAgo v-if="article.published_at" :date="article.published_at" />
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-1 flex-shrink-0">
                            <Link v-if="article.status === 'published'"
                                :href="route('news.show', article.slug)"
                                target="_blank"
                                class="p-2 text-ink-400 hover:text-bay-400 hover:bg-ink-700 rounded-lg transition-colors"
                                title="View public">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </Link>
                            <Link :href="route('admin.news.edit', article.id)"
                                class="p-2 text-ink-400 hover:text-white hover:bg-ink-700 rounded-lg transition-colors"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </Link>
                            <button @click="confirmDelete(article.id)"
                                class="p-2 text-ink-400 hover:text-[#D62839] hover:bg-ink-700 rounded-lg transition-colors"
                                title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="articles.last_page > 1" class="flex justify-center gap-1">
                <Link v-for="link in articles.links" :key="link.label"
                    :href="link.url ?? '#'"
                    :class="[
                        'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors',
                        link.active ? 'bg-bay-600 text-white' : 'text-ink-400 hover:bg-ink-700 hover:text-white',
                        !link.url   ? 'opacity-40 pointer-events-none' : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>

        <ConfirmModal
            :show="!!deleteTarget"
            title="Delete article?"
            description="This will permanently delete the article and cannot be undone."
            confirm-label="Delete article"
            :danger="true"
            @confirm="doDelete"
            @cancel="deleteTarget = null"
        />
    </AdminLayout>
</template>

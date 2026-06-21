<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    districts:  Array,
    reportData: Object,
});

const form = useForm({
    title:          props.reportData?.title ?? '',
    excerpt:        props.reportData?.excerpt ?? '',
    body:           props.reportData?.body ?? '',
    category_id:    props.reportData?.category_id ?? '',
    district_id:    props.reportData?.district_id ?? '',
    report_id:      props.reportData?.report_id ?? '',
    status:         'draft',
    cover_image:    null,
    existing_cover: props.reportData?.cover_image ?? '',
});

function submit() {
    form.post(route('admin.news.store'), { forceFormData: true });
}
</script>

<template>
    <Head :title="reportData ? 'Article from Report — Safenix' : 'Write Article — Safenix'" />
    <AdminLayout>
        <div class="space-y-6 max-w-3xl">
            <!-- Header -->
            <div class="flex items-center gap-3">
                <Link :href="route('admin.news.index')" class="text-ink-400 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-ink-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </Link>
                <div>
                    <h1 class="font-display font-bold text-white text-xl">
                        {{ reportData ? 'Article from report' : 'Write article' }}
                    </h1>
                </div>
            </div>

            <!-- Pre-fill notice -->
            <div v-if="reportData" class="bg-bay-600/10 border border-bay-500/30 rounded-xl px-4 py-3">
                <p class="text-bay-300 text-sm">Pre-filled from verified report <span class="font-data">#RPT-{{ String(reportData.report_id).padStart(4, '0') }}</span>. Review and publish.</p>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- Title -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 p-5">
                    <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">Title <span class="text-[#D62839]">*</span></label>
                    <input v-model="form.title" type="text"
                        class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-base px-4 py-3 placeholder-ink-500 focus:border-bay-500 focus:ring-0 font-display"
                        placeholder="Article headline…" />
                    <p v-if="form.errors.title" class="mt-1.5 text-xs text-[#D62839]">{{ form.errors.title }}</p>
                </div>

                <!-- Meta row -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 p-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">Category</label>
                        <select v-model="form.category_id"
                            class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 focus:border-bay-500 focus:ring-0">
                            <option value="">None</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">District</label>
                        <select v-model="form.district_id"
                            class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 focus:border-bay-500 focus:ring-0">
                            <option value="">None</option>
                            <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
                        </select>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 p-5">
                    <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">Excerpt</label>
                    <textarea v-model="form.excerpt" rows="2"
                        class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 placeholder-ink-500 focus:border-bay-500 focus:ring-0 resize-none"
                        placeholder="Short summary shown on the news index…"></textarea>
                </div>

                <!-- Body -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 p-5">
                    <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">Body <span class="text-[#D62839]">*</span></label>
                    <textarea v-model="form.body" rows="14"
                        class="w-full bg-ink-900 border border-ink-600 rounded-lg text-white text-sm px-3 py-2 placeholder-ink-500 focus:border-bay-500 focus:ring-0 resize-y"
                        placeholder="Full article content…"></textarea>
                    <p v-if="form.errors.body" class="mt-1.5 text-xs text-[#D62839]">{{ form.errors.body }}</p>
                </div>

                <!-- Cover image -->
                <div class="bg-ink-800 rounded-xl border border-ink-600 p-5">
                    <label class="block text-ink-300 text-xs font-medium uppercase tracking-wider mb-2">Cover image</label>
                    <input type="file" accept="image/*" @change="form.cover_image = $event.target.files[0]"
                        class="w-full text-sm text-ink-400 file:mr-4 file:rounded-lg file:border-0 file:bg-bay-600 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-bay-700 cursor-pointer" />
                    <p v-if="form.existing_cover" class="mt-1.5 text-xs text-ink-500">Image pre-filled from report. Upload a new one to replace.</p>
                </div>

                <!-- Status + submit -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="form.status" value="draft"
                                class="text-bay-600 focus:ring-bay-500 bg-ink-900 border-ink-600" />
                            <span class="text-ink-300 text-sm">Save as draft</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" v-model="form.status" value="published"
                                class="text-bay-600 focus:ring-bay-500 bg-ink-900 border-ink-600" />
                            <span class="text-ink-300 text-sm">Publish now</span>
                        </label>
                    </div>
                    <button type="submit" :disabled="form.processing"
                        class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors text-sm">
                        {{ form.processing ? 'Saving…' : (form.status === 'published' ? 'Publish article' : 'Save draft') }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

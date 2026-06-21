<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    // Will receive articles from controller in Phase 4
});
</script>

<template>
    <Head title="Disaster News" />

    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">Safenix</Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('news.index')" class="text-sm font-medium text-indigo-600">News</Link>
                        <Link v-if="$page.props.auth?.user" :href="route('dashboard')"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                            <Link :href="route('register')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Disaster News</h1>
            <p class="mt-2 text-gray-600">Latest updates on disasters across Bangladesh.</p>

            <div class="mt-8 rounded-lg bg-white p-12 text-center shadow-sm ring-1 ring-gray-200">
                <p class="text-gray-500">No news articles published yet. Check back soon.</p>
            </div>
        </div>
    </div>
</template>

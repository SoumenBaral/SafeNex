<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Safenix - Real-Time Disaster Monitoring" />

    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-indigo-600">Safenix</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-sm text-gray-600 hover:text-gray-900">Live Map</Link>
                        <Link :href="route('news.index')" class="text-sm text-gray-600 hover:text-gray-900">News</Link>
                        <template v-if="canLogin">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                    Register
                                </Link>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <div class="relative overflow-hidden bg-indigo-700">
            <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
                <div class="max-w-2xl">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                        Real-Time Disaster Monitoring & Reporting
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-indigo-100">
                        Report disasters in your area, track verified incidents on a live map, and receive emergency alerts instantly. Together, we build a safer Bangladesh.
                    </p>
                    <div class="mt-10 flex items-center gap-4">
                        <Link v-if="!$page.props.auth.user" :href="route('register')"
                            class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50">
                            Get Started
                        </Link>
                        <Link v-else :href="route('reports.create')"
                            class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50">
                            Submit a Report
                        </Link>
                        <Link :href="route('news.index')" class="text-sm font-semibold text-white hover:text-indigo-100">
                            View News &rarr;
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 text-2xl">
                        <span>&#x1F4CB;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Submit Reports</h3>
                    <p class="mt-2 text-sm text-gray-600">Report disasters with details, location, and media. Admin verification ensures accuracy before public visibility.</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-2xl">
                        <span>&#x1F5FA;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Live Map</h3>
                    <p class="mt-2 text-sm text-gray-600">View verified incidents on an interactive map with color-coded markers by disaster type and severity.</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-red-100 text-2xl">
                        <span>&#x1F514;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Emergency Alerts</h3>
                    <p class="mt-2 text-sm text-gray-600">Receive real-time notifications for verified disasters in your district via push notifications and in-app alerts.</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100 text-2xl">
                        <span>&#x1F6E1;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Admin Verification</h3>
                    <p class="mt-2 text-sm text-gray-600">Every report is reviewed by admin before going public. No fake news, no misinformation.</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 text-2xl">
                        <span>&#x1F691;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Rescue Teams</h3>
                    <p class="mt-2 text-sm text-gray-600">Admin assigns rescue teams to verified incidents and notifies team members via email automatically.</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-2xl">
                        <span>&#x1F4F0;</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Disaster News</h3>
                    <p class="mt-2 text-sm text-gray-600">Stay informed with news articles created from verified reports, filterable by district and category.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white py-8">
            <div class="mx-auto max-w-7xl px-6 text-center text-sm text-gray-500">
                Safenix &mdash; Real-Time Disaster Monitoring & Reporting Platform. Built by Nurnahar Nuri & Riazul Islam Mubin, DIIT CSE.
            </div>
        </footer>
    </div>
</template>

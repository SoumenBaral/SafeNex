<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin:    Boolean,
    canRegister: Boolean,
    stats:       Object, // { total_reports, verified_reports, districts }
    latestReports: Array,
    latestNews:    Array,
});
</script>

<template>
    <Head title="Safenix — Real-Time Disaster Monitoring" />

    <div class="min-h-screen bg-paper font-sans">
        <!-- Sticky Navbar -->
        <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-line shadow-sm">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-bay-600 flex items-center justify-center text-white font-bold font-display text-sm">S</div>
                        <span class="font-display font-bold text-gray-900 text-lg tracking-tight">Safenix</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <Link :href="route('map')" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                            Live Map
                        </Link>
                        <Link :href="route('news.index')" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                            News
                        </Link>
                        <template v-if="canLogin">
                            <Link v-if="$page.props.auth.user"
                                :href="$page.props.auth.roles?.includes('admin') ? route('admin.dashboard') : $page.props.auth.roles?.includes('responder') ? route('responder.dashboard') : route('dashboard')"
                                class="px-4 py-2 text-sm font-medium bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors">
                                Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                                    Sign in
                                </Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="px-4 py-2 text-sm font-medium bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors">
                                    Get started
                                </Link>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <section class="relative bg-gray-900 overflow-hidden">
            <!-- Subtle grid pattern -->
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: repeating-linear-gradient(0deg,#fff 0,#fff 1px,transparent 1px,transparent 40px), repeating-linear-gradient(90deg,#fff 0,#fff 1px,transparent 1px,transparent 40px);"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left: copy -->
                    <div>
                        <!-- Live ticker -->
                        <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 mb-8">
                            <span class="w-1.5 h-1.5 rounded-full bg-bay-400 animate-pulse"></span>
                            <span class="font-data text-xs text-white/70">Live monitoring across Bangladesh</span>
                        </div>

                        <h1 class="font-display font-bold text-white leading-tight mb-6" style="font-size: clamp(2rem, 1.5rem + 2.4vw, 3.25rem);">
                            Report disasters.<br>
                            <span class="text-bay-400">Help your district respond.</span>
                        </h1>
                        <p class="text-white/70 text-lg leading-relaxed mb-8 max-w-lg">
                            Submit verified incident reports, track disasters on a live map, and receive emergency alerts the moment they're confirmed.
                        </p>
                        <div class="flex flex-wrap items-center gap-3">
                            <Link v-if="!$page.props.auth.user" :href="route('register')"
                                class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 text-white font-medium px-6 py-3 rounded-xl transition-colors text-sm">
                                Report an incident
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                            <Link v-else :href="route('reports.create')"
                                class="inline-flex items-center gap-2 bg-bay-600 hover:bg-bay-700 text-white font-medium px-6 py-3 rounded-xl transition-colors text-sm">
                                Report an incident
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                            <Link :href="route('map')"
                                class="inline-flex items-center gap-2 border border-white/20 text-white hover:bg-white/5 font-medium px-6 py-3 rounded-xl transition-colors text-sm">
                                View live map
                            </Link>
                        </div>
                    </div>

                    <!-- Right: live stat cards -->
                    <div class="hidden lg:grid grid-cols-2 gap-4">
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5">
                            <p class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-2">Total Reports</p>
                            <p class="font-data text-3xl font-semibold text-white">{{ stats?.total_reports ?? '—' }}</p>
                            <p class="text-gray-400 text-xs mt-1 font-data">across all districts</p>
                        </div>
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5">
                            <p class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-2">Verified</p>
                            <p class="font-data text-3xl font-semibold text-[#2E9E6B]">{{ stats?.verified_reports ?? '—' }}</p>
                            <p class="text-gray-400 text-xs mt-1 font-data">publicly visible</p>
                        </div>
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5">
                            <p class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-2">Districts</p>
                            <p class="font-data text-3xl font-semibold text-bay-400">64</p>
                            <p class="text-gray-400 text-xs mt-1 font-data">covered nationwide</p>
                        </div>
                        <div class="bg-white/10 border border-white/20 rounded-xl p-5">
                            <p class="text-gray-400 text-xs font-medium uppercase tracking-wider mb-2">Status</p>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="w-2 h-2 rounded-full bg-[#2E9E6B] animate-pulse"></span>
                                <span class="text-[#2E9E6B] font-data text-sm">System live</span>
                            </div>
                            <p class="text-gray-400 text-xs mt-1 font-data">Real-time updates</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave divider -->
            <div class="absolute bottom-0 left-0 right-0 h-12 bg-paper" style="clip-path: ellipse(60% 100% at 50% 100%);"></div>
        </section>

        <!-- Stats bar -->
        <section class="bg-gray-900 py-5">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div>
                        <p class="font-data text-2xl font-semibold text-white">{{ stats?.total_reports ?? 0 }}</p>
                        <p class="text-gray-400 text-xs mt-1">Reports submitted</p>
                    </div>
                    <div>
                        <p class="font-data text-2xl font-semibold text-[#2E9E6B]">{{ stats?.verified_reports ?? 0 }}</p>
                        <p class="text-gray-400 text-xs mt-1">Verified incidents</p>
                    </div>
                    <div>
                        <p class="font-data text-2xl font-semibold text-bay-400">64</p>
                        <p class="text-gray-400 text-xs mt-1">Districts covered</p>
                    </div>
                    <div>
                        <p class="font-data text-2xl font-semibold text-white">24/7</p>
                        <p class="text-gray-400 text-xs mt-1">Live monitoring</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="py-20 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-center font-display font-bold text-gray-900 text-2xl mb-12">How it works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div v-for="(step, i) in [
                    { n: '01', title: 'Submit a report', desc: 'Report an incident with location, photos, and details. Takes under a minute from your phone.', icon: '📋' },
                    { n: '02', title: 'Admin verifies', desc: 'Our admins review every submission before it goes public — no misinformation, no spam.', icon: '✓' },
                    { n: '03', title: 'Appears on the map', desc: 'Verified incidents appear instantly on the live map and alert nearby users in your district.', icon: '🗺' },
                ]" :key="i" class="relative text-center">
                    <div class="w-14 h-14 rounded-2xl bg-bay-50 border-2 border-bay-100 flex items-center justify-center text-2xl mx-auto mb-4">{{ step.icon }}</div>
                    <p class="font-data text-xs text-bay-600 font-medium mb-1">Step {{ step.n }}</p>
                    <h3 class="font-display font-bold text-gray-900 text-lg mb-2">{{ step.title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ step.desc }}</p>
                    <!-- Connector -->
                    <div v-if="i < 2" class="hidden md:block absolute top-7 left-full w-full h-0.5 bg-gradient-to-r from-bay-200 to-transparent -translate-x-8 z-0"></div>
                </div>
            </div>
        </section>

        <!-- Feature cards -->
        <section class="py-16 bg-white">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <h2 class="font-display font-bold text-gray-900 text-2xl mb-10 text-center">Platform features</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="feat in [
                        { icon: '📋', color: 'bg-bay-50 border-bay-100', title: 'Report Submission', desc: 'Submit reports with exact GPS location, photos, and video from any device.' },
                        { icon: '🗺', color: 'bg-green-50 border-green-100', title: 'Live Incident Map', desc: 'Interactive map with clustered markers, color-coded by disaster type and severity.' },
                        { icon: '🔔', color: 'bg-red-50 border-red-100', title: 'Emergency Alerts', desc: 'Instant push notifications for verified disasters in your district.' },
                        { icon: '✓',  color: 'bg-yellow-50 border-yellow-100', title: 'Admin Verification', desc: 'Every report reviewed before going public. No fake news, no misinformation.' },
                        { icon: '🚑', color: 'bg-orange-50 border-orange-100', title: 'Rescue Teams', desc: 'Admin dispatches rescue teams to incidents with automated email alerts to members.' },
                        { icon: '📰', color: 'bg-purple-50 border-purple-100', title: 'Disaster News', desc: 'News articles created from verified reports, filterable by district and category.' },
                    ]" :key="feat.title"
                        class="rounded-xl border bg-white p-5 hover:shadow-card transition-all">
                        <div :class="['w-11 h-11 rounded-xl border flex items-center justify-center text-xl mb-4', feat.color]">{{ feat.icon }}</div>
                        <h3 class="font-display font-semibold text-gray-900 text-base mb-1.5">{{ feat.title }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ feat.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest verified incidents (if any) -->
        <section v-if="latestReports?.length" class="py-16 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-display font-bold text-gray-900 text-xl">Latest verified incidents</h2>
                <Link :href="route('map')" class="text-sm text-bay-600 hover:text-bay-700 font-medium">View map →</Link>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div v-for="report in latestReports" :key="report.id"
                    class="bg-white rounded-xl border border-line shadow-card p-4 hover:shadow-lift transition-all">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="font-medium text-gray-900 text-sm line-clamp-1">{{ report.title }}</span>
                        <span :class="[
                            'inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full flex-shrink-0',
                            report.severity === 'critical' ? 'bg-[#D62839]/10 text-[#D62839]' :
                            report.severity === 'high'     ? 'bg-[#E5611F]/10 text-[#E5611F]' :
                            report.severity === 'medium'   ? 'bg-[#E0A100]/10 text-[#E0A100]' :
                                                             'bg-[#2E9E6B]/10 text-[#2E9E6B]',
                        ]">{{ report.severity }}</span>
                    </div>
                    <p class="text-gray-500 text-xs font-data">{{ report.district?.name }} · {{ report.category?.name }}</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-20 bg-bay-600">
            <div class="mx-auto max-w-2xl px-4 text-center">
                <h2 class="font-display font-bold text-white text-2xl mb-4">Ready to report an incident?</h2>
                <p class="text-bay-100 mb-8">Join thousands of citizens helping Bangladesh respond faster to disasters.</p>
                <Link v-if="!$page.props.auth.user" :href="route('register')"
                    class="inline-flex items-center gap-2 bg-white text-bay-700 font-semibold px-8 py-3 rounded-xl hover:bg-bay-50 transition-colors">
                    Create free account
                </Link>
                <Link v-else :href="route('reports.create')"
                    class="inline-flex items-center gap-2 bg-white text-bay-700 font-semibold px-8 py-3 rounded-xl hover:bg-bay-50 transition-colors">
                    Submit a report now
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-10">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-md bg-bay-600 flex items-center justify-center text-white text-xs font-bold font-display">S</div>
                        <span class="text-white font-display font-bold text-sm">Safenix</span>
                    </div>
                    <p class="text-white/60 text-xs font-data text-center">
                        Built by Nurnahar Nuri (210147) &amp; Riazul Islam Mubin (210161) · DIIT CSE
                    </p>
                    <div class="flex items-center gap-4">
                        <Link :href="route('map')" class="text-white/60 hover:text-white text-xs transition-colors">Live Map</Link>
                        <Link :href="route('news.index')" class="text-white/60 hover:text-white text-xs transition-colors">News</Link>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

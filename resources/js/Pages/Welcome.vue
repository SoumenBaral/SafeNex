<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin:    Boolean,
    canRegister: Boolean,
    stats:       Object,
    latestReports: Array,
    latestNews:    Array,
});

const heroVisible = ref(false);
const statsVisible = ref(false);
const stepsVisible = ref(false);
const featuresVisible = ref(false);
const ctaVisible = ref(false);
const footerVisible = ref(false);
const mouseX = ref(0);
const mouseY = ref(0);

function handleMouse(e) {
    const rect = e.currentTarget.getBoundingClientRect();
    mouseX.value = ((e.clientX - rect.left) / rect.width - 0.5) * 20;
    mouseY.value = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
}

onMounted(() => {
    setTimeout(() => heroVisible.value = true, 150);
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.dataset.animate;
                if (id === 'stats') statsVisible.value = true;
                if (id === 'steps') stepsVisible.value = true;
                if (id === 'features') featuresVisible.value = true;
                if (id === 'cta') ctaVisible.value = true;
                if (id === 'footer') footerVisible.value = true;
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
});
</script>

<template>
    <Head title="Safenix — Real-Time Disaster Monitoring" />

    <div class="min-h-screen bg-paper font-sans">
        <!-- Navbar -->
        <nav class="sticky top-0 z-40 bg-white/90 backdrop-blur-lg border-b border-gray-100 shadow-sm">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-bay-500 to-bay-700 flex items-center justify-center text-white font-bold font-display text-sm shadow-sm">S</div>
                        <span class="font-display font-bold text-gray-900 text-lg tracking-tight">Safenix</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <Link :href="route('map')" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 rounded-lg transition-colors">Live Map</Link>
                        <Link :href="route('news.index')" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 rounded-lg transition-colors">News</Link>
                        <template v-if="canLogin">
                            <Link v-if="$page.props.auth.user"
                                :href="$page.props.auth.roles?.includes('admin') ? route('admin.dashboard') : $page.props.auth.roles?.includes('responder') ? route('responder.dashboard') : route('dashboard')"
                                class="ml-2 px-4 py-2 text-sm font-semibold bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors shadow-sm">Dashboard</Link>
                            <template v-else>
                                <Link :href="route('login')" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 rounded-lg transition-colors">Sign in</Link>
                                <Link v-if="canRegister" :href="route('register')" class="ml-1 px-4 py-2 text-sm font-semibold bg-bay-600 hover:bg-bay-700 text-white rounded-lg transition-colors shadow-sm">Get started</Link>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ═══ HERO ═══ -->
        <section class="relative overflow-hidden" @mousemove="handleMouse">
            <!-- Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#0B1120] via-[#0F172A] to-[#0B1120]"></div>

            <!-- Soft aurora glow — just 2 layers, slow & elegant -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-[20%] -left-[10%] w-[60%] h-[70%] rounded-full bg-bay-500/[0.08] blur-[120px] hero-glow-1"></div>
                <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[60%] rounded-full bg-bay-600/[0.06] blur-[100px] hero-glow-2"></div>
            </div>

            <!-- Parallax grid -->
            <div class="absolute inset-0 hero-grid" :style="{ transform: `translate(${mouseX * 0.3}px, ${mouseY * 0.3}px)` }"></div>

            <!-- Bottom glow line -->
            <div class="absolute bottom-0 left-0 right-0 h-px hero-bottom-glow"></div>

            <!-- Content -->
            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-14 items-center">
                    <!-- Left -->
                    <div>
                        <!-- Badge -->
                        <div :class="['inline-flex items-center gap-2.5 bg-white/[0.04] border border-white/[0.08] backdrop-blur-md rounded-full px-4 py-2 mb-8 transition-all duration-700', heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3']">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-50"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                            </span>
                            <span class="text-[11px] text-white/70 tracking-wide uppercase font-medium font-data">Live monitoring · Bangladesh</span>
                        </div>

                        <!-- Heading -->
                        <h1 :class="['font-display font-extrabold text-white leading-[1.08] mb-6 transition-all duration-800 delay-200', heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8']"
                            style="font-size: clamp(2.25rem, 1.5rem + 3vw, 3.75rem); letter-spacing: -0.025em;">
                            Report disasters.<br>
                            <span class="hero-text-shine">Help your district respond.</span>
                        </h1>

                        <!-- Subtitle -->
                        <p :class="['text-white/45 text-[17px] leading-relaxed mb-10 max-w-lg transition-all duration-800 delay-300', heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6']">
                            Submit verified incident reports, track disasters on a live map, and receive alerts the moment they're confirmed.
                        </p>

                        <!-- Buttons -->
                        <div :class="['flex flex-wrap items-center gap-3.5 transition-all duration-800 delay-[400ms]', heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6']">
                            <Link v-if="!$page.props.auth.user" :href="route('register')" class="hero-btn group">
                                Report an incident
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </Link>
                            <Link v-else :href="route('reports.create')" class="hero-btn group">
                                Report an incident
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </Link>
                            <Link :href="route('map')" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-medium text-white/70 border border-white/10 rounded-xl hover:bg-white/[0.04] hover:text-white hover:border-white/20 transition-all">
                                View live map
                            </Link>
                        </div>

                        <!-- Trust -->
                        <div :class="['flex items-center gap-5 mt-10 pt-7 border-t border-white/[0.05] transition-all duration-800 delay-[550ms]', heroVisible ? 'opacity-100' : 'opacity-0']">
                            <div class="flex -space-x-1.5">
                                <div v-for="(c,j) in ['bg-bay-500','bg-emerald-500','bg-amber-500','bg-bay-700']" :key="j"
                                    :class="['w-6 h-6 rounded-full border-2 border-[#0F172A] text-white text-[8px] font-bold flex items-center justify-center', c]">
                                    {{ ['N','R','M','D'][j] }}
                                </div>
                            </div>
                            <span class="text-white/25 text-xs font-data">Active responders</span>
                            <span class="text-white/10">|</span>
                            <span class="text-white/25 text-xs font-data">64 districts covered</span>
                        </div>
                    </div>

                    <!-- Right: stat cards -->
                    <div :class="['hidden lg:grid grid-cols-2 gap-3.5 transition-all duration-800 delay-500', heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
                        <div v-for="(card, idx) in [
                            { label: 'Total Reports', stat: stats?.total_reports ?? '—', sub: 'across all districts', color: 'text-white' },
                            { label: 'Verified', stat: stats?.verified_reports ?? '—', sub: 'publicly visible', color: 'text-emerald-400' },
                            { label: 'Districts', stat: '64', sub: 'covered nationwide', color: 'text-bay-400' },
                            { label: 'Status', stat: null, sub: 'Real-time updates', color: 'text-emerald-400' },
                        ]" :key="idx" class="hero-card group">
                            <p class="text-white/30 text-[10px] font-semibold uppercase tracking-[0.12em] mb-2.5">{{ card.label }}</p>
                            <template v-if="card.stat">
                                <p :class="['font-data text-3xl font-bold leading-none', card.color]">{{ card.stat }}</p>
                            </template>
                            <template v-else>
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-50"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                                    </span>
                                    <span class="text-emerald-400 font-data text-sm font-bold">ONLINE</span>
                                </div>
                            </template>
                            <p class="text-white/20 text-[11px] mt-2 font-data">{{ card.sub }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 60" class="w-full h-auto block" preserveAspectRatio="none">
                    <path class="fill-paper" d="M0 60V35C360 10 720 0 1080 20C1260 30 1380 40 1440 35V60H0Z"/>
                </svg>
            </div>
        </section>

        <!-- Stats -->
        <section class="bg-[#0F172A] py-5" data-animate="stats">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                    <div v-for="(s, i) in [
                        { val: stats?.total_reports ?? 0, label: 'Reports submitted', color: 'text-white' },
                        { val: stats?.verified_reports ?? 0, label: 'Verified incidents', color: 'text-emerald-400' },
                        { val: '64', label: 'Districts covered', color: 'text-bay-400' },
                        { val: '24/7', label: 'Live monitoring', color: 'text-white' },
                    ]" :key="i"
                        :class="['transition-all duration-500', statsVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3']"
                        :style="{ transitionDelay: (i * 80) + 'ms' }">
                        <p :class="['font-data text-2xl font-bold', s.color]">{{ s.val }}</p>
                        <p class="text-white/30 text-xs mt-1">{{ s.label }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="py-20 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8" data-animate="steps">
            <h2 :class="['text-center font-display font-bold text-gray-900 text-2xl mb-12 transition-all duration-500', stepsVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4']">How it works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div v-for="(step, i) in [
                    { n: '01', title: 'Submit a report', desc: 'Report an incident with location, photos, and details from your phone.', icon: '📋' },
                    { n: '02', title: 'Admin verifies', desc: 'Admins review every submission before it goes public — no misinformation.', icon: '✓' },
                    { n: '03', title: 'Appears on map', desc: 'Verified incidents appear on the live map and alert nearby users.', icon: '🗺' },
                ]" :key="i"
                    :class="['relative text-center transition-all duration-500', stepsVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5']"
                    :style="{ transitionDelay: (150 + i * 120) + 'ms' }">
                    <div class="w-14 h-14 rounded-2xl bg-bay-50 border-2 border-bay-100 flex items-center justify-center text-2xl mx-auto mb-4">{{ step.icon }}</div>
                    <p class="font-data text-xs text-bay-600 font-medium mb-1">Step {{ step.n }}</p>
                    <h3 class="font-display font-bold text-gray-900 text-lg mb-2">{{ step.title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ step.desc }}</p>
                    <div v-if="i < 2" class="hidden md:block absolute top-7 left-full w-full h-0.5 bg-gradient-to-r from-bay-200 to-transparent -translate-x-8 z-0"></div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-16 bg-gray-50/80" data-animate="features">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <h2 :class="['font-display font-bold text-gray-900 text-2xl mb-10 text-center transition-all duration-500', featuresVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4']">Platform features</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div v-for="(feat, i) in [
                        { icon: '📋', color: 'bg-bay-50 border-bay-100', title: 'Report Submission', desc: 'Submit reports with GPS location, photos, and video from any device.' },
                        { icon: '🗺', color: 'bg-emerald-50 border-emerald-100', title: 'Live Incident Map', desc: 'Interactive map with clustered markers, color-coded by type and severity.' },
                        { icon: '🔔', color: 'bg-rose-50 border-rose-100', title: 'Emergency Alerts', desc: 'Instant notifications for verified disasters in your district.' },
                        { icon: '✓',  color: 'bg-amber-50 border-amber-100', title: 'Admin Verification', desc: 'Every report reviewed before going public. No misinformation.' },
                        { icon: '🚑', color: 'bg-orange-50 border-orange-100', title: 'Rescue Teams', desc: 'Dispatch rescue teams with automated email alerts to all members.' },
                        { icon: '📰', color: 'bg-violet-50 border-violet-100', title: 'Disaster News', desc: 'News articles from verified reports, filterable by district.' },
                    ]" :key="feat.title"
                        :class="['rounded-xl border border-gray-200 bg-white p-5 transition-all duration-400 hover:shadow-md hover:-translate-y-0.5 hover:border-gray-300 group', featuresVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6']"
                        :style="{ transitionDelay: (i * 60) + 'ms' }">
                        <div :class="['w-10 h-10 rounded-lg border flex items-center justify-center text-lg mb-3', feat.color]">{{ feat.icon }}</div>
                        <h3 class="font-display font-semibold text-gray-900 text-[15px] mb-1">{{ feat.title }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ feat.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest incidents -->
        <section v-if="latestReports?.length" class="py-16 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-display font-bold text-gray-900 text-xl">Latest verified incidents</h2>
                <Link :href="route('map')" class="text-sm text-bay-600 hover:text-bay-700 font-medium">View map →</Link>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="report in latestReports" :key="report.id" class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="font-medium text-gray-900 text-sm line-clamp-1">{{ report.title }}</span>
                        <span :class="['text-[10px] font-semibold px-2 py-0.5 rounded-full flex-shrink-0',
                            report.severity === 'critical' ? 'bg-rose-50 text-rose-600' :
                            report.severity === 'high' ? 'bg-orange-50 text-orange-600' :
                            report.severity === 'medium' ? 'bg-amber-50 text-amber-600' : 'bg-emerald-50 text-emerald-600']">{{ report.severity }}</span>
                    </div>
                    <p class="text-gray-400 text-xs font-data">{{ report.district?.name }} · {{ report.category?.name }}</p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-20 relative overflow-hidden" data-animate="cta">
            <div class="absolute inset-0 bg-gradient-to-br from-bay-600 via-bay-600 to-bay-700"></div>
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-20 -right-20 w-[300px] h-[300px] rounded-full bg-white/[0.04] blur-[80px]"></div>
                <div class="absolute -bottom-20 -left-20 w-[250px] h-[250px] rounded-full bg-bay-500/20 blur-[80px]"></div>
            </div>
            <div :class="['relative mx-auto max-w-2xl px-4 text-center transition-all duration-600', ctaVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6']">
                <h2 class="font-display font-bold text-white text-2xl mb-3">Ready to report an incident?</h2>
                <p class="text-bay-100/80 mb-8 text-[15px]">Join citizens helping Bangladesh respond faster to disasters.</p>
                <Link v-if="!$page.props.auth.user" :href="route('register')" class="group inline-flex items-center gap-2 bg-white text-bay-700 font-semibold px-7 py-3 rounded-xl hover:bg-bay-50 transition-all hover:shadow-lg hover:-translate-y-0.5 text-sm">
                    Create free account <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </Link>
                <Link v-else :href="route('reports.create')" class="group inline-flex items-center gap-2 bg-white text-bay-700 font-semibold px-7 py-3 rounded-xl hover:bg-bay-50 transition-all hover:shadow-lg hover:-translate-y-0.5 text-sm">
                    Submit a report now <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#0B1120] relative" data-animate="footer">
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-bay-500/30 to-transparent"></div>
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div :class="['py-12 border-b border-white/[0.05] transition-all duration-600', footerVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4']">
                    <div class="grid sm:grid-cols-3 gap-10">
                        <div>
                            <div class="flex items-center gap-2.5 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-bay-500 to-bay-700 flex items-center justify-center text-white text-xs font-bold font-display">S</div>
                                <div>
                                    <span class="text-white font-display font-bold text-sm block leading-none">Safenix</span>
                                    <span class="text-white/25 text-[10px] font-data tracking-wider uppercase">Disaster Monitoring</span>
                                </div>
                            </div>
                            <p class="text-white/30 text-sm leading-relaxed">Real-time disaster reporting platform for Bangladesh.</p>
                        </div>
                        <div :class="['transition-all duration-600 delay-100', footerVisible ? 'opacity-100' : 'opacity-0']">
                            <h4 class="text-white/40 text-[10px] font-bold uppercase tracking-[0.15em] mb-4">Platform</h4>
                            <div class="space-y-2">
                                <Link :href="route('map')" class="block text-white/35 text-sm hover:text-white/80 transition-colors">Live Map</Link>
                                <Link :href="route('news.index')" class="block text-white/35 text-sm hover:text-white/80 transition-colors">News</Link>
                            </div>
                        </div>
                        <div :class="['transition-all duration-600 delay-200', footerVisible ? 'opacity-100' : 'opacity-0']">
                            <h4 class="text-white/40 text-[10px] font-bold uppercase tracking-[0.15em] mb-4">System</h4>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="relative flex h-1.5 w-1.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-50"></span><span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-400"></span></span>
                                <span class="text-emerald-400/80 text-xs font-data">All systems operational</span>
                            </div>
                            <p class="text-white/25 text-xs font-data">64 districts · 494 upazilas</p>
                        </div>
                    </div>
                </div>
                <div :class="['py-5 flex flex-col sm:flex-row items-center justify-between gap-3 transition-all duration-600 delay-300', footerVisible ? 'opacity-100' : 'opacity-0']">
                    <p class="text-white/20 text-xs font-data">&copy; {{ new Date().getFullYear() }} Safenix · Nurnahar Nuri (210147) &amp; Riazul Islam Mubin (210161) · DIIT CSE</p>
                    <div class="text-white/15 text-[10px] font-data">Laravel · Vue · Inertia · Tailwind</div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
/* Soft aurora glows */
.hero-glow-1 { animation: glow1 16s ease-in-out infinite; }
.hero-glow-2 { animation: glow2 20s ease-in-out infinite; }
@keyframes glow1 { 0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(15px,-10px) scale(1.05)} }
@keyframes glow2 { 0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(-20px,12px) scale(1.08)} }

/* Grid */
.hero-grid {
    background-image: linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
    background-size: 64px 64px; transition: transform .2s ease-out;
}

/* Bottom glow */
.hero-bottom-glow {
    background: linear-gradient(90deg,transparent,rgba(16,154,166,.2) 30%,rgba(16,154,166,.35) 50%,rgba(16,154,166,.2) 70%,transparent);
}

/* Gradient text — single smooth shimmer */
.hero-text-shine {
    background: linear-gradient(90deg, #5EEAD4, #38BDF8, #5EEAD4, #109AA6);
    background-size: 300% 100%;
    -webkit-background-clip: text; background-clip: text; color: transparent;
    animation: textShine 8s ease-in-out infinite;
}
@keyframes textShine { 0%,100%{background-position:0% 50%}50%{background-position:100% 50%} }

/* Primary button */
.hero-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .75rem 1.5rem; font-size: .875rem; font-weight: 600; color: white;
    background: linear-gradient(135deg,#0b7f8a,#109AA6);
    border-radius: .75rem; transition: all .3s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 1px 2px rgba(0,0,0,.2), 0 4px 12px rgba(16,154,166,.2);
}
.hero-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(16,154,166,.35); }

/* Stat cards */
.hero-card {
    padding: 1.25rem; border-radius: .875rem;
    border: 1px solid rgba(255,255,255,.06);
    background: rgba(255,255,255,.03);
    backdrop-filter: blur(12px);
    transition: all .3s;
}
.hero-card:hover { border-color: rgba(255,255,255,.1); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,.25); }
</style>

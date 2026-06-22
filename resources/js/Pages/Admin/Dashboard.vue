<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StatCard from '@/Components/UI/StatCard.vue';
import SeverityBadge from '@/Components/UI/SeverityBadge.vue';
import TimeAgo from '@/Components/UI/TimeAgo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    recentReports: Array,
});
</script>

<template>
    <Head title="Admin Dashboard — Safenix" />
    <AdminLayout>
        <div class="space-y-8">
            <!-- Page title -->
            <div>
                <h1 class="font-display font-bold text-gray-900 text-2xl">Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">Overview of the platform status</p>
            </div>

            <!-- Stat cards -->
            <div class="grid grid-cols-2 xl:grid-cols-3 gap-4">
                <StatCard
                    label="Pending Reports"
                    :value="stats?.pending_reports ?? 0"
                    icon="⚠"
                    icon-bg="bg-[#B7791F]/15"
                    trend="Awaiting review"
                    :trend-up="false"
                    :href="route('admin.reports.index', { status: 'pending' })"
                />
                <StatCard
                    label="Verified Reports"
                    :value="stats?.verified_reports ?? 0"
                    icon="✓"
                    icon-bg="bg-[#157F6B]/15"
                    :trend="`${stats?.verified_today ?? 0} verified today`"
                    :trend-up="true"
                    :href="route('admin.reports.index', { status: 'verified' })"
                />
                <StatCard
                    label="Total Reports"
                    :value="stats?.total_reports ?? 0"
                    icon="📋"
                    icon-bg="bg-bay-50"
                />
                <StatCard
                    label="Registered Users"
                    :value="stats?.total_users ?? 0"
                    icon="👥"
                    icon-bg="bg-bay-600/20"
                />
                <StatCard
                    label="Rescue Teams"
                    :value="stats?.total_teams ?? 0"
                    icon="🚑"
                    icon-bg="bg-[#E5611F]/15"
                    :href="route('admin.teams.index')"
                />
                <StatCard
                    label="Published News"
                    :value="stats?.published_news ?? 0"
                    icon="📰"
                    icon-bg="bg-purple-500/15"
                    :href="route('admin.news.index')"
                />
            </div>

            <!-- Quick actions -->
            <div>
                <h2 class="font-display font-semibold text-gray-900 text-sm uppercase tracking-wider mb-4">Quick actions</h2>
                <div class="flex flex-wrap gap-3">
                    <Link :href="route('admin.reports.index', { status: 'pending' })"
                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 text-gray-900 text-sm font-medium px-4 py-2.5 rounded-xl transition-all">
                        🔍 Review Reports
                        <span v-if="stats?.pending_reports" class="bg-[#B7791F] text-white text-xs font-data px-1.5 py-0.5 rounded-full">{{ stats.pending_reports }}</span>
                    </Link>
                    <Link :href="route('admin.alerts.index')"
                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 text-gray-900 text-sm font-medium px-4 py-2.5 rounded-xl transition-all">
                        🚨 Send Alert
                    </Link>
                    <Link :href="route('admin.news.create')"
                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 text-gray-900 text-sm font-medium px-4 py-2.5 rounded-xl transition-all">
                        📝 Write Article
                    </Link>
                    <Link :href="route('admin.teams.index')"
                        class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 text-gray-900 text-sm font-medium px-4 py-2.5 rounded-xl transition-all">
                        👥 Manage Teams
                    </Link>
                </div>
            </div>

            <!-- Recent activity -->
            <div>
                <h2 class="font-display font-semibold text-gray-900 text-sm uppercase tracking-wider mb-4">Recent reports</h2>
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div v-if="recentReports?.length">
                        <div
                            v-for="report in recentReports"
                            :key="report.id"
                            class="flex items-center gap-4 px-5 py-4 border-b border-gray-200 last:border-0 hover:bg-gray-50 transition-colors"
                        >
                            <SeverityBadge :level="report.severity" />
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-900 text-sm font-medium truncate">{{ report.title }}</p>
                                <p class="text-gray-500 text-xs font-data mt-0.5">{{ report.district?.name }} · {{ report.category?.name }}</p>
                            </div>
                            <TimeAgo :date="report.created_at" />
                            <Link
                                :href="route('admin.reports.show', report.id)"
                                class="text-bay-600 hover:text-bay-700 text-xs font-medium flex-shrink-0 transition-colors"
                            >
                                Review →
                            </Link>
                        </div>
                    </div>
                    <div v-else class="py-12 text-center">
                        <p class="text-gray-500 text-sm">No recent reports.</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

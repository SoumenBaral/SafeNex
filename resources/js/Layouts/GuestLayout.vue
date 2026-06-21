<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex">
        <!-- Left dark panel (desktop only) -->
        <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 bg-ink-900 flex-col justify-between p-12 relative overflow-hidden flex-shrink-0">
            <!-- Decorative Bangladesh silhouette -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none">
                <svg viewBox="0 0 300 400" class="w-72 h-96 opacity-[0.06] text-white fill-current">
                    <path d="M150 30 C120 35,95 50,80 70 C65 90,70 115,75 130 C60 140,50 155,55 175 C60 195,75 205,85 215 C80 230,70 245,80 265 C90 285,110 295,130 300 C125 320,135 340,150 350 C165 360,175 345,180 330 C195 335,215 325,225 310 C240 295,235 275,225 260 C245 250,255 235,250 215 C245 195,230 185,220 175 C235 160,240 140,230 120 C220 100,200 88,185 80 C175 60,160 28,150 30Z"/>
                </svg>
            </div>

            <div class="relative">
                <Link href="/" class="flex items-center gap-2.5 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-bay-600 flex items-center justify-center text-white font-bold font-display text-lg">S</div>
                    <span class="text-white font-display font-bold text-xl tracking-tight">Safenix</span>
                </Link>
                <p class="text-ink-500 text-xs font-data">Disaster Monitoring Platform</p>
            </div>

            <div class="relative">
                <blockquote class="text-white/90 text-xl font-display font-semibold leading-snug mb-4">
                    "Helping Bangladesh respond faster to disasters."
                </blockquote>
                <p class="text-ink-400 text-sm leading-relaxed">
                    Real-time incident reporting, admin verification, live mapping and emergency alerts for every district.
                </p>
            </div>

            <div class="relative">
                <div class="flex items-center gap-1.5 text-xs text-ink-500 font-data">
                    <span class="w-1.5 h-1.5 rounded-full bg-bay-500 animate-pulse inline-block"></span>
                    Live monitoring · 64 districts
                </div>
            </div>
        </div>

        <!-- Right form panel -->
        <div class="flex-1 flex flex-col items-center justify-center min-h-screen bg-paper px-6 py-12">
            <!-- Mobile logo -->
            <Link href="/" class="lg:hidden flex items-center gap-2 mb-8">
                <div class="w-8 h-8 rounded-lg bg-bay-600 flex items-center justify-center text-white font-bold font-display">S</div>
                <span class="font-display font-bold text-gray-900 text-lg">Safenix</span>
            </Link>

            <div class="w-full max-w-sm">
                <slot />
            </div>
        </div>
    </div>
</template>

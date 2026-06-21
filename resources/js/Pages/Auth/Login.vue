<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({ email: '', password: '', remember: false });

const submit = () => {
    form.post(route('login'), { onFinish: () => form.reset('password') });
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign in — Safenix" />

        <div class="mb-8">
            <h1 class="font-display font-bold text-gray-900 text-2xl mb-1">Welcome back</h1>
            <p class="text-gray-500 text-sm">Sign in to your Safenix account</p>
        </div>

        <div v-if="status" class="mb-5 bg-[#157F6B]/10 border border-[#157F6B]/30 text-[#157F6B] text-sm font-medium px-4 py-3 rounded-lg">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                <input
                    id="email" type="email" v-model="form.email"
                    required autofocus autocomplete="username"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="you@example.com"
                />
                <InputError class="mt-1.5" :message="form.errors.email" />
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="text-xs text-bay-600 hover:text-bay-700 font-medium">
                        Forgot password?
                    </Link>
                </div>
                <input
                    id="password" type="password" v-model="form.password"
                    required autocomplete="current-password"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="••••••••"
                />
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <div class="flex items-center gap-2">
                <Checkbox id="remember" name="remember" v-model:checked="form.remember" />
                <label for="remember" class="text-sm text-gray-600 cursor-pointer">Remember me</label>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors text-sm"
            >
                {{ form.processing ? 'Signing in…' : 'Sign in' }}
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            No account?
            <Link :href="route('register')" class="text-bay-600 hover:text-bay-700 font-medium">Create one free</Link>
        </p>
    </GuestLayout>
</template>

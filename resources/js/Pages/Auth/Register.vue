<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '', email: '', password: '', password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Create account — Safenix" />

        <div class="mb-8">
            <h1 class="font-display font-bold text-gray-900 text-2xl mb-1">Create your account</h1>
            <p class="text-gray-500 text-sm">Start reporting incidents and tracking disasters</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full name</label>
                <input
                    id="name" type="text" v-model="form.name"
                    required autofocus autocomplete="name"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="Your full name"
                />
                <InputError class="mt-1.5" :message="form.errors.name" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email address</label>
                <input
                    id="email" type="email" v-model="form.email"
                    required autocomplete="username"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="you@example.com"
                />
                <InputError class="mt-1.5" :message="form.errors.email" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input
                    id="password" type="password" v-model="form.password"
                    required autocomplete="new-password"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="At least 8 characters"
                />
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm password</label>
                <input
                    id="password_confirmation" type="password" v-model="form.password_confirmation"
                    required autocomplete="new-password"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-bay-500 focus:ring-bay-500 transition-colors"
                    placeholder="Repeat password"
                />
                <InputError class="mt-1.5" :message="form.errors.password_confirmation" />
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-bay-600 hover:bg-bay-700 disabled:opacity-60 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors text-sm mt-2"
            >
                {{ form.processing ? 'Creating account…' : 'Create account' }}
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account?
            <Link :href="route('login')" class="text-bay-600 hover:text-bay-700 font-medium">Sign in</Link>
        </p>
    </GuestLayout>
</template>

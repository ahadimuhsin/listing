<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">Name</label>
                <input type="text" id="name" class="input" placeholder="Your Full Name" v-model="form.name">
                <ErrorMessage :message="form.errors.name"></ErrorMessage>
            </div>
            <div class="mt-4">
                <label for="email" class="label">Email</label>
                <input type="email" id="email" class="input" placeholder="Type your email" v-model="form.email">
                <ErrorMessage :message="form.errors.email"></ErrorMessage>
            </div>
            <div class="mt-4">
                <label for="password" class="label">Password</label>
                <input type="password" id="password" class="input" placeholder="Type your password" v-model="form.password">
                <ErrorMessage :message="form.errors.password"></ErrorMessage>
            </div>
            <div class="mt-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input type="password" id="password_confirmation" class="input" placeholder="Confirmation Password" v-model="form.password_confirmation">
            </div>
            <div class="mt-4">
                <button type="submit" class="btn-primary w-full mt-3">Create Account</button>

                <div class="mt-3 text-center">
                    <Link :href="route('login')" class="text-sm text-gray-500">
                    Already have an account? Click here
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import ErrorMessage from '@/Components/UI/ErrorMessage.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    email: null,
    password: null,
    name: null,
    password_confirmation: null
});

const register = () => {
    form.post(route('user-account.store'))
}
</script>

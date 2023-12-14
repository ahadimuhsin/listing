<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
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
                <button type="submit" class="btn-primary w-full mt-3">Login</button>

                <div class="mt-3 text-center">
                    <Link :href="route('user-account.create')" class="text-sm text-gray-500">
                    Need an account? Click here
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
    password: null
});

const login = () => {
    form.post(route('login.store'))
}
</script>

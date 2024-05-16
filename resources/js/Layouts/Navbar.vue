<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps([
    'canLogin',
    'canRegister',
]);

</script>

<template>
    <div v-if="canLogin" class="static top-0 right-0 p-6 text-end w-full bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <Link
            :href="route('welcome')"
            class="me-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >Accueil</Link
        >
        <template v-if="$page.props.auth.user">
            <Link
                v-if="$page.props.auth.user.role_id == 1 || $page.props.auth.user.role_id == 2"
                :href="route('admin')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Admin</Link
            >
            <Link
                v-else
                :href="route('profile.edit')"
                class="me-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Profil</Link
            >
        </template>
        <template v-else>
            <Link
                :href="route('login')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Se connecter</Link
            >

            <Link
                v-if="canRegister"
                :href="route('register')"
                class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >S'enregistrer</Link
            >
        </template>
    </div>
</template>

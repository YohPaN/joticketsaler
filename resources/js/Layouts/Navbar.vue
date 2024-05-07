<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps([
    'canLogin',
    'canRegister',
]);

</script>

<template>
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            >Tableau de bord</Link
        >

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

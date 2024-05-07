<script setup>
import Offer from '@/Components/Offer.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
const images = import.meta.glob('/resources/assets/*_ticket.png', { eager: true, query: 'url', import: 'default' })

defineProps({offers: Array})
</script>

<template>
    <Head title="Admin" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 justify-center">
                    <Offer v-for="offer in offers">
                        <template #image>
                            <img style="max-height: 15rem;" :src="images['/resources/assets/' + offer.name + '_ticket.png']">
                        </template>
                        <template #title>
                            {{ offer.name }}
                        </template>
                        <template #sale_number>
                            {{ offer.total_sold }}
                        </template>
                        <template #button>
                            <button class="bg-primary w-32 rounded-xl p-2 text-white">Edit</button>
                            <button class="bg-danger w-32 rounded-xl p-2">Delete</button>
                        </template>
                    </Offer>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

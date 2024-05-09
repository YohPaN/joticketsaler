<script setup>
import Offer from '@/Components/Offer.vue';
import Navbar from '@/Layouts/Navbar.vue';
import { Head } from '@inertiajs/vue3';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    offers: {
        type: Array,
    }
});
</script>

<template>
    <Head title="Shop" />
    <Navbar
        :canLogin="canLogin"
        :canRegister="canRegister"
    ></Navbar>
    <div class="min-h-screen bg-gray-100 flex justify-center items-center pt-16">
        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-semibold text-4xl uppercase underline text-center text-gray-800 leading-tight mb-24">Offres disponibles</h1>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 justify-center">
                    <Offer v-for="offer in offers" :offerName="offer.name">
                        <template #title>
                            {{ offer.name }}
                        </template>
                        <template #ticket_number>
                            {{ offer.ticket_number }}
                        </template>
                        <template #button>
                            <button class="bg-primary rounded-xl p-2 text-white" @click="edit(offer.id)">Ajouter au panier</button>
                        </template>
                    </Offer>
                </div>
            </div>
        </div>
    </div>
</template>

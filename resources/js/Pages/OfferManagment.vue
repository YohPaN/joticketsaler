<script setup>
import Offer from '@/Components/Offer.vue';
import OfferEdit from '@/Components/OfferEdit.vue'
import OfferCreate from '@/Components/OfferCreate.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
const images = import.meta.glob('/resources/assets/*_ticket.png', { eager: true, query: 'url', import: 'default' })

defineProps({offers: Array})

let offerToDelete = null;
const show = ref(false);

function close() {
    show.value = false;
    offerToDelete = null;
}

function deleteOffer(id) {
    router.delete('offer/' + id, {
        preserveScroll: true,
        onFinish: () => {
            show.value = false;
            offerToDelete = null;
        },
    });
}

function openDeleteConfirmation(offer) {
    offerToDelete = offer;
    show.value = true;
}


function edit(id) {
    const container = document.getElementById('container-' + id);
    container.classList.add('animate-edit-offer')
    container.classList.remove('animate-remove-edit')
}

function create() {
    const container = document.getElementById('container-main');
    container.classList.add('animate-edit-offer')
    container.classList.remove('animate-remove-edit')
}

</script>

<template>
    <Head title="OfferManagment" />

    <Modal :show="show" @close="close">
        <div class="w-full h-64 flex justify-center items-center bg-warning p-5 border-4 border-black rounded-md">
            <div class="grid grid-row-3 text-2xl text-center">
                <p>Etes-vous sure de vouloir supprimer l'offre:</p>
                <b class="capitalize">{{ offerToDelete.name }}</b>
                <div class="flex justify-between mt-16">
                    <PrimaryButton @click="close">
                        <p class="py-2 px-4">Annuler</p>
                    </PrimaryButton>
                    <DangerButton @click="deleteOffer(offerToDelete.id)">
                        <p class="py-2 px-4">Supprimer</p>
                    </DangerButton>
                </div>
            </div>
        </div>
    </Modal>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des offres</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 justify-center">
                    <button @click="create" class="rounded-xl border-8 border-dashed border-black py-40 lg:p-5 relative overflow-hidden flex items-center justify-center">
                        <OfferCreate />
                        <div class="border-8 border-dashed border-black rounded-full p-8">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="size-16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </button>
                    <Offer v-for="offer in offers" :offerName="offer.name">
                        <template #edit>
                            <OfferEdit :offer="offer"></OfferEdit>
                        </template>
                        <template #title>
                            {{ offer.name }}
                        </template>
                        <template #sale_number>
                            {{ offer.total_sold }}
                        </template>
                        <template #button>
                            <button class="bg-primary w-32 rounded-xl p-2 text-white" @click="edit(offer.id)">Edit</button>
                            <button class="bg-danger w-32 rounded-xl p-2" @click="openDeleteConfirmation(offer)">Delete</button>
                        </template>
                    </Offer>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import Offer from '@/Components/Offer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Navbar from '@/Layouts/Navbar.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    offers: {
        type: Array,
    },
    cartId: {
        type: Number,
    },
    warningMessage: {
        type: String,
    }
});

function add(offerId) {
    router.post(route('cart.store'), {
        id: offerId,
    }, {
        preserveScroll: true,
    });
}

const showModal = ref(props.warningMessage);

function close() {
    showModal.value = false;
}

watch(props,
    () => {
        showModal.value = props.warningMessage;
    }
)

</script>

<template>
    <Head title="Shop" />

    <Modal :show="showModal" @close="close">
        <div class="w-full h-24 flex justify-center items-center bg-warning p-5">
            {{ warningMessage }}
        </div>
    </Modal>

    <Navbar
        :canLogin="canLogin"
        :canRegister="canRegister"
    ></Navbar>
    <div class="min-h-screen flex justify-center items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-semibold text-4xl uppercase underline text-center text-gray-800 leading-tight mb-24">Offres disponibles</h1>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 justify-center">
                    <Offer v-for="offer in offers" :offerName="offer.name" class="mx-5">
                        <template #title>
                            {{ offer.name }}
                        </template>
                        <template #ticket_number>
                            {{ offer.ticket_number }}
                        </template>
                        <template #button>
                            <button class="bg-primary rounded-xl p-2 text-white" @click="add(offer.id)">Ajouter au panier</button>
                        </template>
                    </Offer>
                </div>

                <div @click="router.get('cart')" class="mt-10 flex justify-center"><PrimaryButton>Continuer vers le payement</PrimaryButton></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Navbar from '@/Layouts/Navbar.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const images = import.meta.glob('/resources/assets/*_ticket.png', { eager: true, query: 'url', import: 'default' })

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    data: Array
});
const total = ref(0);
const totalCount = ref(0);

onMounted(() => {
    props.data.forEach(element => {
        totalCount.value += element.count
        total.value += element.count * element.price;
    });
})

function deleteItem (itemId) {
    router.delete('cart/' + itemId, {
        onFinish: () => {
            props.data.forEach(element => {
                totalCount.value = 0;
                totalCount.value += element.count;
                total.value = 0;
                total.value += element.count * element.price;
            });
        },
        preserveScroll: true,
    })
}

</script>

<template>
    <Head title="Cart" />
    <Navbar
        :canLogin="canLogin"
        :canRegister="canRegister"
    ></Navbar>
    <div class="min-h-screen sm:flex sm:justify-center sm:items-center bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="py-12 w-full">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-semibold text-4xl uppercase underline text-center text-gray-800 leading-tight mb-5">Panier</h1>
                <div class="flex justify-center">
                    <div class="flex flex-col w-fit">
                        <p class="self-end m-8">{{ 'Total (' + 3 + ' articles): ' + total + '€' }}</p>
                        <div v-for="item in data">
                            <div class="flex lg:flex-row flex-col justify-center items-center rounded-xl border border-black m-8 p-5">
                                <div class="mx-10 my-5" style="width: 5rem; height: 5rem">
                                    <span v-if="images['/resources/assets/' + item.name + '_ticket.png']">
                                        <img :src="images['/resources/assets/' + item.name + '_ticket.png']">
                                    </span>

                                    <span v-else>
                                        <img src="../../assets/JO_logo.png">
                                    </span>
                                </div>
                                <div class="mx-10">
                                    <p><u>Offre:</u> {{ item.name }}</p>
                                    <p><u>Prix:</u>{{ ': ' + item.price }}</p>
                                    <p><u>Nombre de ticket dans l'offre:</u>{{ ' ' + item.ticket_number }}</p>
                                    <p><u>Total:</u> {{ item.price * item.count + '€ (' +  item.count + ' articles)' }}</p>
                                </div>
                                <div class="mx-10 lg:mt-0 mt-5">
                                    <button class="rounded-full bg-red-600 p-1" @click="deleteItem(item.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="text-white size-8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="mt-10 flex">
                            <div @click="router.get('shop')" class="m-3 basis-1/2">
                                <PrimaryButton class="w-full h-full justify-center bg-red-500">Retour au shop</PrimaryButton>
                            </div>
                            <div @click="router.get('payment')" class="m-3 basis-1/2">
                                <PrimaryButton class="w-full justify-center" :disabled="data.length < 1">Continuer vers le payement</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

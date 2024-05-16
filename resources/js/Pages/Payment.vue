<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Navbar from '@/Layouts/Navbar.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    errorMessage: {
        type: String,
    }
})

const showModal = ref(false);

const form = useForm({
    card_number: '',
    expiration_date: '00/00/0000',
    cvc: '',
})

function submit() {
    form.post(route('checkout'));
}

function cardInput(event) {
    const inputLength = event.target.value.length;
    if(inputLength === 4 || inputLength === 9 || inputLength === 14) {
        form.card_number = form.card_number + ' ';
    }
}

function close() {
    showModal.value = false;
}

watch(props,
    () => {
        showModal.value = props.errorMessage;
    }
)
</script>

<template>

<Head title="Payment" />

<Modal :show="showModal" @close="close">
    <div class="w-full h-24 flex justify-center items-center bg-danger">
        {{ errorMessage }}
    </div>
</Modal>

<Navbar
    :canLogin="canLogin"
    :canRegister="canRegister"
></Navbar>

<div class="min-h-screen bg-gray-100 flex justify-center items-center pt-16">
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-semibold text-4xl uppercase underline text-center text-gray-800 leading-tight mb-5">Paiement</h1>
            <div class="flex lg:flex-row flex-col justify-center items-center">
                <div class="w-fit  rounded-xl border border-black m-8 p-5">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="card_number" value="Numéro de carte" />

                                <TextInput
                                    id="card_number"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.card_number"
                                    required
                                    autofocus
                                    placeholder="0000 0000 0000 0000"
                                    @input="cardInput"
                                />

                                <InputError class="mt-2" :message="form.errors.card_number" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="expiration_date" value="Date d'expiration" />

                                <TextInput
                                    id="expiration_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.expiration_date"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.expiration_date" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="cvc" value="CVC" />

                                <TextInput
                                    id="cvc"
                                    type="string"
                                    class="mt-1 block w-full"
                                    v-model="form.cvc"
                                    required
                                />

                                <InputError class="mt-2" :message="form.errors.cvc" />
                            </div>

                            <div class="mt-10 flex">
                                <div @click="router.get('cart')" class="m-3 basis-1/2">
                                    <PrimaryButton class="w-full h-full justify-center bg-red-500">Retour au panier</PrimaryButton>
                                </div>
                                <div class="m-3 basis-1/2">
                                    <PrimaryButton class="w-full justify-center h-full">Payer</PrimaryButton>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>


</template>

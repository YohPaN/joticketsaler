<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3'

const props = defineProps(['offer']);
const offer = props.offer

const form = useForm({
    id: offer.id,
    name: offer.name,
    price: offer.price,
    ticket_number: offer.ticket_number,
});

const submit = () => {
    form.put(route('offer.update'), {
        onSuccess: () => removeEdit(),
    });
};

function removeEdit() {
    const container = document.getElementById('container-' + offer.id);
    container.classList.add('animate-remove-edit');
    container.classList.remove('animate-edit-offer');
}

</script>

<template>
    <div :id="'container-' + offer.id" class="w-full h-full px-4 py-4 rounded-lg absolute bottom-full left-0 bg-slate-50 flex flex-col">
        <button class="self-end" @click="removeEdit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <form @submit.prevent="submit" class="pt-6">
            <div>
                <InputLabel for="name" value="Nom de l'offre" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="price" value="Prix" />
                <TextInput
                    id="price"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.price"
                    required
                />
                <InputError class="mt-2" :message="form.errors.price" />
            </div>

            <div class="mt-4">
                <InputLabel for="ticket_number" value="Nombre de ticket" />
                <TextInput
                    id="ticket_number"
                    type="number"
                    min="0"
                    class="mt-1 block w-full"
                    v-model="form.ticket_number"
                    required
                />
                <InputError class="mt-2" :message="form.errors.ticket_number" />
            </div>

            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Modifier
            </PrimaryButton>
        </form>
    </div>
</template>

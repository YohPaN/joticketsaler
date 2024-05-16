<script setup>
const images = import.meta.glob('/resources/assets/*_ticket.png', { eager: true, query: 'url', import: 'default' })

defineProps(['offerName'])
</script>

<template>
    <div class="rounded-xl bg-slate-300 shadow-xl text-center p-5 relative overflow-hidden">
        <slot name="edit"></slot>
        <div class="w-full flex justify-center mt-8 mb-4 h-60">
            <span v-if="images['/resources/assets/' + offerName + '_ticket.png']">
                <img style="max-height: 15rem;" :src="images['/resources/assets/' + offerName + '_ticket.png']">
            </span>

            <span v-else>
                <img style="max-height: 15rem;" src="../../assets/JO_logo.png">
            </span>
        </div>
        <h1 class="text-5xl font-bold capitalize">
            <slot name="title"></slot>
        </h1>
        <div v-if="$slots.ticket_number" class="text-center text-2xl mt-5">
            <p>Nombre de ticket(s): <slot name="ticket_number"></slot></p>
        </div>
        <div v-else class="text-center text-2xl mt-5">
            <p><slot name="sale_number"></slot> ventes</p>
        </div>
        <div class="flex justify-evenly mt-5 text-white text-xl">
            <slot name="button"></slot>
        </div>
    </div>
</template>

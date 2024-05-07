<script setup>
</script>

<template>
    <div class="rounded-xl bg-slate-300 shadow-xl text-center p-5">
        <div class="w-full flex justify-center mt-8 mb-4">
            <slot name="image"></slot>
        </div>
        <h1 class="text-5xl font-bold capitalize">
            <slot name="title"></slot>
        </h1>
        <div class="text-center text-2xl mt-5">
            <p><slot name="sale_number"></slot> ventes</p>
        </div>
        <div class="flex justify-evenly mt-5 text-white text-xl">
            <slot name="button"></slot>
        </div>
    </div>
</template>

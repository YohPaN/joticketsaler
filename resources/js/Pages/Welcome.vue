<script setup>
import Navbar from '@/Layouts/Navbar.vue';
import { Head } from '@inertiajs/vue3';
import joLogo from '../../assets/JO_logo.png';
import escaldadePic from '../../assets/escalade.jpg';
import runningPic from '../../assets/running.jpg';
import SportPresentation from '@/Components/SportPresentation.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >

        <Navbar
            :canLogin="canLogin"
            :canRegister="canRegister"
        ></Navbar>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center mb-5">
                <img style="width: 100px;" :src="joLogo">
            </div>

            <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                <div>
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Présentation des JO 2024</h2>

                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed indent-8 text-justify">
                        Bonjour et bienvenue ! Paris 2024 célèbre l'unité dans la diversité en accueillant des athlètes venant des quatre coins du monde. Avec des sites emblématiques chargés d'histoire et un engagement envers la durabilité, nous visons à inspirer la grandeur tout en favorisant les échanges culturels. Du Stade de France à la Seine, la ville lumière sera le théâtre d'un spectacle où excellence et esprit sportif se rencontrent.
                    </p>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed indent-8 text-justify">
                        Parallèlement aux compétitions, Paris 2024 sera un festival de la culture mondiale, mettant en avant les traditions uniques de chaque nation participante. Ensemble, nous construirons un héritage durable, une célébration de l'unité dans laquelle le monde entier se rassemble autour de l'amour du sport. Rejoignez-nous pour une aventure où le sport rencontre la culture, où les frontières s'estompent et où les rêves deviennent réalité.
                    </p>
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        Bienvenue à Paris 2024 !
                    </p>
                </div>
            </div>
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <SportPresentation>
                        <template #image>
                            <img :src="escaldadePic" :alt="escaldadePic">
                        </template>
                        <template #title>
                            Escalade
                        </template>
                        <template #presentation>
                            L'escalade, sport de défis aux Jeux Olympiques de Paris 2024, allie force, agilité et concentration sur des parois verticales époustouflantes.
                        </template>
                    </SportPresentation>
                    <SportPresentation>
                        <template #image>
                            <img :src="runningPic" :alt="runningPic">
                        </template>
                        <template #title>
                            Course à pied
                        </template>
                        <template #presentation>
                            Paris 2024 propose une variété d'épreuves de course à pied, allant du sprint à la course de fond, mettant en avant l'endurance et la vitesse des athlètes.
                        </template>
                    </SportPresentation>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>

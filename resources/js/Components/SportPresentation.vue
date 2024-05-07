<template>
    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div class="grid grid-cols-1 xl:grid-cols-2">
            <div class=" content-center">
                <slot name="image"></slot>
            </div>
            <div class="content-start ps-4">
                <h2 class="mt-6 xl:mt-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <slot name="title"></slot>
                </h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed text-justify">
                    <slot name="presentation"></slot>
                </p>
            </div>
        </div>
    </div>
</template>

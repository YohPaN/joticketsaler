import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#0d6efd',
                'success': '#198754',
                'danger': '#dc3545',
                'warning': '#ffc107',
            },
            animation: {
                'edit-offer': '1s ease-in slidein forwards',
                'remove-edit': '1s ease-in slideout forwards'
            },
            keyframes: {
                slideout: {
                    '0%': {transform: 'translateY(100%)'},
                    '100%': {transform: 'translateY(-100%)'}
                },
                slidein: {
                    '0%': {transform: 'translateY(-100%)'},
                    '100%': {transform: 'translateY(100%)'}
                }
            }
        },
    },

    plugins: [forms],
};

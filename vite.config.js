import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    test: {
        environment: 'happy-dom',
        coverage: {
            exclude: [
                '**/Pages/Auth/ConfirmPassword.vue',
                '**/Pages/Auth/ForgotPassword.vue',
                '**/Pages/Auth/ResetPassword.vue',
                '**/Pages/Auth/VerifyEmail.vue',
                '**/Profile/Partials/DeleteUserForm.vue',
                '**/Profile/Partials/UpdatePasswordForm.vue',
                '**/Profile/Edit.vue',
                '**/Layouts/GuestLayout.vue',
                '**/Components/Checkbox.vue',
                '**/Components/DangerButton.vue',
                '**/Components/Dropdown.vue',
                '**/Components/DropdownLink.vue',
                '**/Components/InputError.vue',
                '**/Components/InputLabel.vue',
                '**/Components/Modal.vue',
                '**/Components/NavLink.vue',
                '**/Components/PrimaryButton.vue',
                '**/Components/ResponsiveNavLink.vue',
                '**/Components/SecondaryButton.vue',
                '**/Components/TextInput.vue',
                '**/bootstrap.js',
                '**/app.js',
            ]
        }
    },
});

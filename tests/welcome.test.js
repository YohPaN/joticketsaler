// sum.test.js
import { test } from 'vitest'

import { shallowMount } from '@vue/test-utils';
import Navbar from '@/Layouts/Navbar.vue';

test('User that can loggin view loggin button', () => {
    const wrapper = shallowMount(Navbar, {
        props: {
            canLogin: true,
            canRegister: true,
        },

    })
    wrapper.find('#login').isVisible()
})

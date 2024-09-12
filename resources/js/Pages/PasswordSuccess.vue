<template>
    <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/background-image.png');">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md sm:p-8 lg:p-10 sm:max-w-xl lg:max-w-2xl">
            <div class="flex justify-center mb-4">
            <i class="fas fa-check-circle text-6xl" style="color: green;"></i>
            </div>
            <div class="mb-6 text-2xl font-semibold text-center lg:text-3xl center">Success</div>
            <p class="mb-8 text-center text-gray-500">{{ message }}</p>
            <div class="flex justify-center">
                <button @click="redirectToLogin" class="px-4 py-4 font-semibold text-white bg-blue-500  hover:bg-blue-600 rounded-md">BACK TO LOG IN</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    message: {
        type: String,
        default: 'Your password has been reset back to default successfully.'
    }
});

const redirectToLogin = () => {
    Inertia.visit(route('login'));
};
</script>

<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

defineProps({
    context: {
        type: String,
        required: true,
        default: 'login'
    }
});

const form = useForm({
    empmail: '',
});

const isLoading = ref(false); // Add a loading state

const submit = () => {
    isLoading.value = true; // Start loading when OTP is being sent

    form.post(route('otp.send'), {
        onSuccess: () => {
            console.log('OTP sent successfully'); // Log to confirm OTP was sent

            // Redirect directly without causing a conflict
            window.location.href = route('otp.form', {
                context: 'forgot-password',
                otpSent: true // Pass a flag to indicate that OTP was sent
            });
        },
        onError: (errors) => {
            isLoading.value = false; // Stop loading if there's an error
            console.error("Failed to send OTP", errors);
        }
    });
};
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/background-image.png');">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg bg-opacity-90">
            <Head title="Forgot Password" />
            <div class="mb-2 text-3xl font-bold text-center text-black">
                <h1>FORGOT PASSWORD</h1>
            </div>
            <div class="mb-6 text-sm font-semibold text-center text-gray-600">
                Please enter your email associated with your account
            </div>

            <hr class="mb-12 border-gray-300">


            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>
            <form @submit.prevent="submit">
            <div class="mb-4 relative">
                <TextInput
                    id="empmail"
                    type="email"
                    class="block w-full p-3 pr-12 text-lg border-gray-300 rounded-md"
                    v-model="form.empmail"
                    required
                    autofocus
                    autocomplete="username"
                />
                <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xl"></i>
                <InputError class="mt-2" :message="form.errors.empmail" />
            </div>
                <div class="flex items-center justify-center mt-4">
                    <PrimaryButton :class="{ 'opacity-25': form.processing || isLoading }" :disabled="form.processing || isLoading" class="mt-4 py-4 px-8 font-semibold text-white rounded-md bg-gradient-to-r from-pink-500 to-blue-500 hover:from-pink-600 hover:to-blue-600">
                        <span v-if="!isLoading">SEND OTP</span>
                        <span v-else>Sending...</span>
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

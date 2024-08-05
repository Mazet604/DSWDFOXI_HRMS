<template>
    <GuestLayout>
        <Head title="OTP Verification" />

        <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/background-image.png');">
            <div class="w-full max-w-xs p-4 bg-white rounded-lg shadow-md sm:p-6 lg:p-8 sm:max-w-md lg:max-w-lg">
                <div class="mb-4 text-xl font-semibold text-center lg:text-2xl">OTP Verification</div>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <div v-if="error" class="mb-4 text-sm font-medium text-red-600">
                    {{ error }}
                </div>

                <form @submit.prevent="submitOtp">


                    <div class="mt-4">
                        <InputLabel for="otp" value="OTP Code" />
                        <TextInput id="otp" type="text" class="block w-full mt-1" v-model="form.otp" required />
                        <InputError class="mt-2" :message="form.errors.otp" />
                    </div>

                    <div class="mt-4">
                        <PrimaryButton class="w-full py-2 text-center text-white rounded-full bg-gradient-to-r from-pink-500 to-blue-500 hover:from-pink-600 hover:to-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <span class="w-full text-center">VERIFY OTP</span>
                        </PrimaryButton>
                    </div>
                </form>

                <div class="mt-4">
                    <PrimaryButton @click="sendOtp" class="w-full py-2 text-center text-white rounded-full bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600">
                        <span class="w-full text-center">RESEND OTP</span>
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';

const form = useForm({
    email: '',
    otp: '',
});

const error = ref(null);
const status = ref(null);

const submitOtp = () => {
    form.post(route('otp.verify'), {
        onError: () => {
            error.value = 'Invalid OTP.';
        },
        onSuccess: (page) => {
            if (page.props.errors) {
                error.value = 'Invalid OTP.';
            } else {
                Inertia.visit(route('dashboard'));
            }
        }
    });
};

const sendOtp = async () => {
    try {
        const response = await axios.post(route('otp.send'), { email: form.email });
        status.value = response.data.message;
        error.value = null;
    } catch (err) {
        error.value = err.response?.data?.error || 'Failed to send OTP. Please try again later.';
        status.value = null;
    }
};
</script>

<template>
    <Head title="OTP Verification" />

    <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/background-image.png');">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md sm:p-8 lg:p-10 sm:max-w-xl lg:max-w-2xl">
            <div class="mb-6 text-2xl font-semibold text-center lg:text-3xl">OTP Verification</div>
            <p class="text-center text-gray-500 mb-8">Please enter the code sent to your Mail.</p>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <div v-if="error" class="mb-4 text-sm font-medium text-red-600">
                {{ error }}
            </div>

            <form @submit.prevent="submitOtp">
                <div class="mt-6 text-center">
                    <div class="flex justify-center space-x-3 mt-2">
                        <TextInput v-for="(digit, index) in otpDigits" :key="index" :id="'otp' + index" type="text" class="w-14 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" v-model="otpDigits[index]" maxlength="1" @input="onInput($event, index)" required />
                    </div>
                    <InputError class="mt-2" :message="form.errors.otp" />
                </div>

                <div class="mt-8">
                    <PrimaryButton class="w-full py-3 text-center text-white rounded-full bg-gradient-to-r from-pink-500 to-blue-500 hover:from-pink-600 hover:to-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <span class="w-full text-center">VERIFY OTP</span>
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    email: '',
    otp: '',
});

const otpDigits = ref(['', '', '', '', '', '']);
const error = ref(null);
const status = ref(null);

const submitOtp = () => {
    form.otp = otpDigits.value.join('');
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

const moveToNext = (index) => {
    if (otpDigits.value[index].length === 1 && index < otpDigits.value.length - 1) {
        document.getElementById('otp' + (index + 1)).focus();
    }
};

const onInput = (event, index) => {
    const value = event.target.value;
    if (!/^\d$/.test(value)) {
        otpDigits.value[index] = '';
    } else {
        otpDigits.value[index] = value;
        moveToNext(index);
    }
};
</script>

<style scoped>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -webkit-appearance: none; /* for Chrome */
    -moz-appearance: textfield; /* for Firefox */
    appearance: none; /* standard property */
}
</style>

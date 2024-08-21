<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SuccessModal from '@/Layouts/SuccessModal.vue';  // Import the modal component

const props = defineProps({
    context: {
        type: String,
        required: true, // 'login' or 'forgot-password'
    },
    otpSent: {
        type: Boolean,
        default: false // This will be true if OTP was sent successfully
    }
});

const otpDigits = ref(['', '', '', '', '', '']);
const error = ref(null);
const status = ref(null);
const showSuccessDialog = ref(false);
const showPasswordChangedDialog = ref(false);

const form = useForm({
    otp: otpDigits.value.join(''),
    context: props.context
});

onMounted(() => {
    console.log('otpSent flag:', props.otpSent); // Log the otpSent flag to verify it's being passed correctly
    if (props.otpSent) {
        showSuccessDialog.value = true; // Show the success modal immediately if otpSent is true
    }
});

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
                if (props.context === 'forgot-password') {
                    status.value = 'OTP verified. Password reset successfully.';
                    showPasswordChangedDialog.value = true; // Show the password changed modal
                } else if (props.context === 'login') {
                    status.value = 'OTP verified. Redirecting to dashboard...';
                    Inertia.visit(route('dashboard'));
                }
            }
        }
    });
};

const closeInitialModal = () => {
    showSuccessDialog.value = false;
    // User remains on the OTP page to enter the OTP
};

const closePasswordChangedModal = () => {
    showPasswordChangedDialog.value = false;
    Inertia.visit(route('login')); // Redirect to login after closing the password changed modal
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

<template>
    <Head title="OTP Verification" />
    <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/bgwhiteredblue.png');">
        <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md sm:p-8 lg:p-10 sm:max-w-xl lg:max-w-2xl">
            <div class="mb-6 text-2xl font-semibold text-center lg:text-3xl">OTP Verification</div>
            <p class="mb-8 text-center text-gray-500">Please enter the OTP sent to your email.</p>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <div v-if="error" class="mb-4 text-sm font-medium text-red-600">
                {{ error }}
            </div>

            <form @submit.prevent="submitOtp">
                <div class="mt-6 text-center">
                    <div class="flex justify-center mt-2 space-x-3">
                        <TextInput v-for="(digit, index) in otpDigits" :key="index" :id="'otp' + index" type="text" class="text-2xl text-center border border-gray-300 rounded-lg w-14 h-14 focus:outline-none focus:ring-2 focus:ring-blue-500" v-model="otpDigits[index]" maxlength="1" @input="onInput($event, index)" required />
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

    <!-- Success Modal for OTP Sent -->
    <SuccessModal :show="showSuccessDialog" message="OTP has been sent successfully! Check your Email." @close="closeInitialModal" />

    <!-- Success Modal for Password Changed -->
    <SuccessModal :show="showPasswordChangedDialog" message="Password has been reset to the default value." @close="closePasswordChangedModal" />
</template>

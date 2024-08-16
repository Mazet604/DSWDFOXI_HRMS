<template>
    <Head title="Log in" />

        <div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('/images/bgwhiteredblue.png');">
            <div class="w-full max-w-xs p-4 bg-white rounded-lg shadow-md sm:p-6 lg:p-8 sm:max-w-md lg:max-w-lg">
                <div class="flex justify-center mb-6 lg:mb-8">
                    <img src="/images/dswd-logo1.png" alt="DSWD Logo" class="h-20 lg:h-40" />
                </div>

            <div class="mb-4 text-xl font-semibold text-center lg:text-2xl">Human Resource Management System</div>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="empuser" value="Username" />
                    <InputText id="empuser" type="text" class="block w-full mt-1" v-model="form.empuser" required autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.empuser" />
                </div>

                <div class="mt-4">
                    <InputLabel for="emppass" value="Password" />
                    <InputText :type="showPassword ? 'text' : 'password'" id="emppass" class="block w-full mt-1" v-model="form.emppass" required autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.emppass" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="showPassword" v-model="showPassword" class="mr-2" />
                        <label for="showPassword" class="text-sm text-gray-600">Show Password</label>
                    </div>
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-blue-600 hover:underline">
                        Forgot Password?
                    </Link>
                </div>

                <div class="mt-4">
                    <PrimaryButton class="w-full py-2 text-center text-white rounded-full bg-gradient-to-r from-pink-500 to-blue-500 hover:from-pink-600 hover:to-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <span class="w-full text-center">LOG IN</span>
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
        default: true,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    empuser: '',
    emppass: '',
});

const showPassword = ref(false);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const submit = () => {
    form.post(route('login'), {
        onSuccess: (page) => {
            if (page.props.otp_required) {
                Inertia.visit(route('otp.form'), {
                    method: 'get',
                    data: {
                        context: 'login'
                    }
                });
            } else {
                Inertia.visit(route('dashboard'));
            }
        },
    });
};
</script>

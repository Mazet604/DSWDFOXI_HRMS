<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
        default: true, // Ensure default value is set to true for testing
    },
    status: {
        type: String,
    },
});

const form = useForm({
    empuser: '',
    emppass: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('emppass'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('/images/background-image.png');">
            <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 lg:p-8 max-w-xs sm:max-w-md lg:max-w-lg w-full">
                <div class="flex justify-center mb-6 lg:mb-8">
                    <img src="/images/dswd-logo1.png" alt="DSWD Logo" class="h-20 lg:h-40" />
                </div>

                <div class="text-center text-xl lg:text-2xl font-semibold mb-4">Human Resource Management System</div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="empuser" value="Username" />

                        <TextInput
                            id="empuser"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.empuser"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.empuser" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="emppass" value="Password" />

                        <TextInput
                            id="emppass"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.emppass"
                            required
                            autocomplete="current-password"
                        />

                        <InputError class="mt-2" :message="form.errors.emppass" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-blue-600 hover:underline"
                        >
                            Forgot Password?
                        </Link>
                    </div>

                    <div class="mt-4">
                        <PrimaryButton class="w-full text-center bg-gradient-to-r from-pink-500 to-blue-500 text-white py-2 rounded-full hover:from-pink-600 hover:to-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <span class="w-full text-center">LOG IN</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.bg-cover {
    background-size: cover;
}

.bg-center {
    background-position: center;
}
</style>

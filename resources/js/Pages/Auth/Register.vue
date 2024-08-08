<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    empuser: '',
    empmail: '',
    emppass: '',
    emppass_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('emppass', 'emppass_confirmation'),
    });
};
</script>

<template>
        <Head title="Register" />

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
                <InputLabel for="empmail" value="Email" />

                <TextInput
                    id="empmail"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.empmail"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.empmail" />
            </div>

            <div class="mt-4">
                <InputLabel for="emppass" value="Password" />

                <TextInput
                    id="emppass"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.emppass"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.emppass" />
            </div>

            <div class="mt-4">
                <InputLabel for="emppass_confirmation" value="Confirm Password" />

                <TextInput
                    id="emppass_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.emppass_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.emppass_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
</template>

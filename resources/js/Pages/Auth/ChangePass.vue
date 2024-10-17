<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-8 text-center bg-white rounded-lg shadow-lg w-96">
      <label class="text-lg font-semibold text-blue-900 ">CHANGE PASSWORD</label>
      <form @submit.prevent="changePassword">
        <div class="mb-4 text-left">
          <label for="password" class="block mb-1 text-sm font-bold text-gray-700">New Password:</label>
          <input type="password" v-model="password" required class="input-field" />
        </div>
        <div class="mb-4 text-left">
          <label for="password_confirmation" class="block mb-1 text-sm font-bold text-gray-700">Confirm Password:</label>
          <input type="password" v-model="password_confirmation" required class="input-field" />
        </div>
        <div class="flex justify-center gap-4">
          <button type="button" @click="$emit('close')" class="px-3 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">
            CANCEL
          </button>
          <button type="submit" class="px-3 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">
            CONFIRM
          </button>
        </div>
        <transition name="fade">
          <div v-if="errors.length" class="mt-4 text-left text-red-600 transition-opacity duration-1000">
            <ul class="pl-0 list-none">
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>
        </transition>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      password: '',
      password_confirmation: '',
      errors: []
    };
  },
  methods: {
    async changePassword() {
      this.errors = [];
      try {
        const response = await axios.post('/api/update-password', {
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        alert(response.data.message);
        this.$emit('close');
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
          this.clearErrorsAfterDelay();
        } else {
          console.error(error);
          alert('Failed to update password.');
        }
      }
    },
    clearErrorsAfterDelay() {
      setTimeout(() => {
        this.errors = [];
      }, 4000);
    }
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.input-field {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #cbd5e0;
    border-radius: 0.375rem;
    box-sizing: border-box;
}

</style>

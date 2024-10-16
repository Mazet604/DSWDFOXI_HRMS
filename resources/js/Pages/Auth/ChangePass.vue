<template>
  <div class="modal">
    <div class="modal-content">
      <h2>Change Password</h2>
      <form @submit.prevent="changePassword">
        <div class="form-group">
          <label for="password">New Password:</label>
          <input type="password" v-model="password" required />
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirm Password:</label>
          <input type="password" v-model="password_confirmation" required />
        </div>
        <div class="form-actions">
          <button type="button" class="cancel-btn" @click="$emit('close')">CANCEL</button>
          <button type="submit" class="submit-btn">SUBMIT</button>
        </div>
        <transition name="fade">
          <div v-if="errors.length" class="error-messages">
            <ul>
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
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  width: 450px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  position: relative;
}

h2 {
  margin-bottom: 20px;
  color: #203c8c;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333;
}

input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 20px;
}

.submit-btn {
  background-color: #203c8c;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.submit-btn:hover {
  background-color: #2044ac;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.cancel-btn {
  background-color: #e02424;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 2%;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.cancel-btn:hover {
  background-color: #c01c1c;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.error-messages {
  margin-top: 15px;
  color: red;
  text-align: left;
  transition: opacity 1s ease-out;
}

.error-messages ul {
  padding-left: 0;
  list-style-type: none;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
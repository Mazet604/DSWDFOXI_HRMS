<template>
    <AdminLayout>
      <div class="relative z-10">
        <!-- Profile Search Section -->
        <div class="w-full p-8 bg-white rounded-lg shadow-lg">
          <h1 class="mb-6 text-2xl font-bold">Employee Profile</h1>

          <div class="relative mb-4 search-bar">
            <div class="flex items-center">
              <span class="p-2 bg-gray-200 rounded-l">11-</span>
              <input
                type="text"
                class="w-full p-2 border rounded-r"
                placeholder="Enter 4-digit Employee ID..."
                v-model="searchQuery"
                @input="validateInput"
                maxlength="4"
              />
            </div>
          </div>

          <button class="p-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="search(searchQuery)">
            SEARCH
          </button>

          <!-- Error message if the empid is not found or invalid -->
          <div v-if="errorMessage" class="mt-4 text-red-600">
            {{ errorMessage }}
          </div>

          <!-- Profile Details Section (this could be a table or details you want to display) -->
          <div v-if="profileData" class="mt-6">
            <h2 class="text-xl font-bold">Employee Details:</h2>
            <p><strong>ID:</strong> {{ profileData.empid }}</p>
            <p><strong>Name:</strong> {{ profileData.emp_fname }} {{ profileData.emp_lname }}</p>
            <!-- Add more profile details as needed -->
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>

  <script setup>
  import { ref } from 'vue';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import axios from 'axios';

  const searchQuery = ref('');
  const errorMessage = ref('');
  const profileData = ref(null);

  // Function to validate the input: Only numbers are allowed
  const validateInput = () => {
    searchQuery.value = searchQuery.value.replace(/\D/g, ''); // Replace non-digit characters
  };

  // Search function for employee ID (using empid)
  const search = (query) => {
    if (!query.trim() || query.length !== 4) {
      errorMessage.value = 'Please enter a valid 4-digit Employee ID.';
      profileData.value = null;
      return;
    }

    const fullEmpId = `11-${query}`; // Construct the full Employee ID with the prefix

    axios
      .get(`/api/search-employee?empid=${fullEmpId}`)
      .then((response) => {
        if (response.data && response.data.empid) {
          profileData.value = response.data; // Populate profile details
          errorMessage.value = ''; // Clear any previous error
        } else {
          errorMessage.value = 'Employee not found.';
          profileData.value = null; // Clear previous data
        }
      })
      .catch((error) => {
        console.error('Error during search:', error);
        errorMessage.value = 'An error occurred while searching. Please try again.';
        profileData.value = null; // Clear previous data
      });

    showSuggestions.value = false;
  };
  </script>

  <style scoped>
  .search-bar {
    position: relative;
  }

  .text-red-600 {
    color: #e3342f;
  }
  </style>

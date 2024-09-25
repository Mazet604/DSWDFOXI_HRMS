<template>
    <AppLayout>
    <div>
      <h1>Admin Dashboard</h1>
      <!-- Admin dashboard content -->
    </div>
    </AppLayout>
  </template>
  
  <script>
import { App } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

  export default {
    name: 'AdminDashboard',

    components: {
        AppLayout
    },
  };
  </script>
  
  <style scoped>
  /* Admin dashboard styles */
  </style>
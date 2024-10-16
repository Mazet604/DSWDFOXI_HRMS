<template>
    <div class="flex min-h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="fixed top-0 left-0 z-20 flex flex-col w-64 h-full p-4 text-white bg-blue-900">
        <!-- Sidebar Background Image -->
        <img src="/images/bgthisd.png" alt="Sidebar Background" class="absolute inset-0 object-cover w-full h-full opacity-5" />
        <div class="relative z-10 flex flex-col flex-1">
          <div class="text-center">
            <img src="/images/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4 h-22" />
          </div>
          <nav class="flex-1">
            <ul class="custom-menu">
              <li
                :class="{ active: activeMenuItem === 'dashboard' || activeMenuItem === 'admin-dashboard' }"
                @click="navigateTo('dashboard', 'dashboard', 0)"
                class="flex items-center py-2 space-x-2 text-lg font-bold menu-item"
              >
                <i class="text-3xl fa-regular fa-circle-user"></i>
                <span>DASHBOARD</span>
              </li>
              <li
                :class="{ active: activeMenuItem === 'edit-profile' }"
                @click="navigateTo('edit-profile', 'edit-profile', 0)"
                class="flex items-center py-2 space-x-2 text-lg font-bold menu-item"
              >
                <span>Edit Profile</span>
              </li>
            </ul>
          </nav>
          <button @click="confirmLogout" class="px-2 py-2 mt-0 text-white bg-red-600 rounded w-30 hover:bg-red-700" style="font-size: 16px;">
            <i class="mr-2 fas fa-sign-out-alt"></i> Log Out
          </button>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="relative flex-1 p-8 ml-64 overflow-y-auto">
        <img src="/images/backgrounddswdnotop.png" alt="Main Background" class="fixed inset-0 object-cover w-full h-full opacity-100" />
        <div class="relative z-10">
          <slot></slot>
        </div>
      </main>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { router, usePage } from '@inertiajs/vue3'; // Import usePage to access $page

  const activeMenuItem = ref('');

  const navigateTo = (menuItem, routeName, tab = 0) => {
    activeMenuItem.value = menuItem;

    // Use the usePage hook to access the page properties
    const { props } = usePage(); // Use usePage() to access $page

    // Check if the logged-in user is an admin
    if (props.auth.user.user_type === 1 && routeName === 'dashboard') {
      // Redirect admin to the admin dashboard when clicking the dashboard link
      routeName = 'admin.dashboard';
    }

    router.visit(route(routeName), {
      preserveState: true,
      replace: true,
    });
  };

  const confirmLogout = () => {
    router.post(route('logout'));
  };
  </script>

  <style scoped>
  .custom-menu li.active {
    background: rgba(255, 255, 255, 0.1);
    color: yellow;
  }

  .menu-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
  }

  .menu-item:hover {
    background: rgba(255, 255, 255, 0.1);
  }

  .font-bold {
    font-weight: bold;
  }

  .text-lg {
    font-size: 1.125rem;
  }
  </style>

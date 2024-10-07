<template>
    <div class="flex min-h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="fixed top-0 left-0 h-full flex flex-col w-64 p-4 text-white bg-blue-900 z-20">
        <!-- Sidebar Background Image -->
        <img src="/images/bgthisd.png" alt="Sidebar Background" class="absolute inset-0 object-cover w-full h-full opacity-5" />
        <div class="relative z-10 flex flex-col flex-1">
          <div class="text-center">
            <img src="/images/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4 h-22" />
          </div>
          <nav class="flex-1">
            <div class="custom-accordion">
              <div class="custom-accordion-header" @click="toggleAccordion">
                <i class="fa-regular fa-circle-user text-3xl"></i>
                <span class="font-bold">ADMIN DASHBOARD</span>
                <i :class="{'rotate-180': isAccordionOpen}" class="fas fa-chevron-down"></i>
              </div>
              <div v-show="isAccordionOpen" class="custom-accordion-content">
                <ul class="custom-menu">
                  <li
                    :class="{ active: activeMenuItem === 'dashboard' }"
                    @click="navigateTo('dashboard', 'dashboard', 0)"
                    class="menu-item"
                  >
                    Dashboard
                  </li>
                  <li
                    :class="{ active: activeMenuItem === 'employees' }"
                    @click="navigateTo('employees', 'employees', 0)"
                    class="menu-item"
                  >
                    Employees
                  </li>
                  <li
                    :class="{ active: activeMenuItem === 'reports' }"
                    @click="navigateTo('reports', 'reports', 0)"
                    class="menu-item"
                  >
                    Reports
                  </li>
                </ul>
              </div>
            </div>
          </nav>
          <button @click="confirmLogout" class="w-30 px-2 py-2 mt-0 text-white bg-red-600 rounded hover:bg-red-700" style="font-size: 16px;">
            <i class="fas fa-sign-out-alt mr-2"></i> Log Out
          </button>
        </div>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-8 ml-64 overflow-y-auto relative">
        <img src="/images/backgrounddswdnotop.png" alt="Main Background" class="fixed inset-0 object-cover w-full h-full opacity-100" />
        <div class="relative z-10">
          <!-- This is where the page-specific content will be injected -->
          <slot></slot>
        </div>
      </main>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';

  const isAccordionOpen = ref(true);
  const activeMenuItem = ref('');

  const toggleAccordion = () => {
    isAccordionOpen.value = !isAccordionOpen.value;
  };

  const navigateTo = (menuItem, routeName, tab = 0) => {
    activeMenuItem.value = menuItem;
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
  .custom-accordion-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: transparent;
    cursor: pointer;
    border-bottom: 2px solid rgba(255, 252, 127);
    transition: background 0.3s ease-in-out;
    font-weight: bold;
  }

  .custom-menu li.active {
    background: rgba(255, 255, 255, 0.1);
    color: yellow;
  }

  .rotate-180 {
    transform: rotate(180deg);
  }
  </style>

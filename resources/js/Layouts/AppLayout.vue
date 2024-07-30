<template>
    <div class="flex min-h-screen bg-gray-100" @click="closeDropdown">
        <!-- Sidebar -->
        <aside class="relative w-64 bg-blue-900 text-white p-4 flex flex-col" @click.stop>
            <!-- Sidebar Background Image -->
            <img src="/images/bgthisd.png" alt="Sidebar Background" class="absolute inset-0 w-full h-full object-cover opacity-30" />
            <div class="relative z-10 flex flex-col flex-1">
                <div class="text-center">
                    <img src="/images/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4 h-22" />
                </div>
                <div class="search-bar mb-4">
                    <input type="text" placeholder="Search..." />
                    <i class="fas fa-search"></i>
                </div>
                <nav class="flex-1">
                    <div class="custom-accordion">
                        <div class="custom-accordion-header" @click="toggleAccordion">
                            <span class="font-bold">USER PROFILE</span>
                            <i :class="{'rotate-180': isAccordionOpen}" class="fas fa-chevron-down"></i>
                        </div>
                        <div v-show="isAccordionOpen" class="custom-accordion-content">
                            <ul class="custom-menu">
                                <li @click="navigateTo('dashboard')">
                                    <i class="fas fa-user mr-2"></i>
                                    Basic Info
                                </li>
                                <li @click="navigateTo('background')">
                                    <i class="fas fa-briefcase mr-2"></i>
                                    Background
                                </li>
                                <li @click="navigateTo('otherinfo')">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Other Info
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <button @click="confirmLogout" class="mt-4 py-2 px-4 rounded bg-red-600 text-white hover:bg-red-700">
                    Log-out
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="relative flex-1 p-8">
            <!-- Main Content Background Image -->
            <img src="/images/bgwhiteredblue.png" alt="Main Background" class="absolute inset-0 w-full h-full object-cover opacity-30" />
            <div class="relative z-10">
                <slot></slot>
            </div>
        </main>

        <!-- Logout Confirmation Modal -->
        <div v-if="showLogoutDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-4xl mb-4" style="color: red;"></i>
                        <h2 class="text-xl font-semibold mb-4">Are you sure you want to Log-out?</h2>
                    </div>
                    <div class="flex justify-center gap-4">
                        <button @click="hideLogoutDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="logout" class="py-2 px-4 rounded bg-red-600 text-white hover:bg-red-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const isAccordionOpen = ref(true); // Ensure the accordion is open by default for demonstration
const showLogoutDialog = ref(false);

const toggleAccordion = () => {
    isAccordionOpen.value = !isAccordionOpen.value;
};

const navigateTo = (routeName) => {
    router.visit(route(routeName), { preserveState: true }); // Use preserveState to keep the dropdown open
};

const confirmLogout = () => {
    showLogoutDialog.value = true;
};

const hideLogoutDialog = () => {
    showLogoutDialog.value = false;
};

const logout = () => {
    router.post(route('logout'));
};

const closeDropdown = () => {
    // Prevent the dropdown from closing when clicking on the sidebar or dropdown content
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
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: background 0.3s ease-in-out;
    font-weight: bold;
}
.custom-accordion-header:hover {
    background: rgba(255, 255, 255, 0.1);
}
.custom-accordion-content {
    background: transparent;
    padding: 0;
}
.custom-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.custom-menu li {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: transparent;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
    font-weight: bold;
}
.custom-menu li:hover {
    background: rgba(255, 255, 255, 0.1);
}
.custom-menu li i {
    margin-right: 0.5rem;
}
.rotate-180 {
    transform: rotate(180deg);
}
/* Additional CSS for the search bar */
.search-bar {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-bottom: 1rem;
}
.search-bar input {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    outline: none;
    background: transparent;
    color: white;
}
.search-bar input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}
.search-bar i {
    margin-left: 0.5rem;
    color: white;
}
/* Ensure the logout button stays at the bottom */
button {
    margin-top: auto;
}
</style>

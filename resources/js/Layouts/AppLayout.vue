<template>
    <div class="flex min-h-screen bg-gray-100" @click="closeDropdown">
        <!-- Sidebar -->
        <aside class="relative flex flex-col w-64 p-4 text-white bg-blue-900" @click.stop>
            <!-- Sidebar Background Image -->
            <img src="/images/bgthisd.png" alt="Sidebar Background" class="absolute inset-0 object-cover w-full h-full opacity-30" />
            <div class="relative z-10 flex flex-col flex-1">
                <div class="text-center">
                    <img src="/images/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4 h-22" />
                </div>
                <div class="mb-4 search-bar">
                    <input type="text" placeholder="Search..." v-model="searchQuery" @keyup.enter="search" />
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
                                    <i class="mr-2 fas fa-user"></i>
                                    Basic Info
                                </li>
                                <li @click="navigateTo('background')">
                                    <i class="mr-2 fas fa-briefcase"></i>
                                    Background
                                </li>
                                <li @click="navigateTo('otherinfo')">
                                    <i class="mr-2 fas fa-info-circle"></i>
                                    Other Info
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <button @click="confirmLogout" class="px-4 py-2 mt-4 text-white bg-red-600 rounded hover:bg-red-700">
                    Log-out
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="relative flex-1 p-8">
            <!-- Main Content Background Image -->
            <img src="/images/bgwhiteredblue.png" alt="Main Background" class="absolute inset-0 object-cover w-full h-full opacity-30" />
            <div class="relative z-10">
                <slot></slot>
            </div>
        </main>

        <!-- Logout Confirmation Modal -->
        <div v-if="showLogoutDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                <div class="p-4">
                    <div class="text-center">
                        <i class="mb-4 text-4xl fas fa-exclamation-triangle" style="color: red;"></i>
                        <h2 class="mb-4 text-xl font-semibold">Are you sure you want to Log-out?</h2>
                    </div>
                    <div class="flex justify-center gap-4">
                        <button @click="hideLogoutDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="logout" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const isAccordionOpen = ref(true); // Ensure the accordion is open by default for demonstration
const showLogoutDialog = ref(false);
const searchQuery = ref('');
const activeTab = ref(0);
const activeSubTab = ref(0);

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

const search = () => {
    const searchLower = searchQuery.value.toLowerCase();
    if (searchLower.includes('personal info')) {
        navigateTo('dashboard');
        activeTab.value = 0;
    } else if (searchLower.includes('address')) {
        navigateTo('dashboard');
        activeTab.value = 1;
    } else if (searchLower.includes('security')) {
        navigateTo('dashboard');
        activeTab.value = 2;
    } else if (searchLower.includes('family')) {
        navigateTo('background');
        activeTab.value = 0;
    } else if (searchLower.includes('education')) {
        navigateTo('background');
        activeTab.value = 1;
    } else if (searchLower.includes('organization')) {
        navigateTo('background');
        activeTab.value = 2;
    } else if (searchLower.includes('work experience')) {
        navigateTo('background');
        activeTab.value = 3;
    } else if (searchLower.includes('skills')) {
        navigateTo('background');
        activeTab.value = 4;
    } else if (searchLower.includes('references')) {
        navigateTo('background');
        activeTab.value = 5;
    } else if (searchLower.includes('cs eligibility')) {
        navigateTo('otherinfo');
        activeTab.value = 0;
    } else if (searchLower.includes('voluntary work')) {
        navigateTo('otherinfo');
        activeTab.value = 1;
    } else if (searchLower.includes('learning & development')) {
        navigateTo('otherinfo');
        activeTab.value = 2;
    } else if (searchLower.includes('recognition and distinctions')) {
        navigateTo('otherinfo');
        activeTab.value = 3;
    } else if (searchLower.includes('government id')) {
        navigateTo('otherinfo');
        activeTab.value = 4;
    } else if (searchLower.includes('other information')) {
        navigateTo('otherinfo');
        activeTab.value = 5;
    } else {
        alert('No matching tab found.');
    }
};

watch(activeTab, (newValue) => {
    // Additional logic if needed when the activeTab changes
    console.log('Active tab changed to:', newValue);
});
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

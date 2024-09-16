<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-full flex flex-col w-64 p-4 text-white bg-blue-900 z-20">
            <!-- Sidebar Background Image -->
            <img src="/images/bgthisd.png" alt="Sidebar Background" class="absolute inset-0 object-cover w-full h-full opacity-5" />
            <div class="relative z-10 flex flex-col flex-1">
                <div class="text-center">
                    <img src="/images/dswd-logo.png" alt="DSWD Logo" class="mx-auto mb-4 h-22" />
                </div>
                <div class="mb-4 search-bar relative">
                    <input
                        type="text"
                        placeholder="Search..."
                        v-model="searchQuery"
                        @input="filterSuggestions"
                        @keydown.down="highlightNext"
                        @keydown.up="highlightPrevious"
                        @keydown.enter="selectSuggestion"
                        @focus="showSuggestions = true"
                    />
                    <i class="fas fa-search"></i>
                    <ul v-if="showSuggestions && filteredSuggestions.length" class="suggestions-dropdown">
                        <li
                            v-for="(suggestion, index) in filteredSuggestions"
                            :key="index"
                            :class="{ 'highlighted': index === highlightedIndex }"
                            @click="search(suggestion)"
                            @mouseover="highlightedIndex = index"
                        >
                            {{ suggestion }}
                        </li>
                    </ul>
                </div>
                <nav class="flex-1">
                        <div class="custom-accordion">
                            <div class="custom-accordion-header" @click="toggleAccordion">
                                <i class="fa-regular fa-circle-user text-3xl"></i>
                                <span class="font-bold ">USER PROFILE</span>

                                <i :class="{'rotate-180': isAccordionOpen}" class="fas fa-chevron-down"></i>
                            </div>
                            <div v-show="isAccordionOpen" class="custom-accordion-content">
                                <ul class="custom-menu">
                                        <li
                                            :class="{ active: activeMenuItem === 'basicInfo' }"
                                            @click="navigateTo('basicInfo', 'dashboard', 0)"
                                            class="menu-item"
                                        >
                                            BASIC INFO
                                        </li>
                                        <li
                                            :class="{ active: activeMenuItem === 'background' }"
                                            @click="navigateTo('background', 'background', 0)"
                                            class="menu-item"
                                        >
                                            BACKGROUND
                                        </li>
                                        <li
                                            :class="{ active: activeMenuItem === 'otherInfo' }"
                                            @click="navigateTo('otherInfo', 'otherinfo', 0)"
                                            class="menu-item"
                                        >
                                            OTHER INFO
                                        </li>
                                    </ul>

                            </div>
                        </div>
                    </nav>


                    <button @click="downloadPDS" class="w-30 px-2 py-2 mt-4 text-white bg-blue-700 rounded hover:bg-blue-600" style="font-size: 16px;">
                        <i class="fas fa-download mr-2"></i> Personal Data Sheet
                    </button>
                    <br>
                    <button @click="confirmLogout" class="w-30 px-2 py-2 mt-0 text-white bg-red-600 rounded hover:bg-red-700" style="font-size: 16px;">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 ml-64 overflow-y-auto relative">
            <!-- Main Content Background Image -->
            <img src="/images/backgrounddswdnotop.png" alt="Main Background" class="fixed inset-0 object-cover w-full h-full opacity-100" />
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
        <!-- New Download PDS Modal -->
    <div v-if="showPdsDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
            <div class="p-4">
                <div class="text-center">
                    <h2 class="mb-4 text-xl font-semibold">Download Personal Data Sheet</h2>
                </div>
                <div class="flex flex-col gap-4">
                    <button @click="downloadPDS(1)" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Download Page 1</button>
                    <button @click="downloadPDS(2)" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Download Page 2</button>
                    <button @click="downloadPDS(3)" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Download Page 3</button>
                    <button @click="downloadPDS(4)" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Download Page 4</button>
                    <button @click="downloadPDS(5)" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Download All Pages</button>
                </div>
                <div class="mt-4 flex justify-center">
                    <button @click="hidePdsDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Download Modal -->
    <div v-if="showModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="downloadModalLabel">Downloading File</h5>
                        <button type="button" class="close" @click="showModal = false" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalMessage">
                        Please wait, your file is being downloaded...
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- Download Result Modal -->
        <div v-if="showResultModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">{{ downloadStatus === 'success' ? 'Download Failed' : 'Download Successful' }}</h5>
                        <button type="button" class="close" @click="showResultModal = false" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ downloadStatus === 'success' ? 'There was an error downloading your file. Please try again.' : 'Your file has been downloaded successfully.' }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showResultModal = false">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const isAccordionOpen = ref(true); // Ensure the accordion is open by default for demonstration
const showLogoutDialog = ref(false);
const showModal = ref(false);
const showResultModal = ref(false);
const downloadStatus = ref('');
const showPdsDialog = ref(false);
const searchQuery = ref('');
const activeTab = ref(0);
const activeSubTab = ref(0);
const activeMenuItem = ref(''); // Initialize with empty

const suggestions = [
    'Personal Info',
    'Address',
    'Security',
    'Family',
    'Education',
    'Organization',
    'Work Experience',
    'Skills',
    'References',
    'Eligibility',
    'Voluntary',
    'Learning',
    'Recognition',
    'Government',
    'Other',
];

const filteredSuggestions = ref([]);
const showSuggestions = ref(false);
const highlightedIndex = ref(-1);

const filterSuggestions = () => {
    const query = searchQuery.value.toLowerCase();
    if (query) {
        filteredSuggestions.value = suggestions.filter(suggestion =>
            suggestion.toLowerCase().includes(query)
        );
    } else {
        filteredSuggestions.value = [];
    }
    highlightedIndex.value = -1;
};

const highlightNext = () => {
    if (highlightedIndex.value < filteredSuggestions.value.length - 1) {
        highlightedIndex.value += 1;
    }
};

const highlightPrevious = () => {
    if (highlightedIndex.value > 0) {
        highlightedIndex.value -= 1;
    }
};

const selectSuggestion = () => {
    if (highlightedIndex.value >= 0) {
        search(filteredSuggestions.value[highlightedIndex.value]);
    } else {
        search(searchQuery.value);
    }
};

const toggleAccordion = () => {
    isAccordionOpen.value = !isAccordionOpen.value;
};


const navigateTo = (menuItem, routeName, tab = 0, subTab = 0) => {
    activeMenuItem.value = menuItem; // Set the active menu item
    // Use Inertia.js to navigate smoothly without refreshing the page
    router.visit(route(routeName), {
        preserveState: true, // Preserve component state to prevent full refresh
        replace: true, // Optionally, replace history to avoid multiple back entries
        onSuccess: () => {
            activeTab.value = tab;
            activeSubTab.value = subTab;
        },
    });
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
    showSuggestions.value = false;
};

const search = (query) => {
    searchQuery.value = query;
    const searchLower = query.toLowerCase();
    if (searchLower.includes('personal info')) {
        navigateTo('dashboard', 0, 0);
    } else if (searchLower.includes('address')) {
        navigateTo('dashboard', 0, 1);
    } else if (searchLower.includes('security')) {
        navigateTo('dashboard', 0, 2);
    } else if (searchLower.includes('family')) {
        navigateTo('background', 1, 0);
    } else if (searchLower.includes('education')) {
        navigateTo('background', 1, 1);
    } else if (searchLower.includes('organization')) {
        navigateTo('background', 1, 2);
    } else if (searchLower.includes('work experience')) {
        navigateTo('background', 1, 3);
    } else if (searchLower.includes('skills')) {
        navigateTo('background', 1, 4);
    } else if (searchLower.includes('references')) {
        navigateTo('background', 1, 5);
    } else if (searchLower.includes('eligibility')) {
        navigateTo('otherinfo', 2, 0);
    } else if (searchLower.includes('voluntary')) {
        navigateTo('otherinfo', 2, 1);
    } else if (searchLower.includes('learning')) {
        navigateTo('otherinfo', 2, 2);
    } else if (searchLower.includes('recognition')) {
        navigateTo('otherinfo', 2, 3);
    } else if (searchLower.includes('government')) {
        navigateTo('otherinfo', 2, 4);
    } else if (searchLower.includes('other')) {
        navigateTo('otherinfo', 2, 5);
    } else {
        alert('No matching tab found.');
    }
    showSuggestions.value = false;
};

const showPdsDialogFn = () => {
    showPdsDialog.value = true;
};

const hidePdsDialog = () => {
    showPdsDialog.value = false;
};

const showPDSprogress = () => {
    showModal.value = true; // Show download in progress modal
    console.log("Download modal should be visible");
};

const choosePDS = () => {
    showPdsDialogFn();
};

// Download PDS pages
const downloadPDS = async (page) => {
    
    hidePdsDialog(); // Hide the modal after download
    try {
        showPDSprogress();
        let url = '/download-pds';
        if (page !== 'all') {
            url += `/${page}`; // Append the page number to the URL
        }

        const response = await axios.get(url, {
            responseType: 'blob', // Important for PDF files
        });

        const link = document.createElement('a');
        const blob = new Blob([response.data], { type: 'application/pdf' });
        const objectURL = URL.createObjectURL(blob);

        link.href = objectURL;
        link.download = page === 'all' ? 'PDS_All_Pages.pdf' : `PDS_Page_${page}.pdf`;
        link.click();
        URL.revokeObjectURL(objectURL);
        link.remove();

    } catch (error) {
        console.error('Error downloading PDS:', error);
    }finally {
        // Hide the progress modal and show the result modal
        showModal.value = false;
        showResultModal.value = true;
    }
};

watch(activeTab, (newValue) => {
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
    border-bottom: 2px solid rgba(255, 252, 127);
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
    justify-content: center;
    align-items: center;
    padding: 0.75rem 1rem;
    background: transparent;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
    font-weight: bold;
    text-transform: uppercase;
    color: white;
}

/* Style when item is hovered */
.custom-menu li:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* Style when item is clicked/active */
.custom-menu li.active {
    background: rgba(255, 255, 255, 0.1);
    color: yellow;
}

.rotate-180 {
    transform: rotate(180deg);
}

.centered-text {
    margin: 0 auto;  /* centers the text horizontally */
    padding: 10px 0;  /* optional padding to add vertical space */
    text-align: center;  /* aligns text to the center */
    list-style-type: none;  /* removes the bullet points */
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
.suggestions-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 0.375rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    margin-top: 0.25rem;
    padding: 0;
    list-style: none;
}

.suggestions-dropdown li {
    padding: 0.5rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    color: black; /* Ensures text is visible */
}
.suggestions-dropdown li:hover,
.suggestions-dropdown li.highlighted {
    background-color: #f5f5f5;
    color: black; /* Ensures highlighted text is also visible */
}

/* Ensure the logout button stays at the bottom */
button {
    margin-top: auto;
    align-items: center;
}
</style>

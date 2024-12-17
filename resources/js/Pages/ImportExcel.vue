<template>
    <AdminLayout>
        <!-- ADD EMPLOYEE Tab -->
        <div class="flex justify-center">
            <div class="w-2/4 p-8 bg-white border-4 rounded-lg shadow-lg">
                <h1 class="pb-2 mb-4 text-3xl font-bold text-blue-800 border-b border-yellow-200">
                    CREATE EMPLOYEE ACCOUNT
                </h1>

                <!-- Create Account Form -->
                <form @submit.prevent="createAccount" class="form">
                    <div class="form-group">
                        <label for="empid" class="block mb-2 font-semibold">Employee ID:</label>
                        <input
                            v-model="newAccount.empid"
                            type="text"
                            id="empid"
                            placeholder="11-XXXX"
                            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="position" class="block mb-2 font-semibold">Position:</label>
                        <input
                            v-model="newAccount.position"
                            type="text"
                            id="position"
                            placeholder="Enter Position"
                            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="empmail" class="block mb-2 font-semibold">Email:</label>
                        <input
                            v-model="newAccount.empmail"
                            type="email"
                            id="empmail"
                            placeholder="Enter Email"
                            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="empuser" class="block mb-2 font-semibold">Username:</label>
                        <input
                            v-model="newAccount.empuser"
                            type="text"
                            id="empuser"
                            placeholder="Enter Username"
                            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="emppass" class="block mb-2 font-semibold">Password:</label>
                        <input
                            v-model="newAccount.emppass"
                            type="password"
                            id="emppass"
                            placeholder="Enter Password"
                            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                        />
                    </div>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 mt-4 font-semibold text-white bg-blue-800 rounded-md hover:bg-blue-700"
                    >
                        CREATE ACCOUNT
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="showSuccessDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-lg">
                <div class="p-6">
                    <div class="text-center">
                        <i class="mb-4 text-6xl fas fa-check-circle" style="color: green;"></i>
                        <h2 class="mb-4 text-2xl font-semibold">Account Created Successfully!</h2>
                        <p class="mb-6 text-gray-600">The new employee account has been created successfully.</p>
                    </div>
                    <div class="text-center">
                        <button
                            @click="hideSuccessDialog"
                            class="px-8 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800"
                        >
                            BACK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
    name: "AdminDashboard",

    components: {
        AdminLayout,
    },

    data() {
        return {
            newAccount: {
                empid: "",
                empmail: "",
                empuser: "",
                emppass: "",
                position: "",
            },
            showSuccessDialog: false, // To show or hide the success modal
        };
    },

    methods: {
        // Create an account and show success modal
        async createAccount() {
            try {
                const response = await axios.post("/create-account", this.newAccount);
                this.showSuccessDialog = true; // Show success modal
                this.resetForm(); // Clear form fields
            } catch (error) {
                alert("Error creating account: ID, Email, or Username already exists.");
            }
        },

        // Hide the success modal
        hideSuccessDialog() {
            this.showSuccessDialog = false;
        },

        // Reset form fields
        resetForm() {
            this.newAccount = {
                empid: "",
                empmail: "",
                empuser: "",
                emppass: "",
                position: "",
            };
        },
    },
};
</script>

<style scoped>
/* General Form Styles */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    color: #444;
}

button {
    transition: background-color 0.3s;
}

/* Modal Styling */
.fixed {
    position: fixed;
}

.bg-opacity-75 {
    background-color: rgba(0, 0, 0, 0.75);
}

.rounded-lg {
    border-radius: 8px;
}

.shadow-lg {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.text-center {
    text-align: center;
}

.text-gray-600 {
    color: #718096;
}
</style>

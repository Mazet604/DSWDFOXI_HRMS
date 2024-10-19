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

          <div v-if="errorMessage" class="mt-4 text-red-600">
            {{ errorMessage }}
          </div>

          <div v-if="profileData" class="mt-6">
            <h2 class="text-xl font-bold">Employee Details:</h2>
            <p><strong>ID:</strong> {{ profileData.empid }}</p>
            <p><strong>Name:</strong> {{ profileData.emp_fname }} {{ profileData.emp_lname }}</p>
            <p><strong>Position:</strong> {{ profileData.emp_position }} </p>

            <!-- Edit Button -->
            <button class="p-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700" @click="showEditModal">
              EDIT
            </button>
          </div>
        </div>
        <div v-if="isEditModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="modal">
            <h2 class="mb-4 text-xl font-bold">Edit Employee Details</h2>

            <!-- Page 1 -->
            <div class="grid grid-cols-2 gap-4">
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_lname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_fname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_mname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name Extension</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_ext" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" class="w-full p-2 border rounded" v-model="profileData.emp_dob" />
             </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Place of Birth</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_pob" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Sex</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_sex" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Civil Status</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_civ_stat" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Height</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_height" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Weight</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_weight" />
              </div>
              <!-- Page 2 -->
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Blood Type</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_blood" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">GSIS ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.pb_no" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">PAG-IBIG ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.pgbg_id" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">PhilHealth ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ph_lid" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">SSS ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.sss_num" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">TIN ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.tin_id" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Agency Employee NO.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 3 - Residential Address -->
            <div v-if="currentPage === 3">
            <h2 class="mb-4 text-lg font-semibold">Residential Address</h2>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialRegion" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialProvince" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialCity" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialBarangay" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialZipcode" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialVillage" />
                </div>
                <div class="col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.residentialStreet" />
                </div>
            </div>
            </div>
            <!-- Page 4 - Permanent Address -->
            <div v-if="currentPage === 4">
            <h2 class="mb-4 text-lg font-semibold">Permanent Address</h2>
            <div class="gap-4 mb-6 ">
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentRegion" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentProvince" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentCity" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentBarangay" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentZipcode" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentVillage" />
                </div>
                <div class="col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentStreet" />
                </div>
            </div>
            </div>
              <!-- Page 5 -->
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Telephone NO.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Mobile NO.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Email Address(if any)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emailadd" />
              </div>
              <!-- Page 6 -->
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Spouse's Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Spouse's First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Spouse's Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name Extension</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Occupation</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Employer/Business Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Address</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Telephone NO.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Father's Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Father's First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Father's Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name Extension</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Mother's Maiden Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Mother's Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Mother's First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Mother's Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 7 -->
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name of Children(Write full name and list all)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">Date of Birth</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 8 -->
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">Educational Background</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 9 -->
              <div v-if="currentPage === 9">
                <label class="block mb-1 text-sm font-medium text-gray-700">Civil Service Eligibility</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 10 -->
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">Work Experience</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 11 -->
              <div v-if="currentPage === 11">
                <label class="block mb-1 text-sm font-medium text-gray-700">Voluntary Work</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 12 -->
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">Learning & Development</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <!-- Page 13 -->
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">Other Information</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
            </div>

            <!-- Pagination Buttons -->
            <div class="mt-6 text-right">
              <button v-if="currentPage > 1" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="prevPage">Previous</button>
              <button v-if="currentPage < totalPages" class="px-4 py-2 ml-4 text-white bg-blue-600 rounded hover:bg-blue-700" @click="nextPage">Next</button>
            </div>

            <!-- Modal Buttons -->
            <div class="mt-6 text-right">
              <button class="px-4 py-2 mr-4 text-white bg-red-600 rounded hover:bg-red-700" @click="hideEditModal">
                CANCEL
              </button>
              <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="saveProfile">
                SAVE
             </button>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>

<script>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import axios from 'axios';
import DashboardScripts from './Scripts/DashboardScripts.vue';
import Dashboard from '@/Pages/Dashboard.vue';
import Background from '@/Pages/Background.vue';
import OtherInfo from '@/Pages/OtherInfo.vue';

export default {
  components: {
    AdminLayout,
    DashboardScripts,
    Dashboard,
    Background,
    OtherInfo
  },
  data() {
    return {
      searchQuery: '',
      errorMessage: '',
      profileData: null,
      isEditModalVisible: false,
      currentPage: 1,
      totalPages: 13,
      isEditing: false,
      showUpdateDialog: false,
      showSuccessDialog: false
    };
  },
  methods: {
    validateInput() {
      this.searchQuery = this.searchQuery.replace(/\D/g, ''); // Replace non-digit characters
    },
    search(query) {
      if (!query.trim() || query.length !== 4) {
        this.errorMessage = 'Please enter a valid 4-digit Employee ID.';
        this.profileData = null;
        return;
      }

      const fullEmpId = `11-${query}`; // Construct the full Employee ID with the prefix

      axios
        .get(`/api/search-employee?empid=${fullEmpId}`)
        .then((response) => {
          if (response.data && response.data.empid) {
            this.profileData = response.data; // Populate profile details
            this.errorMessage = ''; // Clear any previous error
          } else {
            this.errorMessage = 'Employee not found.';
            this.profileData = null; // Clear previous data
          }
        })
        .catch((error) => {
          console.error('Error during search:', error);
          this.errorMessage = 'Invalid ID.';
          this.profileData = null; // Clear previous data
        });
    },
    showEditModal() {
      this.isEditModalVisible = true;
      this.currentPage = 1; // Reset to the first page when the modal is opened
    },
    hideEditModal() {
      this.isEditModalVisible = false;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    saveProfile() {
     axios.patch(`/employee/updateProfile/${this.profileData.empID}`, this.profileData)
        .then(() => {
        this.isEditing = false; // End editing mode
        this.showUpdateDialog = false; // Close confirmation dialog
        this.showSuccessDialog = true; // Show success message
        this.fetchPersonalInfo(); // Re-fetch the updated employee data
        })
        .catch(error => {
        console.error('Error updating profile:', error); // Handle error during the update
        });
    },
  }
};
</script>


<style scoped>
  .search-bar {
    position: relative;
  }

  .text-red-600 {
    color: #e3342f;
  }

  .fixed {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.7);
  }


  .modal {
    width: 95%;
    max-width: 810px;
    height: auto;
    padding: 2.3rem;
    background-color: white;
    border-radius: 0.5rem;
  }

  /* Keep buttons responsive */
  button {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 0.375rem;
  }

  /* Adjust input field size for larger modal */
  input {
    font-size: 1rem;
    padding: 0.8rem;
    width: 100%;
  }

  .grid-cols-2 input {
    padding: 0.9rem;
  }
</style>

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
                <h3 class="mb-4 text-lg font-semibold">Residential Address</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialRegion" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                         <input class="w-full p-2 border rounded" v-model="profileData.residentialProvince" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialCity" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialBarangay" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialZipcode" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialVillage" />
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialStreet" />
                </div>
            </div>
            </div>
            <!-- Page 4 - Permanent Address -->
            <div v-if="currentPage === 4">
            <h2 class="mb-4 text-lg font-semibold">Permanent Address</h2>
            <div class="gap-4 mb-6 ">
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentRegion2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentProvince2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentCity2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentBarangay2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentZipcode2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentVillage2" />
                </div>
                <div class="col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentStreet2" />
                </div>
            </div>
            </div>
            <!-- Page 5 - Background - Family -->
            <div v-if="currentPage === 5">
            <h2 class="mb-4 text-lg font-semibold">Spouse</h2>
            <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_lname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_fname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_mname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Suffix</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_xname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Occupation</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_occup" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Employer's/Business Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_office" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Address</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_busadd" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Tel No.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_tel" />
              </div>
              <!-- <h2 class="mb-4 text-lg font-semibold">Father</h2>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Suffix</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <h2 class="mb-4 text-lg font-semibold">Mother</h2>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Maiden Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div> -->
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
//new added 11/22
            this.fetchEmployeeAddress(response.data.emp_count); // Pass emp_count for address fetching
//new added 11/25
            this.fetchEmployeeAddress2(response.data.emp_count); // Fetch permanent address
// Fetch spouse details
            this.fetchSpouseDetails(response.data.emp_count); // Spouse details
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

    fetchEmployeeAddress(emp_count) {
            axios
                .get(`/api/get-employee-address?emp_count=${emp_count}`)
                .then((response) => {
                    if (response.data) {
                        // Bind address data to profileData object
                         this.profileData.residentialRegion = response.data.emp_region;
                         this.profileData.residentialProvince = response.data.emp_prov;
                         this.profileData.residentialCity = response.data.emp_city;
                         this.profileData.residentialBarangay = response.data.emp_brgy;
                         this.profileData.residentialZipcode = response.data.emp_zip;
                         this.profileData.residentialVillage = response.data.emp_subd;
                         this.profileData.residentialStreet = response.data.emp_house;
                    }
                })
                .catch((error) => {
                    console.error('Error fetching employee address:', error);
                });
    },
    fetchEmployeeAddress2(emp_count) {
        axios
            .get(`/api/get-employee-address2?emp_count=${emp_count}`) // Correct endpoint
            .then((response) => {
                if (response.data) {
                    // Bind permanent address data to profileData object
                    this.profileData.permanentRegion2 = response.data.Region2;
                    this.profileData.permanentProvince2 = response.data.Province2;
                    this.profileData.permanentCity2 = response.data.City2;
                    this.profileData.permanentBarangay2 = response.data.Barangay2;
                    this.profileData.permanentZipcode2 = response.data.zipcode2;
                    this.profileData.permanentVillage2 = response.data.villsub2;
                    this.profileData.permanentStreet2 = response.data.block2;
                }
            })
            .catch((error) => {
                console.error("Error fetching permanent address:", error);
            });
    },

    fetchSpouseDetails(emp_count) {
        axios
            .get(`/api/get-spouse-details?emp_count=${emp_count}`)
            .then((response) => {
                if (response.data) {
                    this.profileData.spouse_lname = response.data.spouseSurname;
                    this.profileData.spouse_fname = response.data.spouseFirstName;
                    this.profileData.spouse_mname = response.data.spouseMiddleName;
                    this.profileData.spouse_xname = response.data.spouseExtName;
                    this.profileData.spouse_occup = response.data.spouseOccupation;
                    this.profileData.spouse_office = response.data.spouseBusinessName;
                    this.profileData.spouse_busadd = response.data.spouseBusinessAddress;
                    this.profileData.spouse_tel = response.data.spouseTelNo;
                }
            })
            .catch((error) => {
                console.error("Error fetching spouse details:", error);
            });
    },

    showEditModal() {
      this.isEditModalVisible = true;
      this.currentPage = 1;
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
    axios
        .patch(`/employee/updateEditProfile/${this.profileData.empid}`, this.profileData)
        .then(() => {
        this.isEditing = false;
        this.showUpdateDialog = false;
        this.showSuccessDialog = true;
        this.hideEditModal(); // Close the modal on successful save
        })
        .catch((error) => {
        console.error('Error updating profile:', error);
        });
        // window.location.reload(); // Forces the page to reload
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

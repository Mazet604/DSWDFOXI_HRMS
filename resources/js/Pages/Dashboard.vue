<template>
  <AppLayout>
    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div class="relative col-span-1">
        <div class="relative group" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
          <img alt="Profile Picture" class="w-full rounded-lg" height="300" src="/images/profile-picture.webp" width="300" :class="{ 'blur-md': !isUnblurred }" />
          <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300" :class="{ 'opacity-0': !isHovered, 'opacity-100': isHovered }">
            <button @click="toggleBlur" class="p-2 bg-gray-800 bg-opacity-75 rounded-full">
              <i class="text-4xl text-white fas fa-eye"></i>
            </button>
          </div>
        </div>
        <Button label="Upload Photo" class="w-full py-2 mt-4 text-white rounded-lg bg-gradient-to-r from-pink-500 to-purple-500" />
      </div>
      <div class="col-span-1 md:col-span-2">
        <h1 class="mb-4 text-3xl font-bold lg:text-5xl">{{ fullName }}</h1>
        <p class="mb-4 text-gray-600">{{ empPosition }}</p>
        <div class="border-box">
          <TabView v-model:activeIndex="activeTab" class="no-background">
            <TabPanel header="PERSONAL INFO" :active="activeSubTab === 'personal'">
              <!-- Personal Info Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">USER NAME</label>
                  <input type="text" class="input-field text-color" v-model="fields.empUser" disabled />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYEE ID</label>
                  <input type="text" class="input-field text-color" v-model="fields.empID" disabled />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                  <input type="text" class="input-field" v-model="fields.firstName" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                  <input type="text" class="input-field" v-model="fields.middleName" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME</label>
                  <input type="text" class="input-field" v-model="fields.lastName" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">SUFFIX</label>
                  <select class="input-field" v-model="fields.suffix" :disabled="!isEditing">
                    <option v-for="option in extOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CITIZENSHIP</label>
                  <input type="text" class="input-field" v-model="fields.citizenship" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BIRTHDAY</label>
                  <input type="date" class="input-field" v-model="fields.birthday" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PLACE OF BIRTH</label>
                  <input type="text" class="input-field" v-model="fields.placeOfBirth" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">SEX</label>
                  <select class="input-field" v-model="fields.sex" :disabled="!isEditing">
                    <option v-for="option in sexOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CIVIL STATUS</label>
                  <select class="input-field" v-model="fields.civilStatus" :disabled="!isEditing">
                    <option v-for="option in civilStatusOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">HEIGHT(M)</label>
                  <input type="number" step="0.01" class="input-field" v-model="fields.height" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">WEIGHT(KG)</label>
                  <input type="number" class="input-field" v-model="fields.weight" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BLOOD TYPE</label>
                  <select class="input-field" v-model="fields.bloodType" :disabled="!isEditing">
                    <option v-for="option in bloodTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
              </div>
            </TabPanel>
            <TabPanel header="ADDRESS" :active="activeSubTab === 'address'">
              <!-- Address Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">COUNTRY</label>
                  <input type="text" class="input-field" v-model="fields.country" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">REGION</label>
                  <select class="input-field" v-model="fields.selectedRegion" :disabled="!isEditing">
                    <option v-for="option in selectedRegionOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PROVINCE</label>
                  <select class="input-field" v-model="fields.selectedProvince" :disabled="!isEditing">
                    <option v-for="option in selectedProvinceOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CITY</label>
                  <select class="input-field" v-model="fields.selectedCity" :disabled="!isEditing">
                    <option v-for="option in selectedCityOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">ZIP CODE</label>
                  <input type="text" class="input-field" v-model="fields.zipcode" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                  <input type="text" class="input-field" v-model="fields.block" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">VILLAGE SUBDIVISION</label>
                  <input type="text" class="input-field" v-model="fields.villsub" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BARANGAY</label>
                  <select class="input-field" v-model="fields.selectedBarangay" :disabled="!isEditing">
                    <option v-for="option in selectedBarangayOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
              </div>
            </TabPanel>
            <TabPanel header="SECURITY & CONTACT DETAILS" :active="activeSubTab === 'security'">
              <!-- Security & Contact Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">MOBILE NUMBER</label>
                  <input type="text" class="input-field" v-model="fields.mobilenum" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                  <input type="text" class="input-field" v-model="fields.telnum" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">EMAIL ADDRESS</label>
                  <input type="text" class="input-field" v-model="fields.emailadd" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PASSWORD</label>
                  <input :type="showPassword ? 'text' : 'password'" class="input-field" v-model="fields.pass" :disabled="!isEditing" />
                  <div class="mt-2">
                    <input type="checkbox" id="showPassword" v-model="showPassword" :disabled="!isEditing">
                    <label for="showPassword" class="ml-2 text-sm font-bold text-gray-700">Show Password</label>
                  </div>
                </div>
              </div>
            </TabPanel>
          </TabView>
        </div>
        <Button label="UPDATE" v-if="!isEditing" class="float-right px-8 py-2 mt-6 text-white bg-green-500 rounded-lg update-button" @click="toggleEditing" />
        <div v-if="isEditing" class="float-right mt-6 space-x-4">
          <Button label="CANCEL" class="px-8 py-2 text-white rounded-lg custom-cancel-button" @click="cancelEditing" />
          <Button label="SAVE" class="px-8 py-2 text-white bg-blue-500 rounded-lg update-button" @click="confirmUpdate" />
        </div>
      </div>
    </div>

    <!-- Update Confirmation Modal -->
    <div v-if="showUpdateDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg">
        <div class="p-4">
          <div class="text-center">
            <i class="mb-4 text-4xl fas fa-exclamation-triangle" style="color: red;"></i>
            <h2 class="mb-4 text-xl font-semibold">Are you sure you want to update?</h2>
            <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
          </div>
          <div class="flex justify-center gap-4">
            <button @click="hideUpdateDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
              Cancel
            </button>
            <button @click="saveProfile" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Update Success Modal -->
    <div v-if="showSuccessDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg">
        <div class="p-4">
          <div class="text-center">
            <i class="mb-4 text-4xl fas fa-check-circle" style="color: green;"></i>
            <h2 class="mb-4 text-xl font-semibold">Updated Successfully!</h2>
            <p class="mb-4">Details have been successfully updated. Press 'Back' to continue.</p>
          </div>
          <div class="flex justify-center">
            <button @click="hideSuccessDialog" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
              Back
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import axios from 'axios';
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

export default {
  components: {
    AppLayout, Button, TabView, TabPanel
  },
  data() {
    return {
      fullName: '',
      empPosition: '',
      fields: {
        empUser: '',
        empID: '',
        firstName: '',
        middleName: '',
        lastName: '',
        suffix: '',
        citizenship: '',
        birthday: '',
        placeOfBirth: '',
        sex: '',
        civilStatus: '',
        height: '',
        weight: '',
        bloodType: '',
        zipcode: '',
        block: '',
        villsub: '',
        mobilenum: '',
        telnum: '',
        emailadd: '',
        pass: '',
        selectedRegion:'',
        selectedProvince:'',
        selectedCity:'',
        selectedBarangay:'',
        country:'',
      },
      isEditing: false,
      originalFields: {}, // Added to store original data before editing
      errorMessage: '',
      showUpdateDialog: false,
      showSuccessDialog: false,
      sexOptions: [],
      civilStatusOptions:[],
      bloodTypeOptions:[],
      extOptions:[],
      selectedRegionOptions:[],
      selectedProvinceOptions:[],
      selectedCityOptions:[],
      selectedBarangayOptions:[],
      activeTab: 0,
      activeSubTab: '',
      searchQuery: '',
    };
  },
  methods: {
    async fetchSexOptions() {
      try {
        const response = await fetch('/dropdown/sex-options');
        if (!response.ok) {
          throw new Error('Failed to fetch sex options');
        }
        this.sexOptions = await response.json();
      } catch (error) {
        console.error(error);
      }
    },
    async fetchCivilStatusOptions() {
      try {
        const response = await fetch('/dropdown/civilstatus-options');
        if (!response.ok) {
          throw new Error('Failed to fetch civil status options');
        }
        this.civilStatusOptions = await response.json();
      } catch (error) {
        console.error(error);
      }
    },
    async fetchBloodTypeOptions() {
      try {
        const response = await fetch('/dropdown/bloodtype-options');
        if (!response.ok) {
          throw new Error('Failed to fetch blood type options');
        }
        this.bloodTypeOptions = await response.json();
      } catch (error) {
        console.error(error);
      }
    },
    async fetchExtOptions() {
      try {
        const response = await fetch('/dropdown/ext-options');
        if (!response.ok) {
          throw new Error('Failed to fetch suffix options');
        }
        this.extOptions = await response.json();
      } catch (error) {
        console.error(error);
      }
    },

    async fetchSelectedRegionOptions() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/selectedregion-options');
        this.selectedRegionOptions = response.data;
      } catch (error) {
        this.errorMessage = 'Failed to load regions.';
      }
    },

    async fetchSelectedProvinceOptions() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/selectedprovince-options');
        this.selectedProvinceOptions = response.data;
      } catch (error) {
        this.errorMessage = 'Failed to load provinces.';
      }
    },

    async fetchSelectedCityOptions() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/selectedcity-options');
        this.selectedCityOptions = response.data;
      } catch (error) {
        this.errorMessage = 'Failed to load cities.';
      }
    },

    async fetchSelectedBarangayOptions() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/selectedbarangay-options');
        this.selectedBarangayOptions = response.data;
      } catch (error) {
        this.errorMessage = 'Failed to load barangays.';
      }
    },


    async fetchFullName() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/employee/fullname');
        this.fullName = response.data.fullName;
        this.empPosition = response.data.empPosition;
      } catch (error) {
        if (error.response && error.response.status === 500) {
          this.errorMessage = 'Internal Server Error. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again.';
        }
      }
    },
    async fetchPersonalInfo() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/employee/PersonalInfo');
        this.fields.empUser = response.data.empUser;
        this.fields.empID = response.data.empID;
        this.fields.firstName = response.data.firstName;
        this.fields.middleName = response.data.middleName;
        this.fields.lastName = response.data.lastName;
        this.fields.suffix = response.data.suffix;
        this.fields.citizenship = response.data.citizenship;
        this.fields.birthday = response.data.birthday;
        this.fields.placeOfBirth = response.data.placeOfBirth;
        this.fields.sex = response.data.sex;
        this.fields.civilStatus = response.data.civilStatus;
        this.fields.height = response.data.height;
        this.fields.weight = response.data.weight;
        this.fields.bloodType = response.data.bloodType;
      } catch (error) {
        if (error.response && error.response.status === 500) {
          this.errorMessage = 'Internal Server Error. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again.';
        }
      }
    },

    async fetchAddress() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/Address');
        this.fields.selectedRegion = response.data.selectedRegion;
        this.fields.selectedProvince = response.data.selectedProvince;
        this.fields.selectedCity = response.data.selectedCity;
        this.fields.selectedBarangay = response.data.selectedBarangay;
        this.fields.country = response.data.country;
      } catch (error) {
        if (error.response && error.response.status === 500) {
          this.errorMessage = 'Internal Server Error. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again.';
        }
      }
    },
    async fetchSecurityandContact() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/employee/SecurityandContact');
        this.fields.mobilenum = response.data.mobilenum;
        this.fields.telnum = response.data.telnum;
        this.fields.emailadd = response.data.emailadd;
        this.fields.pass = response.data.pass;
      } catch (error) {
        if (error.response && error.response.status === 500) {
          this.errorMessage = 'Internal Server Error. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again.';
        }
      }
    },
    toggleEditing() {
      if (!this.isEditing) {
        this.originalFields = JSON.parse(JSON.stringify(this.fields)); // Store the current state of fields
      }
      this.isEditing = !this.isEditing;
    },
    cancelEditing() {
      this.fields = JSON.parse(JSON.stringify(this.originalFields)); // Revert fields to the original state
      this.isEditing = false;
    },
    confirmUpdate() {
      this.showUpdateDialog = true;
    },
    hideUpdateDialog() {
      this.showUpdateDialog = false;
    },
    hideSuccessDialog() {
      this.showSuccessDialog = false;
    },
    async saveProfile() {
      try {
        await axios.patch('http://127.0.0.1:8000/employee/updateProfile', this.fields);
        this.isEditing = false;
        this.showUpdateDialog = false;
        this.showSuccessDialog = true;
      } catch (error) {
        this.errorMessage = 'Failed to update profile. Please try again.';
        this.showUpdateDialog = false;
      }
    },
    search() {
      const searchLower = this.searchQuery.toLowerCase();
      if (searchLower.includes('personal info')) {
        this.activeSubTab = 'personal';
        this.activeTab = 0;
      } else if (searchLower.includes('address')) {
        this.activeSubTab = 'address';
        this.activeTab = 1;
      } else if (searchLower.includes('security')) {
        this.activeSubTab = 'security';
        this.activeTab = 2;
      } else {
        alert('No matching tab found.');
      }
    },
  },
  mounted() {
    this.fetchFullName();
    this.fetchPersonalInfo();
    this.fetchSecurityandContact();
    this.fetchAddress();
  },
  created() {
    this.fetchSexOptions();
    this.fetchCivilStatusOptions();
    this.fetchBloodTypeOptions();
    this.fetchExtOptions();
    this.fetchSelectedRegionOptions();
    this.fetchSelectedProvinceOptions();
    this.fetchSelectedCityOptions();
    this.fetchSelectedBarangayOptions();
  }
};
</script>

<style scoped>
.bg-cover {
  background-size: cover;
}

.text-color {
  color: #707A88;
}

.bg-center {
  background-position: center;
}

.border-box {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: none;
}

.input-field {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.update-button {
  margin-bottom: 20px;
}

.blur-md {
  filter: blur(8px);
}

.custom-cancel-button {
  background-color: #dc3545 !important; /* Red background for cancel button */
  border-color: #dc3545 !important; /* Red border for cancel button */
}

.custom-cancel-button:hover {
  background-color: #e57373 !important; /* Lighter red for hover state */
  border-color: #e57373 !important; /* Lighter red border for hover state */
}
</style>
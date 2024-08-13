<template>
  <AppLayout>
    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div class="relative col-span-1">
        <div class="relative group">
          <br><br><br>
          <img 
            alt="Profile Picture" 
            :src="profilePictureUrl" 
            class="w-full rounded-lg cursor-pointer" 
            height="300" 
            width="300" 
            :class="{ 'blur-md': !isUnblurred }" 
            @click="toggleBlur" 
          />
        </div>
        <!-- Hidden file input -->
        <input type="file" ref="fileInput" @change="onFileSelected" class="hidden" />
        <Button label="Upload Photo" class="w-full py-2 mt-4 text-white rounded-lg bg-gradient-to-r from-pink-500 to-purple-500" @click="triggerFileUpload" />
      </div>
      <div v-if="cropping" class="col-span-1 md:col-span-2">
        <div class="crop-container">
          <img ref="cropperImage" :src="cropperSrc" alt="Cropper Image" />
        </div>
        <Button label="Crop" @click="cropImage" class="mt-4 bg-blue-500 text-white" />
        <Button label="Cancel" @click="cancelCrop" class="mt-4 ml-4 bg-red-500 text-white" />
      </div>
      <div class="col-span-1 md:col-span-2">
        <h1 class="mb-4 text-3xl font-bold lg:text-5xl">{{ fullName }}</h1>
        <p class="mb-4 text-gray-600">{{ empPosition }}</p>
        <div class="border-box">
          <TabView v-model:activeIndex="activeTab" class="no-background">
            <TabPanel header="PERSONAL INFO" :active="activeSubTab === 'personal'">
            <!-- Personal Info Fields -->
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-bold text-gray-700">USER NAME</label>
                    <input type="text" class="text-center input-field text-color" v-model="fields.empUser" disabled />
                </div>
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYEE ID</label>
                    <input type="text" class="text-center input-field text-color" v-model="fields.empID" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                    <input type="text" class="text-center input-field" v-model="fields.firstName" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                    <input type="text" class="text-center input-field" v-model="fields.middleName" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME</label>
                    <input type="text" class="text-center input-field" v-model="fields.lastName" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">CITIZENSHIP</label>
                    <input type="text" class="text-center input-field" v-model="fields.citizenship" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BIRTHDAY</label>
                    <input type="date" class="text-center input-field" v-model="fields.birthday" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">AGE</label>
                  <input type="text" class="text-center input-field text-color" :value="calculatedAge" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">PLACE OF BIRTH</label>
                    <input type="text" class="text-center input-field" v-model="fields.placeOfBirth" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">SEX</label>
                    <select class="text-center input-field" v-model="fields.sex" :disabled="!isEditing">
                        <option v-for="option in sexOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">CIVIL STATUS</label>
                    <select class="text-center input-field" v-model="fields.civilStatus" :disabled="!isEditing">
                        <option v-for="option in civilStatusOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">HEIGHT(M)</label>
                    <input type="number" step="0.01" class="text-center input-field" v-model="fields.height" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">WEIGHT(KG)</label>
                    <input type="number" class="text-center input-field" v-model="fields.weight" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOOD TYPE</label>
                    <select class="text-center input-field" v-model="fields.bloodType" :disabled="!isEditing">
                    <option v-for="option in bloodTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                    </div>
                </div>
            </TabPanel>
            <TabPanel header="ADDRESS" :active="activeSubTab === 'address'">
              <!-- Address Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">REGION</label>
                  <select class="input-field" v-model="fields.Region" :disabled="!isEditing">
                    <option v-for="option in RegionOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PROVINCE</label>
                  <select class="input-field" v-model="fields.Province" :disabled="!isEditing">
                    <option v-for="option in ProvinceOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CITY</label>
                  <select class="input-field" v-model="fields.City" :disabled="!isEditing">
                    <option v-for="option in CityOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
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
                  <select class="input-field" v-model="fields.Barangay" :disabled="!isEditing">
                    <option v-for="option in BarangayOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
              </div>
            </TabPanel>
            <TabPanel header="SECURITY & CONTACT DETAILS" :active="activeSubTab === 'security'">
              <!-- Security & Contact Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                 <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">MOBILE NUMBER</label>
                  <input type="text" class="input-field" v-model="fields.mobilenum" maxlength="9" @input="validateMobileNumber" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                  <input type="text" class="input-field" v-model="fields.telnum" maxlength="7" @input="validateTelephoneNumber" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">EMAIL ADDRESS</label>
                  <input type="text" class="input-field" v-model="fields.emailadd" :disabled="!isEditing" />
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

    <!-- Photo Upload Success Modal -->
    <div v-if="showPhotoSuccessDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg">
        <div class="p-4">
          <div class="text-center">
            <i class="mb-4 text-4xl fas fa-check-circle" style="color: green;"></i>
            <h2 class="mb-4 text-xl font-semibold">Photo Uploaded Successfully!</h2>
            <div class="flex justify-center">
              <button @click="hidePhotoSuccessDialog" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                OK
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import axios from 'axios';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
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
      profilePictureUrl: '',
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
        Region: '',
        Province: '',
        zipcode: '',
        block: '',
        villsub: '',
        mobilenum: '',
        telnum: '',
        emailadd: ''
      },
      isEditing: false,
      originalFields: {},
      errorMessage: '',
      showUpdateDialog: false,
      showSuccessDialog: false,
      showPhotoSuccessDialog: false,
      sexOptions: [],
      civilStatusOptions: [],
      bloodTypeOptions: [],
      extOptions: [],
      RegionOptions: [],
      ProvinceOptions: [],
      activeTab: 0,
      activeSubTab: '',
      searchQuery: '',
      isHovered: false,
      isUnblurred: false,
      selectedFile: null,
<<<<<<< HEAD
      cropping: false,
      cropper: null,
      cropperSrc: ''
=======
      empPic: '',

>>>>>>> f788ffef2305e99746a3b5e2f76096e0bbdac301
    };
  },

  watch: {
    'fields.Region'(newValue) {
      // Make an Axios request whenever fields.Region changes
      axios.get(`/api/region/${newValue}`)
        .then(response => {
          // Handle the response
          console.log(response.data);
        })
        .catch(error => {
          // Handle the error
          console.error(error);
        });
    }
  },

  computed: {
    calculatedAge() {
      if (!this.fields.birthday) return '';
      const today = new Date();
      const birthDate = new Date(this.fields.birthday);
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    },
  },

<<<<<<< HEAD
  methods: {
    validateMobileNumber() {
      this.fields.mobilenum = this.fields.mobilenum.replace(/\D/g, '').slice(0, 10);
    },
    validateTelephoneNumber() {
      this.fields.telnum = this.fields.telnum.replace(/\D/g, '').slice(0, 7);
    },
=======
    methods: {

      validateMobileNumber() {
        this.fields.mobilenum = this.fields.mobilenum.replace(/\D/g, '').slice(0, 10);
      },
      validateTelephoneNumber() {
        this.fields.telnum = this.fields.telnum.replace(/\D/g, '').slice(0, 7);
      },
>>>>>>> f788ffef2305e99746a3b5e2f76096e0bbdac301

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

      async fetchRegionOptions() {
        try {
          const response = await axios.get('/employee/region-options');
          this.RegionOptions = response.data;
        } catch (error) {
          this.errorMessage = 'Failed to load regions.';
        }
      },

      async fetchProvinceOptions() {
        try {
          const response = await axios.get('/employee/province-options');
          this.ProvinceOptions = response.data;
        } catch (error) {
          this.errorMessage = 'Failed to load provinces.';
        }
      },

<<<<<<< HEAD
    async fetchFullName() {
      try {
        const response = await axios.get('/employee/fullname');
        this.fullName = response.data.fullName;
        this.empPosition = response.data.empPosition;
      } catch (error) {
        this.errorMessage = 'Failed to load full name.';
      }
    },
    async fetchPersonalInfo() {
      try {
        const response = await axios.get('/employee/PersonalInfo');
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
        this.errorMessage = 'Failed to load personal information.';
      }
    },

    async fetchAddress() {
      try {
        const response = await axios.get('/employee/Address');
        this.fields.Region = response.data.Region;
        this.fields.Province = response.data.Province;
        this.fields.zipcode = response.data.zipcode;
        this.fields.block = response.data.block;
        this.fields.villsub = response.data.villsub;
      } catch (error) {
        this.errorMessage = 'Failed to load address.';
      }
    },

    async fetchSecurityandContact() {
      try {
        const response = await axios.get('/employee/SecurityandContact');
        this.fields.mobilenum = response.data.mobilenum;
        this.fields.telnum = response.data.telnum;
        this.fields.emailadd = response.data.emailadd;
      } catch (error) {
        this.errorMessage = 'Failed to load security and contact information.';
      }
    },

    async fetchProfilePicture() {
      try {
        const response = await axios.get('/get-profile-picture');
        this.profilePictureUrl = response.data.url ? response.data.url : '/storage/uploads/profile-pictures/default-profile.png';
        console.log('Profile Picture URL:', this.profilePictureUrl);
      } catch (error) {
        console.error('Error fetching profile picture:', error);
      }
    },

    toggleBlur() {
      this.isUnblurred = !this.isUnblurred;
    },
    triggerFileUpload() {
      this.$refs.fileInput.click();
    },
    onFileSelected(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.cropperSrc = e.target.result;
          this.cropping = true;
          this.$nextTick(() => {
            this.initializeCropper();
          });
        };
        reader.readAsDataURL(file);
      }
    },
    initializeCropper() {
      const image = this.$refs.cropperImage;
      this.cropper = new Cropper(image, {
        aspectRatio: 3.5 / 4.5, // Passport size aspect ratio
        viewMode: 1
      });
    },
    cropImage() {
      const canvas = this.cropper.getCroppedCanvas({
        width: 350, // Adjust as needed for passport size
        height: 450
      });
      canvas.toBlob((blob) => {
        this.uploadCroppedImage(blob);
      });
    },
    uploadCroppedImage(blob) {
      const formData = new FormData();
      formData.append('file', blob, 'cropped-image.png');

      axios.post('/upload-profile-picture', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      }).then(response => {
        this.profilePictureUrl = response.data.url;
        this.cropping = false;
        this.showPhotoSuccessDialog = true;
      }).catch(error => {
        console.error('Error uploading file:', error);
      });
    },
    cancelCrop() {
      this.cropping = false;
    },
    hidePhotoSuccessDialog() {
      this.showPhotoSuccessDialog = false;
    },
=======
      async fetchFullName() {
        try {
          const response = await axios.get('/employee/fullname');
          this.fullName = response.data.fullName;
          this.empPosition = response.data.empPosition;
        } catch (error) {
            this.errorMessage = 'Failed to load full name.';
        }
      },

      async fetchPersonalInfo() {
        try {
          const response = await axios.get('/employee/PersonalInfo');
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
            this.errorMessage = 'Failed to load personal information.';
        }
      },

      async fetchAddress() {
        try {
          const response = await axios.get('/employee/Address');
          this.fields.Region = response.data.Region;
          this.fields.Province = response.data.Province;
          this.fields.zipcode = response.data.zipcode;
          this.fields.block = response.data.block;
          this.fields.villsub = response.data.villsub;
        } catch (error) {
            this.errorMessage = 'Failed to load address.';
        }
      },

      async fetchSecurityandContact() {
        try {
          const response = await axios.get('/employee/SecurityandContact');
          this.fields.mobilenum = response.data.mobilenum;
          this.fields.telnum = response.data.telnum;
          this.fields.emailadd = response.data.emailadd;
        } catch (error) {
            this.errorMessage = 'Failed to load security and contact information.';
        }
      },

      async fetchProfilePicture() {
        try {
            const response = await axios.get('/get-profile-picture');
            this.profilePictureUrl = response.data.url ? response.data.url : '/storage/uploads/profile-pictures/default-profile.png';
            console.log('Profile Picture URL:', this.profilePictureUrl); 
        } catch (error) {
            console.error('Error fetching profile picture:', error);
        }
      },

      toggleBlur() {
        this.isUnblurred = !this.isUnblurred;
      },

      triggerFileUpload() {
        this.$refs.fileInput.click();
      },
>>>>>>> f788ffef2305e99746a3b5e2f76096e0bbdac301

      onFileSelected(event) {
        this.selectedFile = event.target.files[0];
        this.uploadFile();
      },

      async uploadFile() {
        if (this.selectedFile) {
          const formData = new FormData();
          formData.append('file', this.selectedFile);

        try {
          const response = await axios.post('/upload-profile-picture', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          this.profilePictureUrl = response.data.url;
          console.log('File uploaded successfully:', response.data);
          this.showPhotoSuccessDialog = true; // Show the success modal
        } catch (error) {
          console.error('Error uploading file:', error);
        }
      }
    },

    hidePhotoSuccessDialog() {
      this.showPhotoSuccessDialog = false; // Hide the success modal
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
        await axios.patch('/employee/updateProfile', this.fields);
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
    this.fetchProfilePicture();
  },

  created() {
    this.fetchSexOptions();
    this.fetchCivilStatusOptions();
    this.fetchBloodTypeOptions();
    this.fetchExtOptions();
    this.fetchRegionOptions();
    this.fetchProvinceOptions();
  },
};
</script>

<style scoped>
.bg-cover {
  background-size: cover;
}

.text-color {
  color: #707A88;
}

.text-color:hover{
  cursor: not-allowed;
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

.crop-container {
  max-width: 100%;
  height: auto;
}
</style>
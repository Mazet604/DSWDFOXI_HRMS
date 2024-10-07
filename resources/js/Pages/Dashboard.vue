<template>
    <AppLayout>
      <div class="flex flex-col lg:flex-row">
        <!-- Main Content -->
        <div class="relative w-full p-6">
          <!-- Profile Section -->
          <div class="absolute right-0 flex items-center mb-4 -top-16 lg:static lg:mt-0 lg:mb-8">
            <!-- Profile Image with Hover Effect -->
            <div class="relative object-cover w-24 h-24 rounded-full lg:w-36 lg:h-36 group">
              <!-- Profile Picture -->
              <img :src="profilePictureUrl" alt="Profile Picture" class="object-cover w-full h-full rounded-full border" />
              <!-- Camera Icon Overlay -->
              <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 rounded-full opacity-0 cursor-pointer group-hover:opacity-100" @click="triggerFileUpload">
                <i class="text-3xl text-white fas fa-camera"></i>
              </div>
              <!-- Hidden File Input -->
              <input type="file" ref="fileInput" @change="onFileSelected" class="hidden" />
            </div>

            <!-- Profile Details -->
            <div class="ml-4 text-left">
              <h2 class="text-4xl font-semibold text-blue-800">{{ fullName }}</h2>
              <hr class="my-2 border-2 border-yellow-200" />
              <p class="text-lg text-gray-600 font-semibold">{{ empPosition }}</p>
            </div>
          </div>

          <!-- Custom Tabs -->
          <div class="flex justify-end -mb-px">
            <button @click="activeTab = 0" :class="tabButtonClass(0)">PERSONAL INFO</button>
            <button @click="activeTab = 1" :class="tabButtonClass(1)">ADDRESS</button>
          </div>

          <!-- Personal Info Tab -->
          <div v-if="activeTab === 0" class="p-6 bg-white border-2 border-blue-800 rounded-lg">
            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">BASIC INFORMATION</h2>
            <div class="grid grid-cols-2 gap-4 mb-6">
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">EMPLOYEE ID</label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" v-model="fields.empID" disabled />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">USERNAME</label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" v-model="fields.empUser" disabled />
              </div>
            </div>

            <div class="grid grid-cols-4 gap-4 mb-6">
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">SURNAME <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.lastName" :disabled="!isEditing" @input="validateName('lastName')" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">FIRST NAME <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.firstName" :disabled="!isEditing" @input="validateName('firstName')" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">MIDDLE NAME <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.middleName" :disabled="!isEditing" @input="validateName('middleName')" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">SUFFIX <span style="color: red;">*</span></label>
                <select class="w-full p-2 border border-gray-300 rounded-md" :class="{ 'disabled-input': !isEditing }" v-model="fields.suffix" :disabled="!isEditing">
                  <option v-for="option in extOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-4 gap-4 mb-6">
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">CITIZENSHIP</label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" v-model="fields.citizenship" disabled />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">BIRTHDAY </label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="date" v-model="fields.birthday" disabled :class="{ 'disabled-input': !isEditing }" :max="maxDate" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">PLACE OF BIRTH</label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" v-model="fields.placeOfBirth" disabled />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">CIVIL STATUS <span style="color: red;">*</span></label>
                <select class="w-full p-2 border border-gray-300 rounded-md" :class="{ 'disabled-input': !isEditing }" v-model="fields.civilStatus" :disabled="!isEditing">
                  <option v-for="option in civilStatusOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-5 gap-4 mb-6">
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">SEX <span style="color: red;">*</span></label>
                <select class="w-full p-2 border border-gray-300 rounded-md" :class="{ 'disabled-input': !isEditing }" v-model="fields.sex" :disabled="!isEditing">
                  <option v-for="option in sexOptions" :key="option.value" :value="option.value" >{{ option.label }}</option>
                </select>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">AGE</label>
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" :value="calculatedAge" disabled />
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">BLOOD TYPE</label>
                <select class="w-full p-2 border border-gray-300 rounded-md" :class="{ 'disabled-input': !isEditing }" v-model="fields.bloodType" :disabled="!isEditing">
                  <option v-for="option in bloodTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                </select>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">HEIGHT(M) <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="number" step="0.01" v-model="fields.height" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">WEIGHT(KG) <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="number" v-model="fields.weight" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
              </div>
            </div>

            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">CONTACT INFORMATION</h2>
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div>
                  <label class="block mb-1 text-sm font-medium text-gray-700">
                    MOBILE NUMBER <span style="color: red;">*</span>
                  </label>
                  <div class="flex items-center">
                    <span class="p-2 border border-gray-300 rounded-l-md bg-gray-200" style="color:#707A88;">+63</span>
                    <input
                      class="w-full p-2 border border-gray-300 rounded-r-md"
                      v-model="fields.mobilenum"
                      @input="validateMobileNumber"
                      :disabled="!isEditing"
                      :class="{ 'disabled-input': !isEditing }"
                    />
                  </div>
                </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">TELEPHONE NUMBER <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.telnum" @input="validateTelephoneNumber" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">EMAIL ADDRESS <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="email" v-model="fields.emailadd" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
              </div>
              <div>
                <label class="block mb-1 text-sm font-medium text-white">.</label>
                <button @click="showChangePassModal" class="w-full p-2 bg-blue-900 text-white rounded-md hover:bg-blue-800">Change Password</button>
                <ChangePass v-if="isChangePassModalVisible" @close="isChangePassModalVisible = false" />
              </div>
            </div>

            <div class="mt-6 text-right">
            <button v-if="!isEditing" @click="toggleEditing" class="px-8 py-2 font-semibold text-white transition bg-blue-900 rounded-md hover:bg-blue-800 duration-30">EDIT</button>
            <div v-if="isEditing" class="inline-flex space-x-4">
                <button @click="cancelEditing" class="px-4 py-2 text-white rounded-md bg-red-700 hover:bg-red-800 font-semibold">CANCEL</button>
                <button @click="confirmUpdate" class="px-8 py-2 text-white bg-blue-900 rounded-md hover:bg-blue-800 font-semibold">SAVE</button>
            </div>
            </div>
    </div>
            <div v-if="activeTab === 1" class="p-6 bg-white border-2 border-blue-800 rounded-lg">
              <Address />
            </div>
        </div>
      </div>

      <!-- Update Confirmation Modal -->
      <div v-if="showUpdateDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg">
          <div class="p-4">
            <div class="text-center">
              <i class="mt-4 mb-4 text-4xl fas fa-circle-question" style="color: red;"></i>
              <h2 class="mb-4 text-xl font-semibold">Are you sure you want to update?</h2>
              <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
            </div>
            <div class="flex justify-center gap-4">
              <button @click="hideUpdateDialog" class="px-6 py-2 font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">Cancel</button>
              <button @click="saveProfile" class="px-6 py-2 font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">Confirm</button>
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
            <p class="mb-4">Your profile has been updated successfully.</p>
          </div>
          <div class="flex justify-center gap-4">
            <button @click="hideSuccessDialog" class="px-4 py-2 text-white bg-blue-900 rounded-md hover:bg-blue-800">OKAY</button>
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
              <button @click="hidePhotoSuccessDialog" class="px-4 py-2 font-semibold text-white bg-blue-900 rounded hover:bg-blue-800">OKAY</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Crop Image Modal -->
    <div v-if="cropping" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="w-full max-w-lg p-4 overflow-hidden transition-all transform bg-white rounded-lg">
        <h2 class="mb-4 text-xl font-semibold text-center">Crop Your Image</h2>
        <div class="crop-container">
          <img ref="cropperImage" :src="cropperSrc" alt="Cropper Image" />
        </div>
        <div class="flex justify-center mt-4">
            <button @click="cancelCrop" class="px-6 py-2 mr-4 font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">Cancel</button>
          <button @click="cropImage" class="px-8 py-2 font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">Crop</button>
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
import ChangePass from '@/Pages/Auth/ChangePass.vue';
import Address from '@/Pages/Address.vue';

const isChangePassModalVisible = ref(false);

const showChangePassModal = () => {
  isChangePassModalVisible.value = true;
};

export default {
  components: {
    AppLayout, Button, Address, ChangePass
  },

  mounted() {
    console.log('Component mounted.')
  },

  data() {
    return {
      fullName: '',
      empPosition: '',
      profilePictureUrl: '',
      copyPermanentToCurrent: false,
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
        mobilenum: '',
        telnum: '',
        emailadd: '',
        croppedBlob: null,
      },
      activeTab: 'personal-info',
      activeSubTab: '',
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
      activeTab: 0,
      activeSubTab: '',
      searchQuery: '',
      isHovered: false,
      isUnblurred: false,
      selectedFile: null,
      empPic: '',
      cropping: false,
      cropper: null,
      cropperSrc: '',
    };
  },

  created() {
    // Retrieve the empid from session or local storage when the component is created
    this.empid = sessionStorage.getItem('empid') || localStorage.getItem('empid') || '';
  },

  computed: {
    maxDate() {
      const today = new Date();
      const year = today.getFullYear();
      const month = (today.getMonth() + 1).toString().padStart(2, '0');
      const day = today.getDate().toString().padStart(2, '0');
      return `${year}-${month}-${day}`;
    },
    
    calculatedAge() {
      if (!this.fields.birthday) return '';
      const today = new Date();
      const birthDate = new Date(this.fields.birthday);

      // Check if birthday is in the future
      if (birthDate > today) {
        this.hasBirthdayError = true;
        this.birthdayErrorMessage = 'Birthday cannot be in the future.';
        return 'Invalid Date';
      }

      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }

      if (age < 18) {
        this.hasBirthdayError = true;
        this.birthdayErrorMessage = 'Age must be at least 18 years old.';
        return 'Invalid Age';
      }

      this.hasBirthdayError = false;
      this.birthdayErrorMessage = '';
      return age;
    }
  },

  methods: {

    validateName(field) {
      this.fields[field] = this.fields[field].replace(/[0-9]/g, '');
    },

    validateNumber(field) {
      this.fields[field] = this.fields[field].replace(/\D/g, '');
    },

    validateMobileNumber() {
      this.fields.mobilenum = this.fields.mobilenum.replace(/\D/g, '').slice(0, 10);
    },
    validateTelephoneNumber() {
      this.fields.telnum = this.fields.telnum.replace(/\D/g, '').slice(0, 8);
    },

    fetchSexOptions() {
      fetch('/dropdown/sex-options')
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch sex options');
          }
          return response.json();
        })
        .then(data => {
          this.sexOptions = data;
        })
        .catch(error => {
          console.error(error);
        });
    },

    fetchCivilStatusOptions() {
      fetch('/dropdown/civilstatus-options')
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch civil status options');
          }
          return response.json();
        })
        .then(data => {
          this.civilStatusOptions = data;
        })
        .catch(error => {
          console.error(error);
        });
    },

    fetchBloodTypeOptions() {
      fetch('/dropdown/bloodtype-options')
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch blood type options');
          }
          return response.json();
        })
        .then(data => {
          this.bloodTypeOptions = data;
        })
        .catch(error => {
          console.error(error);
        });
    },

    fetchExtOptions() {
      fetch('/dropdown/ext-options')
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch suffix options');
          }
          return response.json();
        })
        .then(data => {
          this.extOptions = data;
        })
        .catch(error => {
          console.error(error);
        });
    },

    fetchFullName() {
      return axios.get('/employee/fullname')
        .then(response => {
          this.fullName = response.data.fullName;
          this.empPosition = response.data.empPosition;
        })
        .catch(error => {
          this.errorMessage = 'Failed to load full name.';
          throw error; // Rethrow the error to be handled by hideSuccessDialog
        });
    },


    fetchPersonalInfo() {
      axios.get('/employee/PersonalInfo')
        .then(response => {
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
        })
        .catch(error => {
          this.errorMessage = 'Failed to load personal information.';
        });
    },

    fetchSecurityandContact() {
      axios.get('/employee/SecurityandContact')
        .then(response => {
          this.fields.mobilenum = response.data.mobilenum;
          this.fields.telnum = response.data.telnum;
          this.fields.emailadd = response.data.emailadd;
        })
        .catch(error => {
          this.errorMessage = 'Failed to load security and contact information.';
        });
    },

    fetchProfilePicture() {
      axios.get('/get-profile-picture')
        .then(response => {
          this.profilePictureUrl = response.data.url ? response.data.url : '/storage/uploads/profile-pictures/default-profile.png';
          console.log('Profile Picture URL:', this.profilePictureUrl);
        })
        .catch(error => {
          console.error('Error fetching profile picture:', error);
        });
    },

    toggleBlur() {
      this.isUnblurred = !this.isUnblurred;
    },
    triggerFileUpload() {
      this.$refs.fileInput.click();
    },
    handleFileChange(event) {
    const originalFile = event.target.files[0]; // Get the original file
    if (originalFile) {
        // Store the original file name
        this.originalFileName = originalFile.name;

        // Read the file as a data URL for image cropping
        const reader = new FileReader();

        reader.onload = (e) => {
            // Create an image element
            const img = new Image();
            img.src = e.target.result;

            // Set up an image load event handler
            img.onload = () => {
                // Initialize your cropping library or logic here
                this.initCropping(img);
            };
        };

        reader.readAsDataURL(originalFile);
      }
    },

    onCroppingComplete(croppedBlob) {
      if (this.empid && croppedBlob) {
        this.uploadCroppedImage(croppedBlob, this.empid);
      } else {
        console.error('Missing employee ID or cropped image.');
      }
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

    initCropping(image) {
        // Example: Use a cropping library like Cropper.js
        // Assuming you have a <div id="cropper-container"></div> in your template
        const cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            ready() {
                console.log('Cropper is ready.');
            },
            crop(event) {
                // Handle cropping events
            }
        });

        // Store the cropper instance if needed
        this.cropper = cropper;
    },

    // Method to be called when cropping is complete
    onCroppingComplete() {
        if (this.cropper) {
            this.cropper.getCroppedCanvas().toBlob((blob) => {
                // Call upload method with cropped blob and user ID
                this.uploadCroppedImage(blob, this.empid);
            });
        } else {
            console.error('Cropper instance not found.');
        }
    },

    uploadCroppedImage(blob) {
  const formData = new FormData();
  formData.append('file', blob, 'profile_image.png'); // Use a placeholder name

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
      this.selectedFile = null;
      this.profilePictureUrl = ''
    },

    uploadFile() {
      if (this.selectedFile) {
        const formData = new FormData();
        formData.append('file', this.selectedFile);

        axios.post('/upload-profile-picture', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        }).then(response => {
          this.profilePictureUrl = response.data.url;
          this.showPhotoSuccessDialog = true; // Show the success modal
        }).catch(error => {
          console.error('Error uploading file:', error);
        });
      }
    },

    hidePhotoSuccessDialog() {
      this.showPhotoSuccessDialog = false; // Hide the success modal
      // location.reload();
    },

    tabButtonClass(tabName) {
      return {
        'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
        'bg-blue-900 text-white': this.activeTab === tabName,
        'bg-gray-300 text-gray-700': this.activeTab !== tabName,
      };
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
      this.copyPermanentToCurrent = false;
    },
    confirmUpdate() {
      this.showUpdateDialog = true;
    },
    
    hideUpdateDialog() {
      this.showUpdateDialog = false;
    },
    async hideSuccessDialog() {
      this.showSuccessDialog = false;
      this.isEditing = false;

      try {
          await this.fetchFullName(); // Wait for fetchFullName to complete
      } catch (error) {
          console.error('Error during fetchFullName:', error);
      }
  },


    saveProfile() {
      axios.patch('/employee/updateProfile', this.fields)
        .then(() => {
          this.isEditing = false;
          this.showUpdateDialog = false;
          this.showSuccessDialog = true;
        })
        .catch(error => {
          console.error('Error updating profile:', error);
        });
    },

    search() {
      const searchLower = this.searchQuery.toLowerCase();
      if (searchLower.includes('personal info')) {
        this.activeTab = 0;
      } else if (searchLower.includes('address')) {
        this.activeTab = 1;
      } else if (searchLower.includes('security')) {
        this.activeTab = 2;
      }
    },
  },

  mounted() {
    this.fetchFullName();
    this.fetchPersonalInfo();
    this.fetchSecurityandContact();
    this.fetchProfilePicture();
  },

  created() {
    this.fetchSexOptions();
    this.fetchCivilStatusOptions();
    this.fetchBloodTypeOptions();
    this.fetchExtOptions();
  },

};
</script>

<style scoped>

.bg-cover {
    background-size: cover;
}

.text-color {
    color: #66686b;
    background-color: #eeeeee;
}

.text-color:hover {
    cursor: not-allowed;
}

.bg-center {
    background-position: center;
}

.disabled-input {
  color: #66686b;
  background-color: #eeeeee;
}

.border-box {
    background: rgb(255, 255, 255);
    border-radius: 8px;
    padding: 20px;
    box-shadow: none;
}

.input-field {
    width: 100%; /* Full width of the container */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    text-align: left; /* Ensure text is left-aligned */
}


.col-span-1 {
    width: 100%;
}

.col-span-2 {
    width: 100%;
}

.username-field,
.employee-id-field {
    max-width: 150px; /* Adjust this width as necessary to match the image */
}

.update-button {
    margin-bottom: 20px;
}

.blur-md {
    filter: blur(8px);
}

.tight {
  margin-top: 1%;
  width: 79%;
}

.crop-container {
  max-width: 100%;
  height: auto;
}

</style>

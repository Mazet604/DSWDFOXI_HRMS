<template>
    <AppLayout>
            <div class="flex flex-col lg:flex-row">
                <!-- Sidebar -->
                <div>
                <Sidebar />
                </div>

                <!-- Main Content -->
                <div class="w-full p-6 relative">
                <!-- Profile Section -->
                <div class="flex items-center mb-4 absolute -top-16 right-0 lg:static lg:mt-0 lg:mb-8">
                    <!-- Profile Image with Hover Effect -->
                    <div class="relative w-24 h-24 lg:w-36 lg:h-36 rounded-full object-cover group">
                    <!-- Profile Picture -->
                    <img
                        :src="profilePictureUrl"
                        alt="Profile Picture"
                        class="w-full h-full rounded-full object-cover"
                    />
                    <!-- Camera Icon Overlay -->
                    <div
                        class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                        @click="triggerFileUpload"
                    >
                        <i class="fas fa-camera text-white text-3xl"></i>
                    </div>
                    <!-- Hidden File Input -->
                    <input type="file" ref="fileInput" @change="onFileSelected" class="hidden" />
                    </div>

                    <!-- Profile Details -->
                    <div class="ml-4 text-left">
                    <h2 class="text-4xl font-semibold text-blue-800">{{ fullName }}</h2>
                    <hr class="my-2 border-yellow-200 border-2" />
                    <p class="text-gray-600 text-lg">{{ empPosition }}</p>
                    </div>
                </div>

                <!-- Custom Tabs (optional) -->
                <div class="flex justify-end -mb-px">
                    <button
                    @click="activeTab = 'personal-info'"
                    :class="tabButtonClass('personal-info')"
                    >
                    PERSONAL INFO
                    </button>
                    <button
                    @click="activeTab = 'address'"
                    :class="tabButtonClass('address')"
                    >
                    ADDRESS
                    </button>
                </div>

                <!-- Personal Info Tab -->
                <div v-if="activeTab === 'personal-info'" class="bg-white border border-blue-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 pb-2 border-b border-yellow-200">BASIC INFORMATION</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Employee ID *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.empID" disabled/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.empUser" disabled/>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Firstname *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.firstName"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Middlename *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.middleName"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lastname *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.lastName"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Suffix *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.suffix">
                                <option value="">None</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Citizenship *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.citizenship"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Birthday *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="date" v-model="fields.birthday"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Place of Birth *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.placeOfBirth"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Civil Status *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.civilStatus">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-5 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sex *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.sex">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="calculatedAge" disabled/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Blood Type *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.bloodType">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Height *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="number" step="0.01" v-model="fields.height"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Weight *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="number" v-model="fields.weight"/>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold text-blue-800 mb-4 pb-2 border-b border-yellow-200">CONTACT INFORMATION</h2>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.mobilenum"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telephone Number *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.telnum"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="email" v-model="fields.emailadd"/>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button @click="toggleEditing" class="bg-blue-900 text-white px-8 py-2 rounded-md font-semibold">EDIT</button>
                    </div>
                </div>

                <!-- Address Tab -->
                <div v-if="activeTab === 'address'" class="bg-white border border-blue-900 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 pb-2 border-b border-yellow-200">PERMANENT ADDRESS</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Region *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Region">
                                <option value="NCR">NCR</option>
                                <option value="Region 1">Region 1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Province">
                                <option value="Ilocos Norte">Ilocos Norte</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.City">
                                <option value="City 1">City 1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barangay *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Barangay">
                                <option value="Barangay 1">Barangay 1</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Village/Subdivision *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.villsub"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Block/Street/Purok *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.block"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.zipcode"/>
                        </div>
                    </div>

                    <!-- Align Checkbox to the Right -->
                    <div class="flex justify-end mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="sameAddressCheckbox" v-model="sameCurrentAddress" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="sameAddressCheckbox" class="ml-2 block text-sm font-medium text-gray-700">Same current address?</label>
                        </div>
                    </div>

                    <!-- Current Address Section -->
                    <h2 class="text-lg font-semibold text-blue-800 mb-4 pb-2 border-b border-yellow-200">CURRENT ADDRESS</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Region *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Region2">
                                <option value="NCR">NCR</option>
                                <option value="Region 1">Region 1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Province2">
                                <option value="Ilocos Norte">Ilocos Norte</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.City2">
                                <option value="City 1">City 1</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Barangay *</label>
                            <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Barangay2">
                                <option value="Barangay 1">Barangay 1</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Village/Subdivision *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.villsub2"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Block/Street/Purok *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.block2"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code *</label>
                            <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="fields.zipcode2"/>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button @click="toggleEditing" class="bg-blue-900 text-white px-8 py-2 rounded-md font-semibold">EDIT</button>
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
        zipcode: '',
        block: '',
        villsub: '',
        mobilenum: '',
        telnum: '',
        emailadd: '',
        Region:'',
        Province:'',
        City:'',
        croppedBlob: null,
        Barangay:'',
        Region2:'',
        Province2:'',
        City2:'',
        Barangay2:'',
        zipcode2: '',
        block2: '',
        villsub2: '',
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
      regions: [],
      provinces: [],
      cities: [],
      barangays: [],
      regions2: [],
      provinces2: [],
      cities2: [],
      barangays2: [],
      activeTab: 'personal-info', // Add the activeTab data property here
      activeSubTab: '',
      sameCurrentAddress: false,
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

  watch: {
    copyPermanentToCurrent(newValue) {
      if (newValue) {
        this.copyPermanentAddress();
      }
    }
  },

    watch: {
    // If "Same current address?" is checked, copy permanent address to current address
    sameCurrentAddress(newValue) {
      if (newValue) {
        this.fields.Region2 = this.fields.Region;
        this.fields.Province2 = this.fields.Province;
        this.fields.City2 = this.fields.City;
        this.fields.Barangay2 = this.fields.Barangay;
        this.fields.villsub2 = this.fields.villsub;
        this.fields.block2 = this.fields.block;
        this.fields.zipcode2 = this.fields.zipcode;
      }
    },
  },

  methods: {
    // Add the tabButtonClass method here
    tabButtonClass(tabName) {
      return {
        'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
        'bg-blue-900 text-white': this.activeTab === tabName,
        'bg-gray-300 text-gray-700': this.activeTab !== tabName,
      };
    },

    validateName(field) {
      this.fields[field] = this.fields[field].replace(/[0-9]/g, '');
    },

    validateMobileNumber() {
      this.fields.mobilenum = this.fields.mobilenum.replace(/\D/g, '').slice(0, 10);
    },

    validateTelephoneNumber() {
      this.fields.telnum = this.fields.telnum.replace(/\D/g, '').slice(0, 7);
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
      axios.get('/employee/fullname')
        .then(response => {
          this.fullName = response.data.fullName;
          this.empPosition = response.data.empPosition;
        })
        .catch(error => {
          this.errorMessage = 'Failed to load full name.';
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

    fetchAddress() {
      axios.get('/employee/Address')
        .then(response => {
          this.fields.zipcode = response.data.zipcode;
          this.fields.block = response.data.block;
          this.fields.villsub = response.data.villsub;
          this.fields.Region = response.data.Region;
          this.fields.Province = response.data.Province;
          this.fields.City = response.data.City;
          this.fields.Barangay = response.data.Barangay;

          this.fetchProvinces();
          this.fetchCities();
          this.fetchBarangays();

        })
        .catch(error => {
          this.errorMessage = 'Failed to load address.';
        });
    },

    fetchAddress2() {
      axios.get('/employee/Address2')
        .then(response => {
          this.fields.zipcode2 = response.data.zipcode2;
          this.fields.block2 = response.data.block2;
          this.fields.villsub2 = response.data.villsub2;
          this.fields.Region2 = response.data.Region2;
          this.fields.Province2 = response.data.Province2;
          this.fields.City2 = response.data.City2;
          this.fields.Barangay2 = response.data.Barangay2;

          this.fetchProvinces2();
          this.fetchCities2();
          this.fetchBarangays2();

        })
        .catch(error => {
          this.errorMessage = 'Failed to load address.';
        });
    },

    fetchRegions() {
      axios.get('/api/regions')
        .then(response => {
          this.regions = response.data;
        })
        .catch(error => {
          console.error('Error fetching regions:', error);
        });
    },

    fetchRegions2() {
      axios.get('/api/regions2')
        .then(response => {
          this.regions2 = response.data;
        })
        .catch(error => {
          console.error('Error fetching regions:', error);
        });
    },


    fetchProvinces() {
      axios.get('/api/provinces', {
        params:{
          reg_psgc:this.fields.Region
        }
      })
        .then(function(response) {
          this.provinces = response.data;
        }.bind(this));
    },

    fetchProvinces2() {
      axios.get('/api/provinces2', {
        params:{
          reg_psgc:this.fields.Region2
        }
      })
        .then(function(response) {
          this.provinces2 = response.data;
        }.bind(this));
    },

    fetchCities() {
      axios.get('/api/cities', {
        params:{
          prv_psgc:this.fields.Province
        }
      })
        .then(function(response) {
          this.cities = response.data;
        }.bind(this));
    },

    fetchCities2() {
      axios.get('/api/cities2', {
        params:{
          prv_psgc:this.fields.Province2
        }
      })
        .then(function(response) {
          this.cities2 = response.data;
        }.bind(this));
    },

    fetchBarangays() {
      axios.get('/api/barangays', {
        params:{
          citmun_psgc:this.fields.City
        }
      })
        .then(function(response) {
          this.barangays = response.data;
        }.bind(this));
    },

    fetchBarangays2() {
      axios.get('/api/barangays2', {
        params:{
          citmun_psgc:this.fields.City2
        }
      })
        .then(function(response) {
          this.barangays2 = response.data;
        }.bind(this));
    },

    copyPermanentAddress() {
      this.fields.Region2 = this.fields.Region;
      this.fields.Province2 = this.fields.Province;
      this.fields.City2 = this.fields.City;
      this.fields.Barangay2 = this.fields.Barangay;
      this.fields.zipcode2 = this.fields.zipcode;
      this.fields.block2 = this.fields.block;
      this.fields.villsub2 = this.fields.villsub;
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
      location.reload();
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
      location.reload();
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
    this.fetchAddress();
    this.fetchAddress2();
    this.fetchProfilePicture();
  },

  created() {
    this.fetchSexOptions();
    this.fetchCivilStatusOptions();
    this.fetchBloodTypeOptions();
    this.fetchExtOptions();
    this.fetchRegions();
    this.fetchRegions2();
  },

};
</script>

<style scoped>
.bg-cover {
    background-size: cover;
}

.broken-line {
  display: block;
  width: 100%;
  border-bottom: 1px dashed #000;
  margin: 20px 0;
}

.text-color {
    color: #707A88;
}

.text-color:hover {
    cursor: not-allowed;
}

.bg-center {
    background-position: center;
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

.custom-cancel-button {
    background-color: #dc3545 !important; /* Red background for cancel button */
    border-color: #dc3545 !important; /* Red border for cancel button */
}

.custom-cancel-button:hover {
    background-color: #e57373 !important; /* Lighter red for hover state */
    border-color: #e57373 !important; /* Lighter red border for hover state */
}

.tight {
  margin-top: 1%;
  width: 79%;
}

.crop-container {
  max-width: 100%;
  height: auto;
}

.checkbox {
  display: flex;
  flex-direction: row;
}

.check {
  cursor: pointer;
}

.addgrid {
  text-align: center;
}

.number-field {
  padding-left: 15%;
}

</style>

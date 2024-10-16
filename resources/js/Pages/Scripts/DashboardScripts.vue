<script>
import axios from 'axios';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';

export default {
  components: {
    AppLayout, Button
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
        age: this.calculatedAge,
        civilStatus: '',
        height: '',
        weight: '',
        bloodType: '',
        mobilenum: '',
        telnum: '',
        emailadd: '',
        croppedBlob: null,
        zipcode: '',
        block: '',
        villsub: '',
        Region:'',
        Province:'',
        City:'',
        Barangay:'',
        Region2:'',
        Province2:'',
        City2:'',
        Barangay2:'',
        zipcode2: '',
        block2: '',
        villsub2: '',
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
      regions:[],
      provinces:[],
      cities:[],
      barangays:[],
      regions2:[],
      provinces2:[],
      cities2:[],
      barangays2:[],
      activeTab: 0,
      activeSubTab: '',
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

  watch: {

    'fields.birthday': function(newVal) {
      this.fields.age = this.calculatedAge;
    },

    copyPermanentToCurrent(newValue) {
        if (newValue) {
            this.copyPermanentAddress();
        }
    },

    'fields.Region'(newVal) {
        if (newVal) {
            this.fetchProvinces();
        }
        },

    'fields.Province'(newVal) {
        if (newVal) {
            this.fetchCities();
        }
    },

    'fields.City'(newVal) {
        if (newVal) {
            this.fetchBarangays();
        }
    },

    'fields.Region2'(newVal) {
        if (newVal) {
            this.fetchProvinces2();
        }
    },

    'fields.Province2'(newVal) {
        if (newVal) {
            this.fetchCities2();
        }
    },

    'fields.City2'(newVal) {
        if (newVal) {
            this.fetchBarangays2();
        }
    },

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
          this.fields.age = response.data.age;
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
    this.fetchAddress();
    this.fetchAddress2();
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
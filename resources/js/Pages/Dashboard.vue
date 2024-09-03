 <template>
  <AppLayout>
    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
      <div class="relative col-span-1">
        <div class="relative group">
          <img
            alt="Profile Picture"
            :src="profilePictureUrl"
            class="w-full rounded-lg cursor-pointer"
            height="300"
            width="300"
            :class="{ 'blur-md': !isUnblurred }"
            @click="toggleBlur"
          />
          <button @click="toggleBlur" class="absolute top-0 right-0 m-2 p-2 bg-gray-800 bg-opacity-75 rounded-full">
      <i class="fas fa-eye text-white text-4xl"></i>
    </button>
        </div>
        <!-- Hidden file input -->
        <input type="file" ref="fileInput" @change="onFileSelected" class="hidden" />
        <Button label="Upload Photo" class="w-full py-2 mt-4 text-white rounded-lg bg-gradient-to-r from-pink-500 to-purple-500" @click="triggerFileUpload" />
      </div>
      <div class="col-span-1 md:col-span-2">
        <h1 class="mb-4 text-3xl font-bold lg:text-5xl">{{ fullName }}</h1>
        <p class="mb-4 text-gray-600">{{ empPosition }}</p>
        <div class="border-box">
          <TabView v-model:activeIndex="activeTab" class="no-background">
            <TabPanel header="PERSONAL INFO" :active="activeSubTab === 'personal'">
            <!-- Personal Info Fields -->
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-bold text-gray-700">USER NAME</label>
                    <input type="text" class="input-field text-color" v-model="fields.empUser" disabled />
                </div>
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYEE ID</label>
                    <input type="text" class="input-field text-color" v-model="fields.empID" disabled />
                </div><div class="col-span-1"></div><div class="col-span-1"></div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME <span style="color: red;">*</span></label>
                    <input type="text" class="input-field" v-model="fields.firstName" :disabled="!isEditing" @input="validateName('firstName')"/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME <span style="color: red;">*</span></label>
                    <input type="text" class="input-field" v-model="fields.middleName" :disabled="!isEditing" @input="validateName('middleName')"/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME <span style="color: red;">*</span></label>
                    <input type="text" class="input-field" v-model="fields.lastName" :disabled="!isEditing" @input="validateName('lastName')"/>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">SUFFIX <span style="color: red;">*</span></label>
                  <select class="input-field" v-model="fields.suffix" :disabled="!isEditing">
                    <option v-for="option in extOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                  </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">CITIZENSHIP <span style="color: red;">*</span></label>
                    <input type="text" class="input-field" v-model="fields.citizenship" :disabled="!isEditing" @input="validateName('citizenship')"/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BIRTHDAY <span style="color: red;">*</span></label>
                    <input type="date" class="text-center input-field" v-model="fields.birthday" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">PLACE OF BIRTH</label>
                    <input type="text" class="input-field" v-model="fields.placeOfBirth" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">CIVIL STATUS <span style="color: red;">*</span></label>
                    <select class="input-field" v-model="fields.civilStatus" :disabled="!isEditing">
                        <option v-for="option in civilStatusOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
              </div>
              <br>
                <div class="tight">
                  <div class="grid grid-cols-5 gap-4">
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">SEX <span style="color: red;">*</span></label>
                    <select class="input-field" v-model="fields.sex" :disabled="!isEditing">
                        <option v-for="option in sexOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">AGE</label>
                    <input type="text" class="input-field text-color" :value="calculatedAge" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOOD TYPE</label>
                    <select class="input-field" v-model="fields.bloodType" :disabled="!isEditing">
                        <option v-for="option in bloodTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">HEIGHT(M) <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" class="input-field" v-model="fields.height" :disabled="!isEditing" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">WEIGHT(KG) <span style="color: red;">*</span></label>
                    <input type="number" class="input-field" v-model="fields.weight" :disabled="!isEditing" />
                </div>
            </div>
                </div>

            </TabPanel>
            <TabPanel header="ADDRESS" :active="activeSubTab === 'address'">
              <!-- Address Fields -->
              <h1 style="font-size: 25px; font-weight: bold; margin-bottom: 3%; margin-top: 1%;">PERMANENT ADDRESS</h1>
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">REGION <span style="color: red;">*</span></label>
                  <select class="input-field" v-model="fields.Region" :disabled="!isEditing" @change="fetchProvinces()">
                    <option v-for="(region, index) in regions" :key="index" :value="region.reg_psgc">{{ region.col_region }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PROVINCE <span style="color: red;">*</span></label>
                  <select class="input-field" v-model="fields.Province" :disabled="!isEditing" @change="fetchCities()">
                    <option v-for="(province, index) in provinces" :key="index" :value="province.prv_psgc">{{ province.col_province }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CITY <span style="color: red;">*</span></label>
                  <select class="input-field" v-model="fields.City" :disabled="!isEditing"@change="fetchBarangays()">
                    <option v-for="(city, index) in cities" :key="index" :value="city.citmun_psgc">{{ city.col_citymuni }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BARANGAY <span style="color: red;">*</span></label>
                  <select class="input-field" v-model="fields.Barangay" :disabled="!isEditing">
                    <option v-for="(barangay, index) in barangays" :key="index" :value="barangay.brgy_psgc">{{ barangay.col_brgy }}</option>
                  </select>
                </div>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3" style="margin-top: 3%;">
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">ZIP CODE <span style="color: red;">*</span></label>
                    <input type="text" class="input-field addgrid" v-model="fields.zipcode" :disabled="!isEditing" />
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                    <input type="text" class="input-field addgrid" v-model="fields.block" :disabled="!isEditing" />
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">VILLAGE SUBDIVISION</label>
                    <input type="text" class="input-field addgrid" v-model="fields.villsub" :disabled="!isEditing" />
                  </div>
                </div>
              <span class="broken-line"></span>
              <!--CHECK BOX HERE TO COPY PASTE PERMANENT ADD to CURRENT ADD-->
<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------->
              <div class="checkbox"  style="width: 100%;">
                <h1 style="font-size: 25px; font-weight: bold; margin-right: 40%;">CURRENT ADDRESS</h1>
                <label class="ml-2 text-sm font-bold text-gray-700">
                  <input type="checkbox" class="check" v-model="copyPermanentToCurrent" :disabled="!isEditing"/>
                  Copy Permanent Address
                </label>
              </div>
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2" style="margin-top: 2%;">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">REGION</label>
                  <select class="input-field" v-model="fields.Region2" :disabled="!isEditing" @change="fetchProvinces2()">
                    <option v-for="(region2, index) in regions2" :key="index" :value="region2.reg_psgc">{{ region2.col_region }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">PROVINCE</label>
                  <select class="input-field" v-model="fields.Province2" :disabled="!isEditing" @change="fetchCities2()">
                    <option v-for="(province2, index) in provinces2" :key="index" :value="province2.prv_psgc">{{ province2.col_province }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">CITY</label>
                  <select class="input-field" v-model="fields.City2" :disabled="!isEditing"@change="fetchBarangays2()">
                    <option v-for="(city2, index) in cities2" :key="index" :value="city2.citmun_psgc">{{ city2.col_citymuni }}</option>
                  </select>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">BARANGAY</label>
                  <select class="input-field" v-model="fields.Barangay2" :disabled="!isEditing">
                    <option v-for="(barangay2, index) in barangays2" :key="index" :value="barangay2.brgy_psgc">{{ barangay2.col_brgy }}</option>
                  </select>
                </div>
              </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3" style="margin-top: 3%;">
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">ZIP CODE</label>
                    <input type="text" class="input-field addgrid" v-model="fields.zipcode2" :disabled="!isEditing" />
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                    <input type="text" class="input-field addgrid" v-model="fields.block2" :disabled="!isEditing" />
                  </div>
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">VILLAGE SUBDIVISION</label>
                    <input type="text" class="input-field addgrid" v-model="fields.villsub2" :disabled="!isEditing" />
                  </div>
                </div>
            </TabPanel>
            <TabPanel header="SECURITY & CONTACT DETAILS" :active="activeSubTab === 'security'">
              <!-- Security & Contact Fields -->
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">
                    MOBILE NUMBER <span style="color: red;">*</span>
                  </label>
                  <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">+63 |</span>
                    <input type="text" class="input-field number-field pl-12" v-model="fields.mobilenum" maxlength="9" @input="validateMobileNumber" :disabled="!isEditing" />
                  </div>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER <span style="color: red;">*</span></label>
                  <input type="text" class="input-field" v-model="fields.telnum" maxlength="7" @input="validateTelephoneNumber" :disabled="!isEditing" />
                </div>
                <div>
                  <label class="block mb-2 text-sm font-bold text-gray-700">EMAIL ADDRESS <span style="color: red;">*</span></label>
                  <input type="text" class="input-field" v-model="fields.emailadd" :disabled="!isEditing" />
                </div>
              </div>
            </TabPanel>
          </TabView>
        </div>
        <Button label="EDIT" v-if="!isEditing" class="float-right px-8 py-2 mt-6 text-white bg-green-500 rounded-lg update-button" @click="toggleEditing" />
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
            <i class="mb-4 mt-4 text-4xl fas fa-circle-question" style="color: red;"></i>
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
              OK
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

    <!-- Crop Image Modal -->
    <div v-if="cropping" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
      <div class="w-full max-w-lg p-4 overflow-hidden transition-all transform bg-white rounded-lg">
        <h2 class="text-xl font-semibold text-center mb-4">Crop Your Image</h2>
        <div class="crop-container">
          <img ref="cropperImage" :src="cropperSrc" alt="Cropper Image" />
        </div>
        <div class="flex justify-center mt-4">
          <Button label="Crop" @click="cropImage" class="bg-blue-500 text-white mr-4" />
          <Button label="Cancel" @click="cancelCrop" class="bg-red-500 text-white" />
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

  methods: {

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

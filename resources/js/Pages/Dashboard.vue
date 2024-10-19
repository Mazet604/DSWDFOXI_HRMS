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
                <label class="block mb-1 text-sm font-medium text-gray-700">BIRTHDAY <span style="color: red;">*</span></label>
                <input class="w-full p-2 border border-gray-300 rounded-md" type="date" v-model="fields.birthday" :class="{ 'disabled-input': !isEditing }" :max="maxDate" :disabled="!isEditing"/>
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
                <input class="w-full p-2 border border-gray-300 rounded-md text-color" type="text" v-model="fields.age" disabled />
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

            <!--Address-->
            <div v-if="activeTab === 1" class="p-6 bg-white border-2 border-blue-800 rounded-lg">
              <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">RESIDENTIAL ADDRESS</h2>
              <div class="grid grid-cols-2 gap-4 mb-6">
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">REGION <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Region" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(region, index) in regions" :key="index" :value="region.reg_psgc">{{ region.col_region }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">PROVINCE <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Province" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(province, index) in provinces" :key="index" :value="province.prv_psgc">{{ province.col_province }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">CITY <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.City" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(city, index) in cities" :key="index" :value="city.citmun_psgc">{{ city.col_citymuni }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">BARANGAY <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Barangay" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(barangay, index) in barangays" :key="index" :value="barangay.brgy_psgc">{{ barangay.col_brgy }}</option>
                      </select>
                  </div>
              </div>

              <div class="grid grid-cols-3 gap-4 mb-6">
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">ZIP CODE <span style="color: red;">*</span></label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid number-field" @input="validateNumber('zipcode', 'fields')" type="text" v-model="fields.zipcode" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">VILLAGE SUBDIVISION</label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="fields.villsub" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">BLOCK/STREET/PUROK</label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="fields.block" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
                  </div>
              </div>

                  <!-- Align Checkbox to the Right -->
              <div class="flex justify-end mb-2">
                  <div class="flex items-center">
                      <input type="checkbox" id="sameAddressCheckbox" v-model="copyPermanentToCurrent" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" :disabled="!isEditing" />
                      <label for="sameAddressCheckbox" class="block ml-2 text-sm font-medium text-gray-700">Same Residential Address?</label>
                  </div>
              </div>

                  <!-- Current Address Section -->
              <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">PERMANENT ADDRESS</h2>
              <div class="grid grid-cols-2 gap-4 mb-6">
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">REGION <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Region2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(region2, index) in regions2" :key="index" :value="region2.reg_psgc">{{ region2.col_region }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">PROVINCE <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Province2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(province2, index) in provinces2" :key="index" :value="province2.prv_psgc">{{ province2.col_province }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">CITY <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.City2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(city2, index) in cities2" :key="index" :value="city2.citmun_psgc">{{ city2.col_citymuni }}</option>
                      </select>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">BARANGAY <span style="color: red;">*</span></label>
                      <select class="w-full p-2 border border-gray-300 rounded-md" v-model="fields.Barangay2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }">
                      <option v-for="(barangay2, index) in barangays2" :key="index" :value="barangay2.brgy_psgc">{{ barangay2.col_brgy }}</option>
                  </select>
                  </div>
              </div>

              <div class="grid grid-cols-3 gap-4 mb-6">
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">ZIP CODE <span style="color: red;">*</span></label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid number-field" @input="validateNumber('zipcode2', 'fields')" type="text" v-model="fields.zipcode2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">VILLAGE SUBDIVISION</label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="fields.villsub2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
                  </div>
                  <div>
                      <label class="block mb-1 text-sm font-medium text-gray-700">BLOCK/STREET/PUROK</label>
                      <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="fields.block2" :disabled="!isEditing" :class="{ 'disabled-input': !isEditing }"/>
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
import DashboardScripts from '@/Pages/Scripts/DashboardScripts.vue';
import ChangePass from './Auth/ChangePass.vue';

  export default {
      extends: DashboardScripts,
      components: {
          ChangePass,
      },

      data(){
        return{
          isChangePassModalVisible: false,
        }
      },
      methods: {
        showChangePassModal(){
          this.isChangePassModalVisible = true;
        }
      }
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

</style>

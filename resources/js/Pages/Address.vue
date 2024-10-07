<template><!-- Address Tab -->
        <div>
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
    </div>


</template>

<script> 
import axios from 'axios';
import Button from 'primevue/button';
import { ref, watch } from 'vue';

export default {
    components: {
        Button
    },

mounted() {
    console.log('Component mounted.')
},

    data() {
    return {
        copyPermanentToCurrent: false,
        fields: {
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

    watch: {
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

        saveProfile() {
            axios.patch('/employee/updateAddress', this.fields)
            .then(() => {
                this.isEditing = false;
                this.showUpdateDialog = false;
                this.showSuccessDialog = true;
            })
            .catch(error => {
                console.error('Error updating profile:', error);
            });
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
        hideSuccessDialog() {
            this.showSuccessDialog = false;
            this.isEditing = false;
        },

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

        },

        mounted() {
            this.fetchAddress();
            this.fetchAddress2();
        },

        created() {
            this.fetchRegions();
            this.fetchRegions2();
        },

    }
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

.update-button {
    margin-bottom: 20px;
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
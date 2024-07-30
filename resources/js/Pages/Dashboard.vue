<template>
    <AppLayout>
        <div class="grid w-full grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="col-span-1 relative">
                <div class="relative group" @mouseenter="isHovered = true" @mouseleave="isHovered = false">
                    <img
                        alt="Profile Picture"
                        class="w-full rounded-lg"
                        height="300"
                        src="/images/profile-picture.webp"
                        width="300"
                        :class="{ 'blur-md': !isUnblurred }"
                    />
                    <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300" :class="{ 'opacity-0': !isHovered, 'opacity-100': isHovered }">
                        <button @click="toggleBlur" class="p-2 bg-gray-800 bg-opacity-75 rounded-full">
                            <i class="fas fa-eye text-white text-4xl"></i>
                        </button>
                    </div>
                </div>
                <Button label="Upload Photo" class="w-full py-2 mt-4 text-white rounded-lg bg-gradient-to-r from-pink-500 to-purple-500" />
            </div>
            <div class="col-span-1 md:col-span-2">
                <h1 class="mb-4 text-3xl lg:text-5xl font-bold">HABIBI, ABDUL JABLE</h1>
                <p class="mb-4 text-gray-600">ADMINISTRATIVE ASSISTANT II</p>
                <div class="border-box">
                    <TabView v-model:activeIndex="activeTab" class="no-background">
                        <TabPanel header="PERSONAL INFO">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">USER NAME</label>
                                    <input type="text" class="input-field" v-model="fields.username.value" disabled placeholder="Disabled" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYEE ID</label>
                                    <input type="text" class="input-field" v-model="fields.employeeId.value" disabled placeholder="Disabled" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                    <input type="text" class="input-field" v-model="fields.firstName.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input type="text" class="input-field" v-model="fields.middleName.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME</label>
                                    <input type="text" class="input-field" v-model="fields.lastName.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">CITIZENSHIP</label>
                                    <input type="text" class="input-field" v-model="fields.citizenship.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BIRTHDAY</label>
                                    <input type="date" class="input-field" v-model="fields.birthday.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">PLACE OF BIRTH</label>
                                    <input type="text" class="input-field" v-model="fields.placeOfBirth.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SEX</label>
                                    <select class="input-field" v-model="selectedSex">
                                        <option v-for="option in sexOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">CIVIL STATUS</label>
                                    <select class="input-field" v-model="selectedCivilStatus">
                                        <option v-for="option in civilStatusOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">HEIGHT(M)</label>
                                    <input type="number" step="0.01" class="input-field" v-model="fields.height.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">WEIGHT(KG)</label>
                                    <input type="number" class="input-field" v-model="fields.weight.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOOD TYPE</label>
                                    <select class="input-field" v-model="selectedBloodType">
                                        <option v-for="option in bloodTypeOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="ADDRESS">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">REGION</label>
                                    <select class="input-field" v-model="selectedRegion">
                                        <option v-for="option in regionOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">PROVINCE</label>
                                    <select class="input-field" v-model="selectedProvince">
                                        <option v-for="option in provinceOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">CITY</label>
                                    <select class="input-field" v-model="selectedCity">
                                        <option v-for="option in cityOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">ZIP CODE</label>
                                    <input type="text" class="input-field" v-model="fields.zipcode.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                                    <input type="text" class="input-field" v-model="fields.block.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">VILLAGE SUBDIVISION</label>
                                    <input type="text" class="input-field" v-model="fields.villsub.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BARANGAY</label>
                                    <select class="input-field" v-model="selectedBarangay">
                                        <option v-for="option in barangayOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                                    </select>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="SECURITY & CONTACT DETAILS">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MOBILE NUMBER</label>
                                    <input type="text" class="input-field" v-model="fields.mobilenum.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                                    <input type="text" class="input-field" v-model="fields.telnum.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">EMAIL ADDRESS</label>
                                    <input type="text" class="input-field" v-model="fields.emailadd.value" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">PASSWORD</label>
                                    <input :type="showPassword ? 'text' : 'password'" class="input-field" v-model="fields.pass.value" />
                                    <div class="mt-2">
                                        <input type="checkbox" id="showPassword" v-model="showPassword">
                                        <label for="showPassword" class="ml-2 text-sm font-bold text-gray-700">Show Password</label>
                                    </div>
                                </div>
                            </div>
                        </TabPanel>
                    </TabView>
                </div>
                <Button label="UPDATE" class="float-right px-8 py-2 mt-6 text-white bg-green-500 rounded-lg update-button" @click="confirmUpdate" />
            </div>
        </div>

        <!-- Update Confirmation Modal -->
        <div v-if="showUpdateDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-4xl mb-4" style="color: red;"></i>
                        <h2 class="text-xl font-semibold mb-4">Are you sure you want to update?</h2>
                        <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
                    </div>
                    <div class="flex justify-center gap-4">
                        <button @click="hideUpdateDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="updateProfile" class="py-2 px-4 rounded bg-red-600 text-white hover:bg-red-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Success Modal -->
        <div v-if="showSuccessDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="fas fa-check-circle text-4xl mb-4" style="color: green;"></i>
                        <h2 class="text-xl font-semibold mb-4">Updated Successfully!</h2>
                        <p class="mb-4">Details have been successfully updated. Press 'Back' to continue.</p>
                    </div>
                    <div class="flex justify-center">
                        <button @click="hideSuccessDialog" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

const activeTab = ref(0);
const fields = ref({
    username: { label: 'User Name', type: 'text', value: 'AJHABIBI' },
    employeeId: { label: 'Employee ID', type: 'text', value: '11-0070' },
    firstName: { label: 'First Name', type: 'text', value: 'ABDUL' },
    middleName: { label: 'Middle Name', type: 'text', value: 'JABLE' },
    lastName: { label: 'Last Name', type: 'text', value: 'HABIBI' },
    citizenship: { label: 'Citizenship', type: 'text', value: 'FILIPINO' },
    birthday: { label: 'Birthday', type: 'date', value: '2000-11-01' },
    placeOfBirth: { label: 'Place of Birth', type: 'text', value: 'DAVAO CITY' },
    height: { label: 'Height (m)', type: 'number', value: 1.82 },
    weight: { label: 'Weight (kg)', type: 'number', value: 74 },
    zipcode: { label: 'Zip Code', type: 'number', value: 'N/A' },
    block: { label: 'BLOCK/STREET/PUROK', type: 'text', value: 'N/A' },
    villsub: { label: 'VILLAGE SUBDIVISION', type: 'text', value: 'N/A' },
    mobilenum: { label: 'MOBILE NUMBER', type: 'number', value: '09088184444' },
    telnum: { label: 'TELEPHONE NUMBER', type: 'number', value: '22222222' },
    emailadd: { label: 'EMAIL ADDRESS', type: 'text', value: 'ABJHABIBI@DSWD.GOV.PH' },
    pass: { label: 'PASSWORD', type: 'text', value: 'password' }
});

const sexOptions = ref([
    { label: 'MALE', value: 'MALE' },
    { label: 'FEMALE', value: 'FEMALE' }
]);

const civilStatusOptions = ref([
    { label: 'SINGLE', value: 'SINGLE' },
    { label: 'MARRIED', value: 'MARRIED' },
    { label: 'DIVORCED', value: 'DIVORCED' },
    { label: 'WIDOWED', value: 'WIDOWED' }
]);

const bloodTypeOptions = ref([
    { label: 'O+', value: 'O+' },
    { label: 'A+', value: 'A+' },
    { label: 'B+', value: 'B+' },
    { label: 'AB+', value: 'AB+' },
    { label: 'O-', value: 'O-' },
    { label: 'A-', value: 'A-' },
    { label: 'B-', value: 'B-' },
    { label: 'AB-', value: 'AB-' }
]);

const regionOptions = ref([
    { label: 'REGION I', value: 'REGION I' },
    { label: 'REGION II', value: 'REGION II' },
    { label: 'REGION III', value: 'REGION III' },
    { label: 'REGION IV', value: 'REGION IV' },
    { label: 'REGION V', value: 'REGION V' },
    { label: 'REGION VI', value: 'REGION VI' },
    { label: 'REGION VII', value: 'REGION VII' },
    { label: 'REGION VIII', value: 'REGION VIII' },
    { label: 'REGION IX', value: 'REGION IX' },
    { label: 'REGION X', value: 'REGION X' },
    { label: 'REGION XI', value: 'REGION XI' }
]);

const provinceOptions = ref([
    { label: 'DAVAO DE ORO', value: 'DAVAO DE ORO' },
    { label: 'DAVAO DEL NORTE', value: 'DAVAO DEL NORTE' },
    { label: 'DAVAO ORIENTAL', value: 'DAVAO ORIENTAL' },
    { label: 'DAVAO DEL SUR', value: 'DAVAO DEL SUR' },
    { label: 'DAVAO OCCIDENTAL', value: 'DAVAO OCCIDENTAL' }
]);

const cityOptions = ref([
    { label: 'PANABO', value: 'PANABO' },
    { label: 'SAMAL', value: 'SAMAL' },
    { label: 'TAGUM', value: 'TAGUM' },
    { label: 'DAVAO', value: 'DAVAO' },
    { label: 'MATI', value: 'MATI' }
]);

const barangayOptions = ref([
    { label: 'MAA', value: 'MAA' },
    { label: 'MATINA', value: 'MATINA' },
    { label: 'LANGUB', value: 'LANGUB' }
]);

const selectedSex = ref(fields.value.sex?.value || null);
const selectedCivilStatus = ref(fields.value.civilStatus?.value || null);
const selectedBloodType = ref(null);
const selectedRegion = ref(null);
const selectedProvince = ref(null);
const selectedCity = ref(null);
const selectedBarangay = ref(null);

const showPassword = ref(false);

const showUpdateDialog = ref(false);
const showSuccessDialog = ref(false);

const confirmUpdate = () => {
    showUpdateDialog.value = true;
};

const hideUpdateDialog = () => {
    showUpdateDialog.value = false;
};

const hideSuccessDialog = () => {
    showSuccessDialog.value = false;
};

const updateProfile = () => {
    hideUpdateDialog();
    showSuccessDialog.value = true;
};

// Blur logic
const isHovered = ref(false);
const isUnblurred = ref(false);

const toggleBlur = () => {
    isUnblurred.value = !isUnblurred.value;
};
</script>

<style scoped>
.bg-cover {
    background-size: cover;
}

.bg-center {
    background-position: center;
}

.border-box {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: none; /* Removed shadow */
}

.input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.update-button {
    margin-bottom: 20px; /* Add space from the border */
}

.blur-md {
    filter: blur(8px);
}
</style>

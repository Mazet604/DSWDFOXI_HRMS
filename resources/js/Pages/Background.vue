<template>
    <AppLayout>
        <div class="w-full">
            <h1 class="mb-4 text-3xl font-bold">BACKGROUND</h1>
            <div class="border-box">
                <TabView v-model:activeIndex="activeTab" class="no-background">
                    <TabPanel header="FAMILY">
                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">SPOUSE SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseSurname.value" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseFirstName.value" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseMiddleName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseExtName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">OCCUPATION</label>
                                <input class="input-field" type="text" v-model="fields.spouseOccupation.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYERS/BUSINESS NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">BUSINESS ADDRESS</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessAddress.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">TEL. NO.</label>
                                <input class="input-field" type="text" v-model="fields.spouseTelNo.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherSurname.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherFirstName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherMiddleName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherExtName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S MAIDEN NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMaidenName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.motherSurname.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherFirstName.value"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMiddleName.value"/>
                            </div>
                        </div>
                    </TabPanel>
                    <TabPanel header="EDUCATION">
                        <DataTable :value="educationData" class="mt-8" :paginator="true" :rows="5">
                            <Column field="level" header="LEVEL OF EDUCATION"></Column>
                            <Column field="school" header="NAME OF SCHOOL"></Column>
                            <Column field="course" header="BASIC EDUCATION|DEGREE|COURSE"></Column>
                            <Column field="dates" header="INCLUSIVE DATES (FROM - TO)"></Column>
                            <Column field="highestLevel" header="HIGHEST LEVEL EARNED"></Column>
                            <Column field="yearGraduated" header="YEAR GRADUATED"></Column>
                            <Column field="scholarships" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="ORGANIZATION">
                        <DataTable :value="organizationData" class="mt-8" :paginator="true" :rows="5">
                            <Column field="level" header="LEVEL OF EDUCATION"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="WORK EXPERIENCE">
                        <DataTable :value="workExperienceData" class="mt-8" :paginator="true" :rows="5">
                            <Column field="dates" header="INCLUSIVE DATES (FROM - TO)"></Column>
                            <Column field="position" header="POSITION"></Column>
                            <Column field="department" header="DEPARTMENT|AGENCY|OFFICE|COMPANY"></Column>
                            <Column field="salary" header="MONTHLY SALARY"></Column>
                            <Column field="grade" header="SALARY GRADE"></Column>
                            <Column field="appointment" header="STATUS OF APPOINTMENT"></Column>
                            <Column field="govService" header="GOV'T SERVICE"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="SKILLS">
                        <DataTable :value="skillsData" class="mt-8" :paginator="true" :rows="5">
                            <Column field="skill" header="SKILLS"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="REFERENCES">
                        <DataTable :value="referencesData" class="mt-8" :paginator="true" :rows="5">
                            <Column field="fullName" header="FULL NAME"></Column>
                            <Column field="address" header="ADDRESS"></Column>
                            <Column field="phone" header="TELEPHONE NUMBER"></Column>
                        </DataTable>
                    </TabPanel>
                </TabView>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="confirmAdd" />
                <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
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

        <!-- Add Education Modal -->
        <div v-if="showAddEducationDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Education</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">LEVEL OF EDUCATION</label>
                            <input class="input-field" type="text" v-model="newEducation.level" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">NAME OF SCHOOL</label>
                            <input class="input-field" type="text" v-model="newEducation.school" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">BASIC EDUCATION|DEGREE|COURSE</label>
                            <input class="input-field" type="text" v-model="newEducation.course" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (FROM - TO)</label>
                            <input class="input-field" type="text" v-model="newEducation.dates" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">HIGHEST LEVEL EARNED</label>
                            <input class="input-field" type="text" v-model="newEducation.highestLevel" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">YEAR GRADUATED</label>
                            <input class="input-field" type="text" v-model="newEducation.yearGraduated" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                            <input class="input-field" type="text" v-model="newEducation.scholarships" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddEducationDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addEducation" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Organization Modal -->
        <div v-if="showAddOrganizationDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Organization</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">LEVEL OF EDUCATION</label>
                            <input class="input-field" type="text" v-model="newOrganization.level" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddOrganizationDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addOrganization" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Work Experience Modal -->
        <div v-if="showAddWorkExperienceDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Work Experience</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (FROM - TO)</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.dates" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">POSITION</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.position" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">DEPARTMENT|AGENCY|OFFICE|COMPANY</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.department" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">MONTHLY SALARY</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.salary" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">SALARY GRADE</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.grade" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">STATUS OF APPOINTMENT</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.appointment" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">GOV'T SERVICE</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.govService" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddWorkExperienceDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addWorkExperience" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Skills Modal -->
        <div v-if="showAddSkillsDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Skills</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">SKILLS</label>
                            <input class="input-field" type="text" v-model="newSkill.skill" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddSkillsDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addSkill" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add References Modal -->
        <div v-if="showAddReferencesDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Reference</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">FULL NAME</label>
                            <input class="input-field" type="text" v-model="newReference.fullName" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">ADDRESS</label>
                            <input class="input-field" type="text" v-model="newReference.address" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                            <input class="input-field" type="text" v-model="newReference.phone" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddReferencesDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addReference" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update/Add Success Modal -->
        <div v-if="showSuccessDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="fas fa-check-circle text-4xl mb-4" style="color: green;"></i>
                        <h2 class="text-xl font-semibold mb-4">Added Successfully!</h2>
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
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const activeTab = ref(0);
const fields = ref({
    spouseSurname: { label: 'Spouse Surname', type: 'text', value: '' },
    spouseFirstName: { label: 'Spouse First Name', type: 'text', value: '' },
    spouseMiddleName: { label: 'Spouse Middle Name', type: 'text', value: '' },
    spouseExtName: { label: 'Spouse Ext. Name', type: 'text', value: '' },
    spouseOccupation: { label: 'Spouse Occupation', type: 'text', value: '' },
    spouseBusinessName: { label: 'Spouse Business Name', type: 'text', value: '' },
    spouseBusinessAddress: { label: 'Spouse Business Address', type: 'text', value: '' },
    spouseTelNo: { label: 'Spouse Tel. No.', type: 'text', value: '' },
    fatherSurname: { label: 'Father Surname', type: 'text', value: '' },
    fatherFirstName: { label: 'Father First Name', type: 'text', value: '' },
    fatherMiddleName: { label: 'Father Middle Name', type: 'text', value: '' },
    fatherExtName: { label: 'Father Ext. Name', type: 'text', value: '' },
    motherMaidenName: { label: 'Mother Maiden Name', type: 'text', value: '' },
    motherSurname: { label: 'Mother Surname', type: 'text', value: '' },
    motherFirstName: { label: 'Mother First Name', type: 'text', value: '' },
    motherMiddleName: { label: 'Mother Middle Name', type: 'text', value: '' },
});

const educationData = ref([
    { level: 'Example Level 1', school: 'Example School 1', course: 'Example Course 1', dates: '2020 - 2024', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2024, scholarships: 'Scholarship Example 1' },
    { level: 'Example Level 2', school: 'Example School 2', course: 'Example Course 2', dates: '2018 - 2022', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2022, scholarships: 'Scholarship Example 2' },
    { level: 'Example Level 3', school: 'Example School 3', course: 'Example Course 3', dates: '2016 - 2020', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2020, scholarships: 'Scholarship Example 3' },
    { level: 'Example Level 4', school: 'Example School 4', course: 'Example Course 4', dates: '2014 - 2018', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2018, scholarships: 'Scholarship Example 4' },
    { level: 'Example Level 5', school: 'Example School 5', course: 'Example Course 5', dates: '2012 - 2016', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2016, scholarships: 'Scholarship Example 5' },
    { level: 'Example Level 6', school: 'Example School 6', course: 'Example Course 6', dates: '2010 - 2014', highestLevel: 'Bachelor\'s Degree', yearGraduated: 2014, scholarships: 'Scholarship Example 6' },
]);

const organizationData = ref([
    { level: 'Example Level 1' },
    { level: 'Example Level 2' },
    { level: 'Example Level 3' },
    { level: 'Example Level 4' },
    { level: 'Example Level 5' },
    { level: 'Example Level 6' },
]);

const workExperienceData = ref([
    { dates: '2019 - 2020', position: 'Position 1', department: 'Department 1', salary: '1000', grade: '1', appointment: 'Appointment 1', govService: 'Yes' },
    { dates: '2018 - 2019', position: 'Position 2', department: 'Department 2', salary: '2000', grade: '2', appointment: 'Appointment 2', govService: 'No' },
    { dates: '2017 - 2018', position: 'Position 3', department: 'Department 3', salary: '3000', grade: '3', appointment: 'Appointment 3', govService: 'Yes' },
    { dates: '2016 - 2017', position: 'Position 4', department: 'Department 4', salary: '4000', grade: '4', appointment: 'Appointment 4', govService: 'No' },
    { dates: '2015 - 2016', position: 'Position 5', department: 'Department 5', salary: '5000', grade: '5', appointment: 'Appointment 5', govService: 'Yes' },
    { dates: '2014 - 2015', position: 'Position 6', department: 'Department 6', salary: '6000', grade: '6', appointment: 'Appointment 6', govService: 'No' },
]);

const skillsData = ref([
    { skill: 'Skill 1' },
    { skill: 'Skill 2' },
    { skill: 'Skill 3' },
    { skill: 'Skill 4' },
    { skill: 'Skill 5' },
    { skill: 'Skill 6' },
]);

const referencesData = ref([
    { fullName: 'Full Name 1', address: 'Address 1', phone: 'Phone 1' },
    { fullName: 'Full Name 2', address: 'Address 2', phone: 'Phone 2' },
    { fullName: 'Full Name 3', address: 'Address 3', phone: 'Phone 3' },
    { fullName: 'Full Name 4', address: 'Address 4', phone: 'Phone 4' },
    { fullName: 'Full Name 5', address: 'Address 5', phone: 'Phone 5' },
    { fullName: 'Full Name 6', address: 'Address 6', phone: 'Phone 6' },
]);

const showUpdateDialog = ref(false);
const showAddEducationDialog = ref(false);
const showAddOrganizationDialog = ref(false);
const showAddWorkExperienceDialog = ref(false);
const showAddSkillsDialog = ref(false);
const showAddReferencesDialog = ref(false);
const showSuccessDialog = ref(false);

const newEducation = ref({
    level: '',
    school: '',
    course: '',
    dates: '',
    highestLevel: '',
    yearGraduated: '',
    scholarships: ''
});

const newOrganization = ref({
    level: ''
});

const newWorkExperience = ref({
    dates: '',
    position: '',
    department: '',
    salary: '',
    grade: '',
    appointment: '',
    govService: ''
});

const newSkill = ref({
    skill: ''
});

const newReference = ref({
    fullName: '',
    address: '',
    phone: ''
});

const confirmUpdate = () => {
    showUpdateDialog.value = true;
};

const hideUpdateDialog = () => {
    showUpdateDialog.value = false;
};

const confirmAdd = () => {
    switch (activeTab.value) {
        case 1:
            showAddEducationDialog.value = true;
            break;
        case 2:
            showAddOrganizationDialog.value = true;
            break;
        case 3:
            showAddWorkExperienceDialog.value = true;
            break;
        case 4:
            showAddSkillsDialog.value = true;
            break;
        case 5:
            showAddReferencesDialog.value = true;
            break;
        default:
            break;
    }
};

const hideAddEducationDialog = () => {
    showAddEducationDialog.value = false;
};

const hideAddOrganizationDialog = () => {
    showAddOrganizationDialog.value = false;
};

const hideAddWorkExperienceDialog = () => {
    showAddWorkExperienceDialog.value = false;
};

const hideAddSkillsDialog = () => {
    showAddSkillsDialog.value = false;
};

const hideAddReferencesDialog = () => {
    showAddReferencesDialog.value = false;
};

const hideSuccessDialog = () => {
    showSuccessDialog.value = false;
};

const updateProfile = () => {
    hideUpdateDialog();
    showSuccessDialog.value = true;
};

const addEducation = () => {
    educationData.value.push({ ...newEducation.value });
    hideAddEducationDialog();
    showSuccessDialog.value = true;
};

const addOrganization = () => {
    organizationData.value.push({ ...newOrganization.value });
    hideAddOrganizationDialog();
    showSuccessDialog.value = true;
};

const addWorkExperience = () => {
    workExperienceData.value.push({ ...newWorkExperience.value });
    hideAddWorkExperienceDialog();
    showSuccessDialog.value = true;
};

const addSkill = () => {
    skillsData.value.push({ ...newSkill.value });
    hideAddSkillsDialog();
    showSuccessDialog.value = true;
};

const addReference = () => {
    referencesData.value.push({ ...newReference.value });
    hideAddReferencesDialog();
    showSuccessDialog.value = true;
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
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 16px;
    background-color: white;
}

.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
}

@media (max-width: 640px) {
    .fixed {
        position: static;
    }
}
</style>

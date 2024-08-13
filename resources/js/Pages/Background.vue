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
                                <input class="input-field" type="text" v-model="fields.spouseSurname.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseFirstName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseMiddleName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseExtName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">OCCUPATION</label>
                                <input class="input-field" type="text" v-model="fields.spouseOccupation.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYERS/BUSINESS NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">BUSINESS ADDRESS</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessAddress.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">TEL. NO.</label>
                                <input class="input-field" type="text" v-model="fields.spouseTelNo.value" :disabled="!isEditingFamily" />
                            </div>
                            <br><br>
                            <div></div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherSurname.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherFirstName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">FATHER'S MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherMiddleName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherExtName.value" :disabled="!isEditingFamily" />
                            </div>
                            <br><br>
                            <div></div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S MAIDEN NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMaidenName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.motherSurname.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherFirstName.value" :disabled="!isEditingFamily" />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">MOTHER'S MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMiddleName.value" :disabled="!isEditingFamily" />
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <Button v-if="!isEditingFamily" label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleFamilyEditing" />
                            <div v-if="isEditingFamily" class="space-x-4">
                                <Button label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelFamilyEditing" />
                                <Button label="SAVE" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="updateFamilyData" />
                            </div>
                        </div>
                        
                        <br/>
                        <h1 style="font-size: 25px; font-weight: bold;">Child</h1>
                        <DataTable :value="childData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="full_name" header="Name of Child" :editor="inputEditor"></Column>
                            <Column field="age" header="Age" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="EDUCATION">
                        <DataTable :value="educationData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="educ_level" header="LEVEL OF EDUCATION" :editor="inputEditor"></Column>
                            <Column field="educ_school" header="NAME OF SCHOOL" :editor="inputEditor"></Column>
                            <Column field="educ_degree" header="BASIC EDUCATION|DEGREE|COURSE" :editor="inputEditor"></Column>
                            <Column field="educ_from" header="INCLUSIVE DATES (FROM - TO)" :editor="inputEditor"></Column>
                            <Column field="educ_hl_earned" header="HIGHEST LEVEL EARNED" :editor="inputEditor"></Column>
                            <Column field="educ_year_grad" header="YEAR GRADUATED" :editor="inputEditor"></Column>
                            <Column field="educ_academic_honor" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="ORGANIZATION">
                        <DataTable :value="organizationData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="org_name" header="Organizations" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="WORK EXPERIENCE">
                        <DataTable :value="workExperienceData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="workfr" header="INCLUSIVE DATES (FROM)" :editor="inputEditor"></Column>
                            <Column field="workto" header="INCLUSIVE DATES (TO)" :editor="inputEditor"></Column>
                            <Column field="work_pos" header="POSITION" :editor="inputEditor"></Column>
                            <Column field="work_dept" header="DEPARTMENT|AGENCY|OFFICE|COMPANY" :editor="inputEditor"></Column>
                            <Column field="work_salary" header="MONTHLY SALARY" :editor="inputEditor"></Column>
                            <Column field="work_salarygrade" header="SALARY GRADE" :editor="inputEditor"></Column>
                            <Column field="work_stat" header="STATUS OF APPOINTMENT" :editor="inputEditor"></Column>
                            <Column field="work_gov" header="GOV'T SERVICE" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="SKILLS">
                        <DataTable :value="skillsData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="skill" header="SKILLS" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="REFERENCES">
                        <DataTable :value="referencesData" class="mt-8" :paginator="true" :rows="5" editable>
                            <Column field="full_name" header="FULL NAME" :editor="inputEditor"></Column>
                            <Column field="ref_add" header="ADDRESS" :editor="inputEditor"></Column>
                            <Column field="ref_cnum" header="TELEPHONE NUMBER" :editor="inputEditor"></Column>
                        </DataTable>
                    </TabPanel>
                </TabView>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="openAddDialog" />
                <Button v-if="!isEditingProfile" label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleProfileEditing" />
                <div v-if="isEditingProfile" class="space-x-4">
                    <Button label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelProfileEditing" />
                    <Button label="SAVE" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="updateProfile" />
                </div>
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
                        <button @click="saveProfile" class="py-2 px-4 rounded bg-red-600 text-white hover:bg-red-700">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Child Modal -->
        <div v-if="showAddChildDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Child</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Child First Name</label>
                            <input class="input-field" type="text" v-model="newChild.child_fname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Child Middle Name</label>
                            <input class="input-field" type="text" v-model="newChild.child_mname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Child Last Name</label>
                            <input class="input-field" type="text" v-model="newChild.child_lname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Child Extension Name</label>
                            <input class="input-field" type="text" v-model="newChild.child_xname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">Child Birth Date</label>
                            <input class="input-field" type="date" v-model="newChild.child_dob" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddChildDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addChild" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
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
                            <input class="input-field" type="text" v-model="newEducation.educ_level" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">NAME OF SCHOOL</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_school" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">BASIC EDUCATION|DEGREE|COURSE</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_degree" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (FROM)</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_from" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">HIGHEST LEVEL EARNED</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_hl_earned" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">YEAR GRADUATED</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_year_grad" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                            <input class="input-field" type="text" v-model="newEducation.educ_academic_honor" />
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
                            <label class="block mb-2 text-sm font-bold text-gray-700">ORGANIZATION NAME</label>
                            <input class="input-field" type="text" v-model="newOrganization.org_name" />
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
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (FROM)</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.workfr" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (TO)</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.workto" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">POSITION</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_pos" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">DEPARTMENT|AGENCY|OFFICE|COMPANY</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_dept" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">MONTHLY SALARY</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_salary" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">SALARY GRADE</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_salarygrade" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">STATUS OF APPOINTMENT</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_stat" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">GOV'T SERVICE</label>
                            <input class="input-field" type="text" v-model="newWorkExperience.work_gov" />
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
                            <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                            <input class="input-field" type="text" v-model="newReference.ref_fname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE INITIAL</label>
                            <input class="input-field" type="text" v-model="newReference.ref_mname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME</label>
                            <input class="input-field" type="text" v-model="newReference.ref_lname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">EXTENSION NAME</label>
                            <input class="input-field" type="text" v-model="newReference.ref_xname" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">ADDRESS</label>
                            <input class="input-field" type="text" v-model="newReference.ref_add" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                            <input class="input-field" type="text" v-model="newReference.ref_cnum" />
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

        <!-- Success Modal -->
        <div v-if="showSuccessDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="fas fa-check-circle text-4xl mb-4" style="color: green;"></i>
                        <h2 class="text-xl font-semibold mb-4">Updated Successfully!</h2>
                        <p class="mb-4">Details have been successfully updated. Press 'Back' to continue.</p>
                    </div>
                    <div class="flex justify-center">
                        <button @click="showSuccessDialog = false" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
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
import { ref, onMounted, h } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

export default {
    components: {
        AppLayout, Button, DataTable, Column
    },
    setup() {
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
            motherMiddleName: { label: 'Mother Middle Name', type: 'text', value: '' }
        });

        const isEditingFamily = ref(false);
        const originalFamilyFields = ref({});

        const toggleFamilyEditing = () => {
            if (!isEditingFamily.value) {
                originalFamilyFields.value = JSON.parse(JSON.stringify(fields.value));
            }
            isEditingFamily.value = !isEditingFamily.value;
        };

        const cancelFamilyEditing = () => {
            fields.value = JSON.parse(JSON.stringify(originalFamilyFields.value));
            isEditingFamily.value = false;
        };

        const isEditingProfile = ref(false);
        const originalProfileFields = ref({});

        const toggleProfileEditing = () => {
            if (!isEditingProfile.value) {
                originalProfileFields.value = JSON.parse(JSON.stringify(fields.value));
            }
            isEditingProfile.value = !isEditingProfile.value;
        };

        const cancelProfileEditing = () => {
            fields.value = JSON.parse(JSON.stringify(originalProfileFields.value));
            isEditingProfile.value = false;
        };

        const childData = ref([]);
        const newChild = ref({
            child_fname: '',
            child_mname: '',
            child_lname: '',
            child_xname: '',
            child_dob: ''
        });

        const educationData = ref([]);
        const organizationData = ref([]);
        const workExperienceData = ref([]);
        const skillsData = ref([]);
        const referencesData = ref([]);
        const newEducation = ref({
            educ_level: '',
            educ_school: '',
            educ_degree: '',
            educ_from: '',
            educ_hl_earned: '',
            educ_year_grad: '',
            educ_academic_honor: ''
        });

        const newOrganization = ref({
            org_name: ''
        });

        const newWorkExperience = ref({
            workfr: '',
            workto: '',
            work_pos: '',
            work_dept: '',
            work_salary: '',
            work_salarygrade: '',
            work_stat: '',
            work_gov: ''
        });

        const newSkill = ref({
            skill: ''
        });

        const newReference = ref({
            ref_fname: '',
            ref_mname: '',
            ref_lname: '',
            ref_xname: '',
            ref_add: '',
            ref_cnum: ''
        });

        const showAddEducationDialog = ref(false);
        const showAddOrganizationDialog = ref(false);
        const showAddWorkExperienceDialog = ref(false);
        const showAddSkillsDialog = ref(false);
        const showAddReferencesDialog = ref(false);
        const showAddChildDialog = ref(false);
        const showSuccessDialog = ref(false);
        const showUpdateDialog = ref(false);

        const openAddDialog = () => {
            if (activeTab.value === 0) {
                showAddChildDialog.value = true;
            } else if (activeTab.value === 1) {
                showAddEducationDialog.value = true;
            } else if (activeTab.value === 2) {
                showAddOrganizationDialog.value = true;
            } else if (activeTab.value === 3) {
                showAddWorkExperienceDialog.value = true;
            } else if (activeTab.value === 4) {
                showAddSkillsDialog.value = true;
            } else if (activeTab.value === 5) {
                showAddReferencesDialog.value = true;
            }
        };

        const fetchEducationData = async () => {
            try {
                const response = await axios.get('/education/EducationData');
                educationData.value = response.data;
            } catch (error) {
                console.error('Error fetching education data:', error);
            }
        };

        const fetchOrganizationData = async () => {
            try {
                const response = await axios.get('/emp_org/OrganizationData');
                organizationData.value = response.data;
            } catch (error) {
                console.error('Error fetching organization data:', error);
            }
        };

        const fetchWorkExperienceData = async () => {
            try {
                const response = await axios.get('/emp_work/WorkExperienceData');
                workExperienceData.value = response.data;
            } catch (error) {
                console.error('Error fetching work experience data:', error);
            }
        };

        const fetchSkillsData = async () => {
            try {
                const response = await axios.get('/emp_skills/SkillsData');
                skillsData.value = response.data;
            } catch (error) {
                console.error('Error fetching skills data:', error);
            }
        };

        const fetchReferencesData = async () => {
            try {
                const response = await axios.get('/emp_reference/ReferencesData');
                referencesData.value = response.data;
            } catch (error) {
                console.error('Error fetching references data:', error);
            }
        };

        const fetchChildData = async () => {
            try {
                const response = await axios.get('/emp_child/ChildData');
                childData.value = response.data;
            } catch (error) {
                console.error('Error fetching child data:', error);
            }
        };

        const addEducation = async () => {
            try {
                const response = await axios.post('/education/AddEducationData', newEducation.value);
                educationData.value.push(response.data);
                showAddEducationDialog.value = false;
                showSuccessDialog.value = true;
                clearNewEducationForm();
            } catch (error) {
                console.error('Error adding education data:', error);
            }
        };

        const addOrganization = async () => {
            try {
                const response = await axios.post('/emp_org/AddOrganizationData', newOrganization.value);
                organizationData.value.push(response.data);
                showAddOrganizationDialog.value = false;
                showSuccessDialog.value = true;
                clearNewOrganizationForm();
            } catch (error) {
                console.error('Error adding organization data:', error);
            }
        };

        const addWorkExperience = async () => {
            try {
                const response = await axios.post('/emp_work/AddWorkExperienceData', newWorkExperience.value);
                workExperienceData.value.push(response.data);
                showAddWorkExperienceDialog.value = false;
                showSuccessDialog.value = true;
                clearNewWorkExperienceForm();
            } catch (error) {
                console.error('Error adding work experience data:', error);
            }
        };

        const addSkill = async () => {
            try {
                const response = await axios.post('/emp_skills/AddSkillData', newSkill.value);
                skillsData.value.push(response.data);
                showAddSkillsDialog.value = false;
                showSuccessDialog.value = true;
                clearNewSkillForm();
            } catch (error) {
                console.error('Error adding skill data:', error);
            }
        };

        const addReference = async () => {
            try {
                const response = await axios.post('/emp_reference/AddReferenceData', newReference.value);
                referencesData.value.push(response.data);
                showAddReferencesDialog.value = false;
                showSuccessDialog.value = true;
                clearNewReferenceForm();
            } catch (error) {
                console.error('Error adding reference data:', error);
            }
        };

        const addChild = async () => {
            try {
                const response = await axios.post('/emp_child/AddChildData', newChild.value);
                childData.value.push(response.data);
                showAddChildDialog.value = false;
                showSuccessDialog.value = true;
                clearNewChildForm();
            } catch (error) {
                console.error('Error adding child data:', error);
            }
        };

        const clearNewChildForm = () => {
            newChild.value = {
                child_fname: '',
                child_mname: '',
                child_lname: '',
                child_xname: '',
                child_dob: ''
            };
        };

        const clearNewEducationForm = () => {
            newEducation.value = {
                educ_level: '',
                educ_school: '',
                educ_degree: '',
                educ_from: '',
                educ_hl_earned: '',
                educ_year_grad: '',
                educ_academic_honor: ''
            };
        };

        const clearNewOrganizationForm = () => {
            newOrganization.value = {
                org_name: ''
            };
        };

        const clearNewWorkExperienceForm = () => {
            newWorkExperience.value = {
                workfr: '',
                workto: '',
                work_pos: '',
                work_dept: '',
                work_salary: '',
                work_salarygrade: '',
                work_stat: '',
                work_gov: ''
            };
        };

        const clearNewSkillForm = () => {
            newSkill.value = {
                skill: ''
            };
        };

        const clearNewReferenceForm = () => {
            newReference.value = {
                ref_fname: '',
                ref_mname: '',
                ref_lname: '',
                ref_xname: '',
                ref_add: '',
                ref_cnum: ''
            };
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

        const confirmUpdate = () => {
            showUpdateDialog.value = true;
        };

        const hideUpdateDialog = () => {
            showUpdateDialog.value = false;
        };

        const updateProfile = async () => {
            try {
                if (activeTab.value === 0) {
                    await updateFamilyData();
                } else if (activeTab.value === 1) {
                    await axios.post('/education/UpdateEducationData', educationData.value);
                } else if (activeTab.value === 2) {
                    await axios.post('/emp_org/UpdateOrganizationData', organizationData.value);
                } else if (activeTab.value === 3) {
                    await axios.post('/emp_work/UpdateWorkExperienceData', workExperienceData.value);
                } else if (activeTab.value === 4) {
                    await axios.post('/emp_skills/UpdateSkillsData', skillsData.value);
                } else if (activeTab.value === 5) {
                    await axios.post('/emp_reference/UpdateReferencesData', referencesData.value);
                }
                showUpdateDialog.value = false;
                showSuccessDialog.value = true;
            } catch (error) {
                console.error('Error updating profile:', error);
                showUpdateDialog.value = false;
            }
        };

        const hideAddChildDialog = () => {
            showAddChildDialog.value = false;
        };

        const updateFamilyData = async () => {
            try {
                await axios.post('/emp_family/UpdateFamilyData', {
                    spouse: {
                        surname: fields.value.spouseSurname.value,
                        firstName: fields.value.spouseFirstName.value,
                        middleName: fields.value.spouseMiddleName.value,
                        extName: fields.value.spouseExtName.value,
                        occupation: fields.value.spouseOccupation.value,
                        businessName: fields.value.spouseBusinessName.value,
                        businessAddress: fields.value.spouseBusinessAddress.value,
                        telNo: fields.value.spouseTelNo.value,
                    },
                    father: {
                        surname: fields.value.fatherSurname.value,
                        firstName: fields.value.fatherFirstName.value,
                        middleName: fields.value.fatherMiddleName.value,
                        extName: fields.value.fatherExtName.value,
                    },
                    mother: {
                        maidenName: fields.value.motherMaidenName.value,
                        surname: fields.value.motherSurname.value,
                        firstName: fields.value.motherFirstName.value,
                        middleName: fields.value.motherMiddleName.value,
                    },
                    children: childData.value
                });
                showUpdateDialog.value = false;
                showSuccessDialog.value = true;
            } catch (error) {
                console.error('Error updating family data:', error);
                showUpdateDialog.value = false;
            }
        };

        const inputEditor = (slotProps) => {
            return h('input', {
                type: 'text',
                class: 'input-field',
                value: slotProps.data[slotProps.field],
                onInput: (event) => slotProps.data[slotProps.field] = event.target.value
            });
        };

        const searchQuery = ref('');

        const search = () => {
            const searchLower = searchQuery.value.toLowerCase();
            if (searchLower.includes('family')) {
                activeTab.value = 0;
            } else if (searchLower.includes('education')) {
                activeTab.value = 1;
            } else if (searchLower.includes('organization')) {
                activeTab.value = 2;
            } else if (searchLower.includes('work')) {
                activeTab.value = 3;
            } else if (searchLower.includes('skills')) {
                activeTab.value = 4;
            } else if (searchLower.includes('references')) {
                activeTab.value = 5;
            } else {
                alert('No matching tab found.');
            }
        };

        onMounted(() => {
            fetchEducationData();
            fetchOrganizationData();
            fetchWorkExperienceData();
            fetchSkillsData();
            fetchReferencesData();
            fetchChildData();
        });

        return {
            activeTab,
            fields,
            educationData,
            organizationData,
            workExperienceData,
            skillsData,
            referencesData,
            newEducation,
            newOrganization,
            newWorkExperience,
            newSkill,
            newReference,
            showAddEducationDialog,
            showAddOrganizationDialog,
            showAddWorkExperienceDialog,
            showAddSkillsDialog,
            showAddReferencesDialog,
            showSuccessDialog,
            showUpdateDialog,
            addEducation,
            addOrganization,
            addWorkExperience,
            addSkill,
            addReference,
            clearNewEducationForm,
            clearNewOrganizationForm,
            clearNewWorkExperienceForm,
            clearNewSkillForm,
            clearNewReferenceForm,
            openAddDialog,
            hideAddEducationDialog,
            hideAddOrganizationDialog,
            hideAddWorkExperienceDialog,
            hideAddSkillsDialog,
            hideAddReferencesDialog,
            fetchEducationData,
            fetchOrganizationData,
            fetchWorkExperienceData,
            fetchSkillsData,
            fetchReferencesData,
            updateProfile,
            searchQuery,
            search,
            childData,
            newChild,
            showAddChildDialog,
            showSuccessDialog,
            showUpdateDialog,
            addChild,
            clearNewChildForm,
            hideAddChildDialog,
            hideSuccessDialog,
            confirmUpdate,
            hideUpdateDialog,
            updateFamilyData,
            inputEditor,
            isEditingFamily,
            toggleFamilyEditing,
            cancelFamilyEditing,
            isEditingProfile,
            toggleProfileEditing,
            cancelProfileEditing
        };
    }
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

.custom-cancel-button {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.custom-cancel-button:hover {
    background-color: #e57373 !important;
    border-color: #e57373 !important;
}
</style>

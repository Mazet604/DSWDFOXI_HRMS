<template>
    <AppLayout>
        <div class="w-full">
            <h1 class="mb-4 text-3xl font-bold">BACKGROUND</h1>
            <div class="border-box">
                <TabView v-model:activeIndex="activeTab" class="no-background">
                    <TabPanel header="FAMILY">
                        <div class="grid grid-cols-5 gap-4 mt-8">
                            <div class="col-span-5">
                                <h1 style="font-size: 25px; font-weight: bold;">Spouse</h1>
                            </div>
                            <!-- Spouse Information -->
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseSurname" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseFirstName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseMiddleName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseExtName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">OCCUPATION</label>
                                <input class="input-field" type="text" v-model="fields.spouseOccupation" :disabled="!isEditingFamily" />
                            </div>
                            <!-- Employer/Business Information -->
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYER'S/BUSINESS NAME</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-bold text-gray-700">BUSINESS ADDRESS</label>
                                <input class="input-field" type="text" v-model="fields.spouseBusinessAddress" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">TEL. NO.</label>
                                <input class="input-field" type="text" v-model="fields.spouseTelNo" :disabled="!isEditingFamily" />
                            </div>
                            <!-- Separator for Father's Information -->
                            <div class="col-span-5">
                                <h1 style="font-size: 25px; font-weight: bold;">Father</h1>
                            </div>
                            <!-- Father's Information -->
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherSurname" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherFirstName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherMiddleName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">EXT. NAME</label>
                                <input class="input-field" type="text" v-model="fields.fatherExtName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1"></div> <!-- Empty space for alignment -->
                            <!-- Separator for Mother's Information -->
                            <div class="col-span-5">
                                <h1 style="font-size: 25px; font-weight: bold;">Mother</h1>
                            </div>
                            <!-- Mother's Information -->
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                <input class="input-field" type="text" v-model="fields.motherSurname" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherFirstName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMiddleName" :disabled="!isEditingFamily" />
                            </div>
                            <div class="col-span-1">
                                <label class="block mb-2 text-sm font-bold text-gray-700">MAIDEN NAME</label>
                                <input class="input-field" type="text" v-model="fields.motherMaidenName" :disabled="!isEditingFamily" />
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
                        <button @click="hideSuccessDialog" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            OK
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

    data() {
        return {
            fullName: '',
            empPosition: '',
            profilePictureUrl: '',
            fields: {
                spouseSurname: '',
                spouseFirstName: '',
                spouseMiddleName: '',
                spouseExtName: '',
                spouseOccupation: '',
                spouseBusinessName: '',
                spouseBusinessAddress: '',
                spouseTelNo: '',
                fatherSurname: '',
                fatherFirstName: '',
                fatherMiddleName: '',
                fatherExtName: '',
                motherMaidenName: '',
                motherSurname: '',
                motherFirstName: '',
                motherMiddleName: ''
            },
            isEditingFamily: false,
            originalFamilyFields: {},
            isEditingProfile: false,
            originalProfileFields: {},
            childData: [],
            newChild: {
                child_fname: '',
                child_mname: '',
                child_lname: '',
                child_xname: '',
                child_dob: ''
            },
            educationData: [],
            organizationData: [],
            workExperienceData: [],
            skillsData: [],
            referencesData: [],
            newEducation: {
                educ_level: '',
                educ_school: '',
                educ_degree: '',
                educ_from: '',
                educ_hl_earned: '',
                educ_year_grad: '',
                educ_academic_honor: ''
            },
            newOrganization: {
                org_name: ''
            },
            newWorkExperience: {
                workfr: '',
                workto: '',
                work_pos: '',
                work_dept: '',
                work_salary: '',
                work_salarygrade: '',
                work_stat: '',
                work_gov: ''
            },
            newSkill: {
                skill: ''
            },
            newReference: {
                ref_fname: '',
                ref_mname: '',
                ref_lname: '',
                ref_xname: '',
                ref_add: '',
                ref_cnum: ''
            },
            showAddEducationDialog: false,
            showAddOrganizationDialog: false,
            showAddWorkExperienceDialog: false,
            showAddSkillsDialog: false,
            showAddReferencesDialog: false,
            showAddChildDialog: false,
            showSuccessDialog: false,
            showUpdateDialog: false
        };
    },

    methods: {
        toggleFamilyEditing() {
            if (!this.isEditingFamily) {
                // Save the current state of fields to allow canceling
                this.originalFamilyFields = JSON.parse(JSON.stringify(this.fields));
            }
            this.isEditingFamily = !this.isEditingFamily;
        },

        cancelFamilyEditing() {
            // Revert changes by restoring original fields
            this.fields = JSON.parse(JSON.stringify(this.originalFamilyFields));
            this.isEditingFamily = false;
        },

        async fetchFather() {
            try {
                const response = await axios.get('/emp_father/Father');
                this.fields.fatherSurname = response.data.fatherSurname;
                this.fields.fatherFirstName = response.data.fatherFirstName;
                this.fields.fatherMiddleName = response.data.fatherMiddleName;
                this.fields.fatherExtName = response.data.fatherExtName;
            } catch (error) {
                this.errorMessage = 'Failed to load father.';
            }
        },

        async fetchMother() {
            try {
                const response = await axios.get('/emp_mother/Mother');
                this.fields.motherMaidenName = response.data.motherMaidenName;
                this.fields.motherSurname = response.data.motherSurname;
                this.fields.motherFirstName = response.data.motherFirstName;
                this.fields.motherMiddleName = response.data.motherMiddleName;
            } catch (error) {
                this.errorMessage = 'Failed to load mother.';
            }
        },

        async fetchSpouse() {
            try {
                const response = await axios.get('/emp_spouse/Spouse');
                this.fields.spouseSurname = response.data.spouseSurname;
                this.fields.spouseFirstName = response.data.spouseFirstName;
                this.fields.MiddleName = response.data.MiddleName;
                this.fields.ExtName = response.data.ExtName;
                this.fields.Occupation = response.data.Occupation;
                this.fields.spouseBusinessName = response.data.spouseBusinessName;
                this.fields.spouseBusinessAddress = response.data.spouseBusinessAddress;
                this.fields.spouseTelNo = response.data.spouseTelNo;
            } catch (error) {
                this.errorMessage = 'Failed to load spouse.';
            }
        },

        toggleProfileEditing() {
            if (!this.isEditingProfile) {
                // Save the current state of fields to allow canceling
                this.originalProfileFields = JSON.parse(JSON.stringify(this.fields));
            }
            this.isEditingProfile = !this.isEditingProfile;
        },

        cancelProfileEditing() {
            // Revert changes by restoring original fields
            this.fields = JSON.parse(JSON.stringify(this.originalProfileFields));
            this.isEditingProfile = false;
        },


        async updateFamilyData() {
            try {
                await axios.patch('/EmpFamily/updateFamilyData', this.fields);
                this.isEditing = false;
                this.showUpdateDialog = false;
                this.showSuccessDialog = true;
                } catch (error) {
                this.errorMessage = 'Failed to update Family. Please try again.';
                this.showUpdateDialog = false;
            }
                },

        openAddDialog() {
            if (this.activeTab === 0) {
                this.showAddChildDialog = true;
            } else if (this.activeTab === 1) {
                this.showAddEducationDialog = true;
            } else if (this.activeTab === 2) {
                this.showAddOrganizationDialog = true;
            } else if (this.activeTab === 3) {
                this.showAddWorkExperienceDialog = true;
            } else if (this.activeTab === 4) {
                this.showAddSkillsDialog = true;
            } else if (this.activeTab === 5) {
                this.showAddReferencesDialog = true;
            }
        }
    },

    mounted() {
        this.fetchFather();
        this.fetchMother();
        this.fetchSpouse();
    },

    setup() {
        const activeTab = ref(0);

        const isEditingProfile = ref(false);
        const originalProfileFields = ref({});

        const toggleProfileEditing = () => {
            if (!isEditingProfile.value) {
                originalProfileFields.value = JSON.parse(JSON.stringify(this.fields));
            }
            isEditingProfile.value = !isEditingProfile.value;
        };

        const cancelProfileEditing = () => {
            this.fields = JSON.parse(JSON.stringify(originalProfileFields.value));
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
            location.reload(); 
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
                    await axios.post('/emp_child/UpdateChildData', educationData.value);
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
            inputEditor,
            isEditingProfile,
            toggleProfileEditing,
            cancelProfileEditing
        };
    }
};
</script>

<style scoped>
.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
}

.grid-cols-5 {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
}

.col-span-1 {
    grid-column: span 1 / span 1;
}

.col-span-2 {
    grid-column: span 2 / span 2;
}

.mt-8 {
    margin-top: 2rem;
}

.border-t-2 {
    border-top-width: 2px;
}

.my-4 {
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.text-lg {
    font-size: 1.125rem;
}

.font-semibold {
    font-weight: 600;
}

.custom-cancel-button {
  background-color: #dc3545 !important; /* Red background for cancel button */
  border-color: #dc3545 !important; /* Red border for cancel button */
}

.custom-cancel-button:hover {
  background-color: #e57373 !important; /* Lighter red for hover state */
  border-color: #e57373 !important; /* Lighter red border for hover state */
}
</style>
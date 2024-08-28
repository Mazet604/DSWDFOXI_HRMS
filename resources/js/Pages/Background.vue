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
                        <h1 style="font-size: 25px; font-weight: bold;">Child</h1>
                        <DataTable v-model:selection="selectedRow" :value="childData" class="mt-8" :paginator="true" :rows="5" @selection-change="onRowSelect">
                        <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                        <Column field="full_name" header="Name of Child"></Column>
                        <Column field="age" header="Age"></Column>
                        <Column field="child_dob" header="Date of Birth"></Column>
                    </DataTable>
                    </TabPanel>
                    <TabPanel header="EDUCATION">
                        <h1 style="font-size: 25px; font-weight: bold;">Education</h1>
                        <DataTable v-model:selection="selectedRow" :value="educationData" class="mt-8" :paginator="true" :rows="5">
                            <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                            <Column field="educ_level" header="LEVEL OF EDUCATION"></Column>
                            <Column field="educ_school" header="NAME OF SCHOOL"></Column>
                            <Column field="educ_degree" header="BASIC EDUCATION|DEGREE|COURSE"></Column>
                            <Column field="educ_from" header="INCLUSIVE DATES (FROM - TO)"></Column>
                            <Column field="educ_hl_earned" header="HIGHEST LEVEL EARNED"></Column>
                            <Column field="educ_year_grad" header="YEAR GRADUATED"></Column>
                            <Column field="educ_academic_honor" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="ORGANIZATION">
                    <h1 style="font-size: 25px; font-weight: bold;">Organization</h1>
                    <DataTable
                        v-model:selection="selectedRow"
                        :value="organizationData"
                        class="mt-8"
                        :paginator="true"
                        :rows="5"
                        @selection-change="onRowSelect"
                    >
                        <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                        <Column field="org_name" header="Organizations"></Column>
                    </DataTable>
                    </TabPanel>
                    <TabPanel header="WORK EXPERIENCE">
                        <h1 style="font-size: 25px; font-weight: bold;">Work Experience</h1>
                        <DataTable v-model:selection="selectedRow" :value="workExperienceData" class="mt-8" :paginator="true" :rows="5">
                            <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                            <Column field="workfr" header="INCLUSIVE DATES (FROM)"></Column>
                            <Column field="workto" header="INCLUSIVE DATES (TO)"></Column>
                            <Column field="work_pos" header="POSITION"></Column>
                            <Column field="work_dept" header="DEPARTMENT|AGENCY|OFFICE|COMPANY"></Column>
                            <Column field="work_salary" header="MONTHLY SALARY"></Column>
                            <Column field="work_salarygrade" header="SALARY GRADE"></Column>
                            <Column field="work_stat" header="STATUS OF APPOINTMENT"></Column>
                            <Column field="work_gov" header="GOV'T SERVICE"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="SKILLS">
                        <h1 style="font-size: 25px; font-weight: bold;">Skills</h1>
                        <DataTable v-model:selection="selectedRow" :value="skillsData" class="mt-8" :paginator="true" :rows="5">
                            <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                            <Column field="skill" header="SKILLS"></Column>
                        </DataTable>
                    </TabPanel>
                    <TabPanel header="REFERENCES">
                        <h1 style="font-size: 25px; font-weight: bold;">References</h1>
                        <DataTable v-model:selection="selectedRow" :value="referencesData" class="mt-8" :paginator="true" :rows="5">
                            <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                            <Column field="full_name" header="FULL NAME"></Column>
                            <Column field="ref_add" header="ADDRESS"></Column>
                            <Column field="ref_cnum" header="TELEPHONE NUMBER"></Column>
                        </DataTable>
                    </TabPanel>
                </TabView>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="openAddDialog" />
                <Button v-if="!isEditingProfile" label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleProfileEditing" />
                <Button v-if="isEditingProfile" label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelProfileEditing" />
                <Button v-if="isEditingProfile && selectedRow" label="EDIT" class="px-8 py-2 text-white bg-yellow-500 rounded-lg" @click="openEditDialog(selectedRow)" />
                </div>
        </div>

        <!-- Edit Modal -->
        <div v-if="showEditDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Edit {{ currentTabLabel }}</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Fields will be dynamically rendered here based on the selected row -->
                        <div v-for="(value, key) in filteredEditFields" :key="key">
                            <label class="block mb-2 text-sm font-bold text-gray-700">{{ formatFieldLabel(key) }}</label>
                            <input
                                class="input-field"
                                :type="getInputType(key, value)"
                                v-model="editFields[key]"
                            />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideEditDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="saveEdit" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Save
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

        <!-- Update Confirmation Modal -->
        <div v-if="showUpdateDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <i class="mb-4 mt-4 text-4xl fas fa-circle-question" style="color: red;"></i>
                        <h2 class="text-xl font-semibold mb-4">Are you sure you want to update?</h2>
                        <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
                    </div>
                    <div class="flex justify-center gap-4">
                        <button @click="hideUpdateDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="saveUpdate" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
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
                            <input class="input-field" type="date" v-model="newEducation.educ_from" />
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
                            <input class="input-field" type="date" v-model="newWorkExperience.workfr" />
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (TO)</label>
                            <input class="input-field" type="date" v-model="newWorkExperience.workto" />
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
        showUpdateDialog: false,
        showEditDialog: false,
        selectedRow: null,
        editFields: {}, // Ensure this is defined as well
        currentTabLabel: '',
    };
    },

    computed: {
        filteredEditFields() {
            return Object.fromEntries(
                Object.entries(this.editFields).filter(([key]) =>
                    !key.endsWith('_count') && !key.startsWith('full') && !key.startsWith('age')
                )
            );
        }
    },


    methods: {
    toggleProfileEditing() {
        console.log('Toggling profile editing:', this.isEditingProfile);
        console.log('Selected row:', this.selectedRow);
        this.isEditingProfile = !this.isEditingProfile;
    },

    onRowSelect(event) {
    console.log('Row selected:', event.data);
    this.selectedRow = event.data;
    this.openEditDialog(this.selectedRow); // Directly call the edit dialog
    },


    cancelProfileEditing() {
        this.isEditingProfile = false;
        this.selectedRow = null;
    },

    openEditDialog(row) {
        if (row) {
            console.log('Opening Edit Dialog for row:', row);
            this.editFields = { ...row }; // Deep copy of the selected row
            this.currentTabLabel = this.getCurrentTabLabel();
            this.showEditDialog = true;

        } else {
            console.log('No row selected.');
        }
    },


    hideEditDialog() {
        console.log('Hiding Edit Dialog');
        this.showEditDialog = false;
        this.selectedRow = null;  // Optionally clear the selectedRow if you want to reset the selection
    },

    saveEdit() {
    let url = '';
    let dataArray = null;
    let countField = '';

    switch (this.activeTab) {
        case 0:
            url = '/emp_child/UpdateChildData';
            dataArray = this.childData;
            countField = 'child_count';
            break;
        case 1:
            url = '/education/UpdateEducationData';
            dataArray = this.educationData;
            countField = 'educ_count';
            break;
        case 2:
            url = '/emp_org/UpdateOrganizationData';
            dataArray = this.organizationData;
            countField = 'org_count';
            break;
        case 3:
            url = '/emp_work/UpdateWorkExperienceData';
            dataArray = this.workExperienceData;
            countField = 'work_count';
            break;
        case 4:
            url = '/emp_skills/UpdateSkillsData';
            dataArray = this.skillsData;
            countField = 'skill_count';
            break;
        case 5:
            url = '/emp_reference/UpdateReferencesData';
            dataArray = this.referencesData;
            countField = 'ref_count';
            break;
        default:
            console.error('Unknown tab selected');
            return;
    }

    // Store the necessary information for updating
    this.updateUrl = url;
    this.updateDataArray = dataArray;
    this.updateCountField = countField;

    // Show the confirmation dialog
    this.showUpdateDialog = true;
},

// Function to proceed with the update after confirmation
saveUpdate() {
    axios.post(this.updateUrl, this.editFields)
        .then(() => {
            const index = this.updateDataArray.findIndex(item =>
                item.empid === this.editFields.empid &&
                item[this.updateCountField] === this.editFields[this.updateCountField]
            );

            if (index !== -1) {
                this.updateDataArray[index] = { ...this.editFields };
            } else {
                console.error('Item not found');
            }

            this.showSuccessDialog = true;
            this.hideEditDialog();
            this.isEditingProfile = false;
        })
        .catch(error => {
            console.error('Error updating data:', error);
        });

    // Hide the confirmation dialog
    this.hideUpdateDialog();
},


    isDate(value) {
        const datePattern = /^\d{4}-\d{2}-\d{2}$/;
        return typeof value === 'string' && datePattern.test(value) && !isNaN(Date.parse(value));
    },
    isNumeric(value) {
        return typeof value === 'number' || (typeof value === 'string' && !isNaN(Number(value)));
    },
    getInputType(key, value) {
        if (this.isDate(value)) {
            return 'date';
        } else if (this.isNumeric(value)) {
            return 'number';
        } else {
            return 'text';
        }
    },

        formatFieldLabel(key) {
            return key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
        },

        getCurrentTabLabel() {
            switch (this.activeTab) {
                case 0: return 'Child';
                case 1: return 'Education';
                case 2: return 'Organization';
                case 3: return 'Work Experience';
                case 4: return 'Skills';
                case 5: return 'References';
                default: return '';
            }
        },

        updateData() {
            const urlMap = {
                0: '/emp_child/UpdateChildData',
                1: '/education/UpdateEducationData',
                2: '/emp_org/UpdateOrganizationData',
                3: '/emp_work/UpdateWorkExperienceData',
                4: '/emp_skills/UpdateSkillsData',
                5: '/emp_reference/UpdateReferencesData'
            };

            axios.post(urlMap[this.activeTab], this.editFields)
                .then(() => {
                    this.showSuccessDialog = true;
                    this.hideEditDialog();
                    this.isEditingProfile = false;
                })
                .catch(error => {
                    console.error('Error updating data:', error);
                });
        },

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


        async updateFamilyData() {
            try {
                await axios.patch('/EmpFamily/updateFamilyData', this.fields);
                this.isEditing = false;
                this.showUpdateDialog = false;
                this.showSuccessDialog = true;
                location.reload();
                } catch (error) {
                this.errorMessage = 'Failed to update Family. Please try again.';
                this.showUpdateDialog = false;
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

        const childData = ref([]);
        const educationData = ref([]);
        const organizationData = ref([]);
        const workExperienceData = ref([]);
        const skillsData = ref([]);
        const referencesData = ref([]);
        const newChild = ref({
            child_fname: '',
            child_mname: '',
            child_lname: '',
            child_xname: '',
            child_dob: ''
        });
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


        const hideAddChildDialog = () => {
            showAddChildDialog.value = false;
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
            hideUpdateDialog
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

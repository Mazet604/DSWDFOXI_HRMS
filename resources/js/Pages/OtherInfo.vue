<template>
    <AppLayout>
        <div class="w-full">
            <h1 class="mb-4 text-3xl font-bold">OTHER INFO</h1>
            <TabView v-model:activeIndex="activeTab" class="no-background">
                <TabPanel header="CS ELIGIBILITY">
                    <DataTable :value="cseligibilityData" class="mt-8" :paginator="true" :rows="5">
                        <Column field="level" header="LEVEL OF EDUCATION"></Column>
                        <Column field="school" header="NAME OF SCHOOL"></Column>
                        <Column field="course" header="BASIC EDUCATION|DEGREE|COURSE"></Column>
                        <Column field="dates" header="INCLUSIVE DATES (FROM - TO)"></Column>
                        <Column field="highestLevel" header="HIGHEST LEVEL EARNED"></Column>
                        <Column field="yearGraduated" header="YEAR GRADUATED"></Column>
                        <Column field="scholarships" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE"></Column>
                    </DataTable>
                </TabPanel>
                <TabPanel header="VOLUNTARY WORK">
                    <DataTable :value="voluntaryworkData" class="mt-8" :paginator="true" :rows="5">
                        <Column field="level" header="LEVEL OF EDUCATION"></Column>
                        <Column field="school" header="NAME OF SCHOOL"></Column>
                        <Column field="course" header="BASIC EDUCATION|DEGREE|COURSE"></Column>
                        <Column field="dates" header="INCLUSIVE DATES (FROM - TO)"></Column>
                        <Column field="highestLevel" header="HIGHEST LEVEL EARNED"></Column>
                        <Column field="yearGraduated" header="YEAR GRADUATED"></Column>
                        <Column field="scholarships" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE"></Column>
                    </DataTable>
                </TabPanel>
                <TabPanel header="LEARNING & DEVELOPMENT">
                    <DataTable :value="learndevData" class="mt-8" :paginator="true" :rows="5">
                        <Column field="level" header="LEVEL OF EDUCATION"></Column>
                    </DataTable>
                </TabPanel>
                <TabPanel header="GOVERNMENT ID">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-box">
                            <div>
                                <label class="label-field">SSS ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.sssId" />
                            </div>
                            <div>
                                <label class="label-field">PAG-IBIG ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.pagIbigId" />
                            </div>
                            <div>
                                <label class="label-field">TIN ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.tinId" />
                            </div>
                        </div>
                        <div class="border-box">
                            <div>
                                <label class="label-field">GSIS ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.gsisId" />
                            </div>
                            <div>
                                <label class="label-field">PHILHEALTH ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.philHealthId" />
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border-box">
                            <div>
                                <label class="label-field">GOV'T. ISSUED ID:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.govIssuedId" />
                            </div>
                            <div>
                                <label class="label-field">DATE ISSUED:</label>
                                <input class="input-field" type="date" v-model="governmentIdFields.dateIssued" />
                            </div>
                        </div>
                        <div class="border-box">
                            <div>
                                <label class="label-field">ID/LICENSE/PASSPORT NO.:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.licenseNo" />
                            </div>
                            <div>
                                <label class="label-field">PLACE OF ISSUANCE:</label>
                                <input class="input-field" type="text" v-model="governmentIdFields.placeIssued" />
                            </div>
                        </div>
                    </div>
                </TabPanel>
                <TabPanel header="RECOGNITION AND DISTINCTIONS">
                    <DataTable :value="recogdistData" class="mt-8" :paginator="true" :rows="5">
                        <Column field="skill" header="SKILLS"></Column>
                    </DataTable>
                </TabPanel>
            </TabView>
            <div class="flex justify-end gap-4 mt-6">
                <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="confirmAdd" />
                <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
            </div>
        </div>

        <!-- Add CS Eligibility Modal -->
        <div v-if="showAddCSEligibilityDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add CS Eligibility</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="label-field">LEVEL OF EDUCATION</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.level" />
                        </div>
                        <div>
                            <label class="label-field">NAME OF SCHOOL</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.school" />
                        </div>
                        <div>
                            <label class="label-field">BASIC EDUCATION|DEGREE|COURSE</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.course" />
                        </div>
                        <div>
                            <label class="label-field">INCLUSIVE DATES (FROM - TO)</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.dates" />
                        </div>
                        <div>
                            <label class="label-field">HIGHEST LEVEL EARNED</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.highestLevel" />
                        </div>
                        <div>
                            <label class="label-field">YEAR GRADUATED</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.yearGraduated" />
                        </div>
                        <div>
                            <label class="label-field">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                            <input class="input-field" type="text" v-model="newCSEligibility.scholarships" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddCSEligibilityDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addCSEligibility" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Voluntary Work Modal -->
        <div v-if="showAddVoluntaryWorkDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Voluntary Work</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="label-field">LEVEL OF EDUCATION</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.level" />
                        </div>
                        <div>
                            <label class="label-field">NAME OF SCHOOL</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.school" />
                        </div>
                        <div>
                            <label class="label-field">BASIC EDUCATION|DEGREE|COURSE</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.course" />
                        </div>
                        <div>
                            <label class="label-field">INCLUSIVE DATES (FROM - TO)</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.dates" />
                        </div>
                        <div>
                            <label class="label-field">HIGHEST LEVEL EARNED</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.highestLevel" />
                        </div>
                        <div>
                            <label class="label-field">YEAR GRADUATED</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.yearGraduated" />
                        </div>
                        <div>
                            <label class="label-field">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                            <input class="input-field" type="text" v-model="newVoluntaryWork.scholarships" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddVoluntaryWorkDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addVoluntaryWork" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Learning & Development Modal -->
        <div v-if="showAddLearndevDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Learning & Development</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="label-field">LEVEL OF EDUCATION</label>
                            <input class="input-field" type="text" v-model="newLearndev.level" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddLearndevDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addLearndev" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Recognition & Distinctions Modal -->
        <div v-if="showAddRecogdistDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-4">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold mb-4">Add Recognition & Distinctions</h2>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="label-field">SKILLS</label>
                            <input class="input-field" type="text" v-model="newRecogdist.skill" />
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <button @click="hideAddRecogdistDialog" class="py-2 px-4 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">
                            Cancel
                        </button>
                        <button @click="addRecogdist" class="py-2 px-4 rounded bg-blue-600 text-white hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Success Modal -->
        <div v-if="showSuccessDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
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
import { Head } from '@inertiajs/vue3';
import Button from 'primevue/button';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AppLayout from '@/Layouts/AppLayout.vue';

const activeTab = ref(0);

const cseligibilityData = ref([
    { level: 'Level 1', school: 'School 1', course: 'Course 1', dates: '2020 - 2021', highestLevel: 'High School', yearGraduated: 2021, scholarships: 'Scholarship 1' },
    { level: 'Level 2', school: 'School 2', course: 'Course 2', dates: '2019 - 2020', highestLevel: 'Bachelor', yearGraduated: 2020, scholarships: 'Scholarship 2' },
    { level: 'Level 3', school: 'School 3', course: 'Course 3', dates: '2018 - 2019', highestLevel: 'Master', yearGraduated: 2019, scholarships: 'Scholarship 3' },
    { level: 'Level 4', school: 'School 4', course: 'Course 4', dates: '2017 - 2018', highestLevel: 'PhD', yearGraduated: 2018, scholarships: 'Scholarship 4' },
    { level: 'Level 5', school: 'School 5', course: 'Course 5', dates: '2016 - 2017', highestLevel: 'High School', yearGraduated: 2017, scholarships: 'Scholarship 5' },
    { level: 'Level 6', school: 'School 6', course: 'Course 6', dates: '2015 - 2016', highestLevel: 'Bachelor', yearGraduated: 2016, scholarships: 'Scholarship 6' }
]);

const voluntaryworkData = ref([
    { level: 'Level 1', school: 'School 1', course: 'Course 1', dates: '2020 - 2021', highestLevel: 'High School', yearGraduated: 2021, scholarships: 'Scholarship 1' },
    { level: 'Level 2', school: 'School 2', course: 'Course 2', dates: '2019 - 2020', highestLevel: 'Bachelor', yearGraduated: 2020, scholarships: 'Scholarship 2' },
    { level: 'Level 3', school: 'School 3', course: 'Course 3', dates: '2018 - 2019', highestLevel: 'Master', yearGraduated: 2019, scholarships: 'Scholarship 3' },
    { level: 'Level 4', school: 'School 4', course: 'Course 4', dates: '2017 - 2018', highestLevel: 'PhD', yearGraduated: 2018, scholarships: 'Scholarship 4' },
    { level: 'Level 5', school: 'School 5', course: 'Course 5', dates: '2016 - 2017', highestLevel: 'High School', yearGraduated: 2017, scholarships: 'Scholarship 5' },
    { level: 'Level 6', school: 'School 6', course: 'Course 6', dates: '2015 - 2016', highestLevel: 'Bachelor', yearGraduated: 2016, scholarships: 'Scholarship 6' }
]);

const learndevData = ref([
    { level: 'Level 1' },
    { level: 'Level 2' },
    { level: 'Level 3' },
    { level: 'Level 4' },
    { level: 'Level 5' },
    { level: 'Level 6' }
]);

const recogdistData = ref([
    { skill: 'Skill 1' },
    { skill: 'Skill 2' },
    { skill: 'Skill 3' },
    { skill: 'Skill 4' },
    { skill: 'Skill 5' },
    { skill: 'Skill 6' }
]);

const governmentIdFields = ref({
    sssId: '09223512331',
    gsisId: '272-2034',
    pagIbigId: '09223512331',
    philHealthId: '272-2034',
    tinId: '09223512331',
    govIssuedId: 'DSWD EMPLOYEE ID',
    dateIssued: '2024-07-24',
    licenseNo: '272-2034',
    placeIssued: 'QUEZON CITY'
});

const showUpdateDialog = ref(false);
const showAddCSEligibilityDialog = ref(false);
const showAddVoluntaryWorkDialog = ref(false);
const showAddLearndevDialog = ref(false);
const showAddRecogdistDialog = ref(false);
const showSuccessDialog = ref(false);

const newCSEligibility = ref({
    level: '',
    school: '',
    course: '',
    dates: '',
    highestLevel: '',
    yearGraduated: '',
    scholarships: ''
});

const newVoluntaryWork = ref({
    level: '',
    school: '',
    course: '',
    dates: '',
    highestLevel: '',
    yearGraduated: '',
    scholarships: ''
});

const newLearndev = ref({
    level: ''
});

const newRecogdist = ref({
    skill: ''
});

const confirmUpdate = () => {
    showUpdateDialog.value = true;
};

const hideUpdateDialog = () => {
    showUpdateDialog.value = false;
};

const confirmAdd = () => {
    const currentTab = activeTab.value;
    if (currentTab === 0) showAddCSEligibilityDialog.value = true;
    else if (currentTab === 1) showAddVoluntaryWorkDialog.value = true;
    else if (currentTab === 2) showAddLearndevDialog.value = true;
    else if (currentTab === 4) showAddRecogdistDialog.value = true;
};

const hideAddCSEligibilityDialog = () => {
    showAddCSEligibilityDialog.value = false;
};

const hideAddVoluntaryWorkDialog = () => {
    showAddVoluntaryWorkDialog.value = false;
};

const hideAddLearndevDialog = () => {
    showAddLearndevDialog.value = false;
};

const hideAddRecogdistDialog = () => {
    showAddRecogdistDialog.value = false;
};

const hideSuccessDialog = () => {
    showSuccessDialog.value = false;
};

const updateProfile = () => {
    hideUpdateDialog();
    showSuccessDialog.value = true;
};

const addCSEligibility = () => {
    cseligibilityData.value.push({ ...newCSEligibility.value });
    hideAddCSEligibilityDialog();
    showSuccessDialog.value = true;
};

const addVoluntaryWork = () => {
    voluntaryworkData.value.push({ ...newVoluntaryWork.value });
    hideAddVoluntaryWorkDialog();
    showSuccessDialog.value = true;
};

const addLearndev = () => {
    learndevData.value.push({ ...newLearndev.value });
    hideAddLearndevDialog();
    showSuccessDialog.value = true;
};

const addRecogdist = () => {
    recogdistData.value.push({ ...newRecogdist.value });
    hideAddRecogdistDialog();
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
    padding: 1rem;
}

.input-field {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #cbd5e0;
    border-radius: 0.375rem;
    box-sizing: border-box;
    margin-top: 0.5rem;
    margin-bottom: 1rem;
}

.label-field {
    margin-bottom: 0.25rem;
}

.divider {
    width: 100%;
    height: 1px;
    background-color: #e5e7eb;
    margin: 2rem 0;
}

@media (max-width: 640px) {
    .fixed {
        position: static;
    }
}
</style>

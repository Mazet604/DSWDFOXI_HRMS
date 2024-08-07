<template>
    <AppLayout>
                    <div class="w-full">
                        <h1 class="mb-4 text-3xl font-bold">OTHER INFO</h1>
                        <TabView v-model:activeIndex="activeTab" class="no-background">
                            <TabPanel header="CS ELIGIBILITY" :active="activeSubTab === 'eligibility'">
                                <DataTable :value="cseligibilityData" class="mt-8" :paginator="true" :rows="5">
                                    <Column field="eli_service" header="CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES/CSEE/BARANGAY ELIGIBILITY/DRIVERS LICENSE"></Column>
                                    <Column field="eli_rating" header="RATING (IF APPLICABLE)"></Column>
                                    <Column field="eli_doe" header="DATE OF EXAMINATION/CONFERMENT"></Column>
                                    <Column field="eli_poe" header="PLACE OF EXAMINATION/CONFERMENT"></Column>
                                    <Column field="eli_license_no" header="LICENSE (IF APPLICABLE)"></Column>
                                    <Column field="eli_licen_valid" header="VALIDITY"></Column>
                                </DataTable>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="showAddCSEligibilityDialog = true" />
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                            <TabPanel header="VOLUNTARY WORK" :active="activeSubTab === 'voluntary'">
                                <DataTable :value="voluntaryworkData" class="mt-8" :paginator="true" :rows="5">
                                    <Column field="vol_name" header="NAME & ADDRESS OF ORGANIZATION (WRITE IN FULL)"></Column>
                                    <Column field="vol_fr" header="INCLUSIVE DATES (MM/DD/YYYY) FROM"></Column>
                                    <Column field="vol_to" header="INCLUSIVE DATES (MM/DD/YYYY) TO"></Column>
                                    <Column field="vol_hrs" header="NUMBER OF HOURS"></Column>
                                    <Column field="vol_pos" header="POSITION / NATURE OF WORK"></Column>
                                </DataTable>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="showAddVoluntaryWorkDialog = true" />
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                            <TabPanel header="LEARNING & DEVELOPMENT" :active="activeSubTab === 'learning'">
                                <DataTable :value="learndevData" class="mt-8" :paginator="true" :rows="5">
                                    <Column field="learn_title" header="TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAM (WRITE IN FULL)"></Column>
                                    <Column field="learn_fr" header="INCLUSIVE DATES (MM/DD/YYYY) FROM"></Column>
                                    <Column field="learn_to" header="INCLUSIVE DATES (MM/DD/YYYY) TO"></Column>
                                    <Column field="learn_hrs" header="NUMBER OF HOURS"></Column>
                                    <Column field="learn_type" header="TYPE OF LD (MANAGERIAL/SUPERVISORY/TECHNICAL/ETC)"></Column>
                                    <Column field="learn_con" header="CONDUCTED/SPONSORED BY (WRITE IN FULL)"></Column>
                                </DataTable>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="showAddLearndevDialog = true" />
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                            
                            <TabPanel header="RECOGNITION AND DISTINCTIONS" :active="activeSubTab === 'recognition'">
                                <DataTable :value="recogdistData" class="mt-8" :paginator="true" :rows="5">
                                    <Column field="recog_name" header="NON-ACADEMIC DISTINCTIONS/RESTRICTIONS"></Column>
                                </DataTable>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="showAddRecogdistDialog = true" />
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                            
                            <TabPanel header="GOVERNMENT ID" :active="activeSubTab === 'government'">
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
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                            <TabPanel header="OTHER INFORMATION" :active="activeSubTab === 'other'">
                                <div class="other-info">
                                    <div class="pagination">
                                        <button @click="previousPage" :disabled="currentPage === 1">&laquo; Previous</button>
                                        <button @click="nextPage" :disabled="currentPage === totalPages">Next &raquo;</button>
                                    </div>
                                    <div v-if="currentPage === 1">
                                        <h2>34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed</h2>
                                        <div class="form-group">
                                            <label>a. within the third degree?</label>
                                            <input type="radio" v-model="otherInfo.degree" value="Yes" /> Yes
                                            <input type="radio" v-model="otherInfo.degree" value="No" /> No
                                        </div>
                                        <div class="form-group">
                                            <label>b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                                            <input type="radio" v-model="otherInfo.degreeFourth" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.degreeFourthDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.degreeFourth" value="No" /> No
                                        </div>
                                    </div>
                                    <div v-if="currentPage === 2">
                                        <h2>35. a. Have you ever been found guilty of any administrative offense?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.adminOffense" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.adminOffenseDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.adminOffense" value="No" /> No
                                        </div>
                                        <h2>b. Have you been criminally charged before any court?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.criminalCharge" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.criminalChargeDetails" placeholder="If YES, give details" />
                                            <input type="date" v-model="otherInfo.dateFiled" placeholder="Date Filed" />
                                            <input type="text" v-model="otherInfo.statusOfCase" placeholder="Status of Case/s" />
                                            <input type="radio" v-model="otherInfo.criminalCharge" value="No" /> No
                                        </div>
                                    </div>
                                    <div v-if="currentPage === 3">
                                        <h2>36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.convictedCrime" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.convictedCrimeDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.convictedCrime" value="No" /> No
                                        </div>
                                        <h2>37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.separatedService" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.separatedServiceDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.separatedService" value="No" /> No
                                        </div>
                                    </div>
                                    <div v-if="currentPage === 4">
                                        <h2>38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.candidateElection" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.candidateElectionDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.candidateElection" value="No" /> No
                                        </div>
                                        <h2>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.resignedGovtService" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.resignedGovtServiceDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.resignedGovtService" value="No" /> No
                                        </div>
                                    </div>
                                    <div v-if="currentPage === 5">
                                        <h2>39. Have you acquired the status of an immigrant or permanent resident of another country?</h2>
                                        <div class="form-group">
                                            <input type="radio" v-model="otherInfo.immigrantStatus" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.immigrantStatusDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.immigrantStatus" value="No" /> No
                                        </div>
                                        <h2>40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</h2>
                                        <div class="form-group">
                                            <label>a. Are you a member of any indigenous group?</label>
                                            <input type="radio" v-model="otherInfo.indigenousGroup" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.indigenousGroupDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.indigenousGroup" value="No" /> No
                                        </div>
                                        <div class="form-group">
                                            <label>b. Are you a person with disability?</label>
                                            <input type="radio" v-model="otherInfo.disability" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.disabilityDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.disability" value="No" /> No
                                        </div>
                                        <div class="form-group">
                                            <label>c. Are you a solo parent?</label>
                                            <input type="radio" v-model="otherInfo.soloParent" value="Yes" /> Yes
                                            <input type="text" v-model="otherInfo.soloParentDetails" placeholder="If YES, give details" />
                                            <input type="radio" v-model="otherInfo.soloParent" value="No" /> No
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="UPDATE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </TabPanel>
                        </TabView>

                        <!-- Add CS Eligibility Modal -->
                        <div v-if="showAddCSEligibilityDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h2 class="text-xl font-semibold mb-4">Add CS Eligibility</h2>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="label-field">CAREER SERVICE/RA 1080</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_service" />
                                        </div>
                                        <div>
                                            <label class="label-field">RATING (IF APPLICABLE)</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_rating" />
                                        </div>
                                        <div>
                                            <label class="label-field">DATE OF EXAMINATION/CONFERMENT</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_doe" />
                                        </div>
                                        <div>
                                            <label class="label-field">PLACE OF EXAMINATION/CONFERMENT</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_poe" />
                                        </div>
                                        <div>
                                            <label class="label-field">LICENSE (IF APPLICABLE)</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_license_no" />
                                        </div>
                                        <div>
                                            <label class="label-field">VALIDITY</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_licen_valid" />
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
                                            <label class="label-field">NAME & ADDRESS OF ORGANIZATION (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_name" />
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_fr" />
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_to" />
                                        </div>
                                        <div>
                                            <label class="label-field">NUMBER OF HOURS</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_hrs" />
                                        </div>
                                        <div>
                                            <label class="label-field">POSITION / NATURE OF WORK</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_pos" />
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
                                            <label class="label-field">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAM (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_title" />
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_fr" />
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_to" />
                                        </div>
                                        <div>
                                            <label class="label-field">NUMBER OF HOURS</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_hrs" />
                                        </div>
                                        <div>
                                            <label class="label-field">TYPE OF LD (MANAGERIAL/SUPERVISORY/TECHNICAL/ETC)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_type" />
                                        </div>
                                        <div>
                                            <label class="label-field">CONDUCTED/SPONSORED BY (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_con" />
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
                                            <label class="label-field">NON-ACADEMIC DISTINCTIONS/RESTRICTIONS</label>
                                            <input class="input-field" type="text" v-model="newRecogdist.recog_name" />
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

                        <!-- Update Confirmation Modal -->
                        <div v-if="showUpdateDialog" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
                            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-md w-full p-6 text-center">
                                <i class="fas fa-exclamation-triangle text-4xl mb-4" style="color: red;"></i>
                                <h2 class="text-xl font-semibold mb-4">Are you sure you want to update?</h2>
                                <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
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
        const currentPage = ref(1);
        const totalPages = ref(5);

        const previousPage = () => {
            if (currentPage.value > 1) {
                currentPage.value -= 1;
            }
        };

        const nextPage = () => {
            if (currentPage.value < totalPages.value) {
                currentPage.value += 1;
            }
        };

        const governmentIdFields = ref({
            sssId: '',
            pagIbigId: '',
            tinId: '',
            gsisId: '',
            philHealthId: ''
        });

        const otherInfo = ref({
            degree: '',
            degreeFourth: '',
            degreeFourthDetails: '',
            adminOffense: '',
            adminOffenseDetails: '',
            criminalCharge: '',
            criminalChargeDetails: '',
            dateFiled: '',
            statusOfCase: '',
            convictedCrime: '',
            convictedCrimeDetails: '',
            separatedService: '',
            separatedServiceDetails: '',
            candidateElection: '',
            candidateElectionDetails: '',
            resignedGovtService: '',
            resignedGovtServiceDetails: '',
            immigrantStatus: '',
            immigrantStatusDetails: '',
            indigenousGroup: '',
            indigenousGroupDetails: '',
            disability: '',
            disabilityDetails: '',
            soloParent: '',
            soloParentDetails: ''
        });

        const cseligibilityData = ref([]);
        const voluntaryworkData = ref([]);
        const learndevData = ref([]);
        const recogdistData = ref([]);

        const fetchCSEligibilityData = async () => {
            try {
                const response = await axios.get('/emp_eligibility/CSEligibilityData');
                cseligibilityData.value = response.data;
            } catch (error) {
                console.error('Error fetching CS Eligibility data:', error);
            }
        };

        const fetchVoluntaryWorkData = async () => {
            try {
                const response = await axios.get('/emp_voluntary/VoluntaryWorkData');
                voluntaryworkData.value = response.data;
            } catch (error) {
                console.error('Error fetching Voluntary Work data:', error);
            }
        };

        const fetchLearndevData = async () => {
            try {
                const response = await axios.get('/emp_learning/LearndevData');
                learndevData.value = response.data;
            } catch (error) {
                console.error('Error fetching Learning & Development data:', error);
            }
        };

        const fetchRecogdistData = async () => {
            try {
                const response = await axios.get('/emp_recog/RecogdistData');
                recogdistData.value = response.data;
            } catch (error) {
                console.error('Error fetching Recognition & Distinctions data:', error);
            }
        };

        const fetchSSSId = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/sssId/SSSId');
                governmentIdFields.value.sssId = response.data.sssId;
            } catch (error) {
                console.error('Error fetching SSS ID:', error);
            }
        };

        const fetchPagIbigId = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/pagIbigId/PagIbigId');
                governmentIdFields.value.pagIbigId = response.data.pagIbigId;
            } catch (error) {
                console.error('Error fetching Pag-IBIG ID:', error);
            }
        };

        const fetchGSISId = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/gsisId/GSISId');
                governmentIdFields.value.gsisId = response.data.gsisId;
            } catch (error) {
                console.error('Error fetching GSIS ID:', error);
            }
        };

        const fetchTINId = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/tinId/TINId');
                governmentIdFields.value.tinId = response.data.tinId;
            } catch (error) {
                console.error('Error fetching TIN ID:', error);
            }
        };

        const fetchPhilHealthId = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/philHealthId/PhilHealthId');
                governmentIdFields.value.philHealthId = response.data.philHealthId;
            } catch (error) {
                console.error('Error fetching PhilHealth ID:', error);
            }
        };

        const showAddCSEligibilityDialog = ref(false);
        const showAddVoluntaryWorkDialog = ref(false);
        const showAddLearndevDialog = ref(false);
        const showAddRecogdistDialog = ref(false);

        const newCSEligibility = ref({
            eli_service: '',
            eli_rating: '',
            eli_doe: '',
            eli_poe: '',
            eli_license_no: '',
            eli_licen_valid: ''
        });

        const newVoluntaryWork = ref({
            vol_name: '',
            vol_fr: '',
            vol_to: '',
            vol_hrs: '',
            vol_pos: ''
        });

        const newLearndev = ref({
            learn_title: '',
            learn_fr: '',
            learn_to: '',
            learn_hrs: '',
            learn_type: '',
            learn_con: ''
        });

        const newRecogdist = ref({
            recog_name: ''
        });

        const addCSEligibility = async () => {
            try {
                const response = await axios.post('/emp_eligibility/AddCSEligibility', newCSEligibility.value);
                cseligibilityData.value.push(response.data);
                showAddCSEligibilityDialog.value = false;
            } catch (error) {
                console.error('Error adding CS Eligibility:', error);
            }
        };

        const addVoluntaryWork = async () => {
            try {
                const response = await axios.post('/emp_voluntary/AddVoluntaryWork', newVoluntaryWork.value);
                voluntaryworkData.value.push(response.data);
                showAddVoluntaryWorkDialog.value = false;
            } catch (error) {
                console.error('Error adding Voluntary Work:', error);
            }
        };

        const addLearndev = async () => {
            try {
                const response = await axios.post('/emp_learning/AddLearndev', newLearndev.value);
                learndevData.value.push(response.data);
                showAddLearndevDialog.value = false;
            } catch (error) {
                console.error('Error adding Learning & Development:', error);
            }
        };

        const addRecogdist = async () => {
            try {
                const response = await axios.post('/emp_recog/AddRecogdist', newRecogdist.value);
                recogdistData.value.push(response.data);
                showAddRecogdistDialog.value = false;
            } catch (error) {
                console.error('Error adding Recognition & Distinctions:', error);
            }
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
                    await axios.post('/emp_eligibility/UpdateCSEligibilityData', cseligibilityData.value);
                } else if (activeTab.value === 1) {
                    await axios.post('/emp_voluntary/UpdateVoluntaryWorkData', voluntaryworkData.value);
                } else if (activeTab.value === 2) {
                    await axios.post('/emp_learning/UpdateLearndevData', learndevData.value);
                } else if (activeTab.value === 3) {
                    await axios.post('/emp_recog/UpdateRecogdistData', recogdistData.value);
                } else if (activeTab.value === 4) {
                    await axios.post('/emp_govt_id/UpdateGovernmentIdData', governmentIdFields.value);
                } else if (activeTab.value === 5) {
                    await axios.post('/emp_other_info/UpdateOtherInfoData', otherInfo.value);
                }
                showUpdateDialog.value = false;
                showSuccessDialog.value = true;
            } catch (error) {
                console.error('Error updating profile:', error);
                showUpdateDialog.value = false;
            }
        };

        const showSuccessDialog = ref(false);
        const showUpdateDialog = ref(false);

        const searchQuery = ref('');

        const search = () => {
            const searchLower = searchQuery.value.toLowerCase();
            if (searchLower.includes('eligibility')) {
                activeTab.value = 0;
            } else if (searchLower.includes('voluntary')) {
                activeTab.value = 1;
            } else if (searchLower.includes('learning')) {
                activeTab.value = 2;
            } else if (searchLower.includes('recognition')) {
                activeTab.value = 3;
            } else if (searchLower.includes('government')) {
                activeTab.value = 4;
            } else if (searchLower.includes('other')) {
                activeTab.value = 5;
            } else {
                alert('No matching tab found.');
            }
        };

        onMounted(() => {
            fetchCSEligibilityData();
            fetchVoluntaryWorkData();
            fetchLearndevData();
            fetchRecogdistData();
            fetchSSSId();
            fetchPagIbigId();
            fetchGSISId();
            fetchTINId();
            fetchPhilHealthId();
        });

        return {
            activeTab,
            currentPage,
            totalPages,
            previousPage,
            nextPage,
            governmentIdFields,
            cseligibilityData,
            voluntaryworkData,
            learndevData,
            recogdistData,
            showAddCSEligibilityDialog,
            showAddVoluntaryWorkDialog,
            showAddLearndevDialog,
            showAddRecogdistDialog,
            newCSEligibility,
            newVoluntaryWork,
            newLearndev,
            newRecogdist,
            addCSEligibility,
            addVoluntaryWork,
            addLearndev,
            addRecogdist,
            fetchCSEligibilityData,
            fetchVoluntaryWorkData,
            fetchLearndevData,
            fetchRecogdistData,
            fetchSSSId,
            fetchPagIbigId,
            fetchGSISId,
            fetchTINId,
            fetchPhilHealthId,
            otherInfo,
            confirmUpdate,
            hideUpdateDialog,
            updateProfile,
            showSuccessDialog,
            showUpdateDialog,
            searchQuery,
            search
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

.pagination {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

@media (max-width: 640px) {
    .fixed {
        position: static;
    }
}
</style>

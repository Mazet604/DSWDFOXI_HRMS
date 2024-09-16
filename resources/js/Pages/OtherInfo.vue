<template>
    <AppLayout>
            <!-- Header Section -->
                <div class="p-6 bg-white border-b border-yellow-200">
                <h1 class="text-3xl font-bold text-blue-900">OTHER INFO</h1>
                <p class="text-gray-600">Fill and check the necessary information below.</p>
                </div>

        <div class="relative w-full p-6">
            <!-- Custom Tabs -->
            <div class="flex justify-end -mb-px">
                <button @click="activeTab = 0" :class="tabButtonClass(0)">CS ELIGIBILITY</button>
                <button @click="activeTab = 1" :class="tabButtonClass(1)">VOLUNTARY WORK</button>
                <button @click="activeTab = 2" :class="tabButtonClass(2)">LEARNING & DEVELOPMENT</button>
                <button @click="activeTab = 3" :class="tabButtonClass(3)">RECOGNITION AND DISTINCTIONS</button>
                <button @click="activeTab = 4" :class="tabButtonClass(4)">GOVERNMENT ID</button>
                <button @click="activeTab = 5" :class="tabButtonClass(5)">OTHER INFORMATION</button>
            </div>

            <!-- CS Eligibility Tab -->
            <div v-if="activeTab === 0" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">CS ELIGIBILITY</h2>
                <DataTable v-model:selection="selectedRow" :value="cseligibilityData" class="mt-8" :paginator="true" :rows="5" @selection-change="onRowSelect">
                    <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                    <Column field="eli_service" header="CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES/CSEE/BARANGAY ELIGIBILITY/DRIVERS LICENSE"></Column>
                    <Column field="eli_rating" header="RATING (IF APPLICABLE)"></Column>
                    <Column field="eli_doe" header="DATE OF EXAMINATION/CONFERMENT"></Column>
                    <Column field="eli_poe" header="PLACE OF EXAMINATION/CONFERMENT"></Column>
                    <Column field="eli_license_no" header="LICENSE (IF APPLICABLE)"></Column>
                    <Column field="eli_licen_valid" header="VALIDITY"></Column>
                </DataTable>
                <div class="mt-6 text-right">
                    <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 mr-4 font-semibold text-white transition duration-300 bg-blue-900 rounded-md hover:bg-blue-800" @click="openAddDialog" />
                    <Button v-if="!isEditingProfile" label="EDIT" class="px-8 py-2 font-semibold text-white transition duration-300 bg-blue-900 rounded-md hover:bg-blue-800" @click="toggleProfileEditing" />
                    <Button v-if="isEditingProfile" label="CANCEL" class="px-8 py-2 font-semibold text-white bg-red-700 rounded-md hover:bg-red-800" @click="cancelProfileEditing" />
                    <Button v-if="isEditingProfile && selectedRow" label="EDIT" class="px-8 py-2 text-white bg-yellow-500 rounded-lg" @click="openEditDialog(selectedRow)" />
                </div>
            </div>

            <!-- Voluntary Work Tab -->
            <div v-if="activeTab === 1" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">VOLUNTARY WORK</h2>
                <DataTable v-model:selection="selectedRow" :value="voluntaryworkData" class="mt-8" :paginator="true" :rows="5" @selection-change="onRowSelect">
                    <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                    <Column field="vol_name" header="NAME OF ORGANIZATION"></Column>
                    <Column field="vol_add" header="ADDRESS OF ORGANIZATION"></Column>
                    <Column field="vol_fr" header="INCLUSIVE DATES FROM"></Column>
                    <Column field="vol_to" header="INCLUSIVE DATES TO"></Column>
                    <Column field="vol_hrs" header="NUMBER OF HOURS"></Column>
                    <Column field="vol_pos" header="POSITION / NATURE OF WORK"></Column>
                </DataTable>
                <div class="flex justify-end gap-4 mt-6">
                    <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="openAddDialog" />
                    <Button v-if="!isEditingProfile" label="EDIT" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleProfileEditing" />
                    <Button v-if="isEditingProfile" label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelProfileEditing" />
                    <Button v-if="isEditingProfile && selectedRow" label="EDIT" class="px-8 py-2 text-white bg-yellow-500 rounded-lg" @click="openEditDialog(selectedRow)" />
                </div>
            </div>

            <!-- Learning & Development Tab -->
            <div v-if="activeTab === 2" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">LEARNING & DEVELOPMENT</h2>
                <DataTable v-model:selection="selectedRow" :value="learndevData" class="mt-8" :paginator="true" :rows="5" @selection-change="onRowSelect">
                    <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                    <Column field="learn_title" header="TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAM (WRITE IN FULL)"></Column>
                    <Column field="learn_fr" header="INCLUSIVE DATES (MM/DD/YYYY) FROM"></Column>
                    <Column field="learn_to" header="INCLUSIVE DATES (MM/DD/YYYY) TO"></Column>
                    <Column field="learn_hrs" header="NUMBER OF HOURS"></Column>
                    <Column field="learn_type" header="TYPE OF LD (MANAGERIAL/SUPERVISORY/TECHNICAL/ETC)"></Column>
                    <Column field="learn_con" header="CONDUCTED/SPONSORED BY (WRITE IN FULL)"></Column>
                </DataTable>
                <div class="flex justify-end gap-4 mt-6">
                    <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="openAddDialog" />
                    <Button v-if="!isEditingProfile" label="EDIT" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleProfileEditing" />
                    <Button v-if="isEditingProfile" label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelProfileEditing" />
                    <Button v-if="isEditingProfile && selectedRow" label="EDIT" class="px-8 py-2 text-white bg-yellow-500 rounded-lg" @click="openEditDialog(selectedRow)" />
                </div>
            </div>

            <!-- Recognition and Distinctions Tab -->
            <div v-if="activeTab === 3" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">RECOGNITION AND DISTINCTIONS</h2>
                <DataTable v-model:selection="selectedRow" :value="recogdistData" class="mt-8" :paginator="true" :rows="5" @selection-change="onRowSelect">
                    <Column v-if="isEditingProfile" selectionMode="single" headerStyle="width: 3em"></Column>
                    <Column field="recog_name" header=""></Column>
                </DataTable>
                <div class="flex justify-end gap-4 mt-6">
                    <Button v-if="!isEditingProfile" label="ADD" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="openAddDialog" />
                    <Button v-if="!isEditingProfile" label="EDIT" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleProfileEditing" />
                    <Button v-if="isEditingProfile" label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelProfileEditing" />
                    <Button v-if="isEditingProfile && selectedRow" label="EDIT" class="px-8 py-2 text-white bg-yellow-500 rounded-lg" @click="openEditDialog(selectedRow)" />
                </div>
            </div>

            <!-- Government ID Tab -->
            <div v-if="activeTab === 4" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">GOVERNMENT ID</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="border-box">
                        <div>
                            <label class="label-field"><b>SSS ID:</b></label>
                            <input class="input-field" type="text" v-model="governmentIdFields.sssId" :disabled="!isEditingGovId" :class="{ 'disabled-input': !isEditingGovId }"/>
                        </div>
                        <div>
                            <label class="label-field"><b>PAG-IBIG ID:</b></label>
                            <input class="input-field" type="text" v-model="governmentIdFields.pagIbigId" :disabled="!isEditingGovId" :class="{ 'disabled-input': !isEditingGovId }"/>
                        </div>
                        <div>
                            <label class="label-field">T<b>IN ID:</b></label>
                            <input class="input-field" type="text" v-model="governmentIdFields.tinId" :disabled="!isEditingGovId" :class="{ 'disabled-input': !isEditingGovId }"/>
                        </div>
                    </div>
                    <div class="border-box">
                        <div>
                            <label class="label-field"><b>GSIS ID:</b></label>
                            <input class="input-field" type="text" v-model="governmentIdFields.gsisId" :disabled="!isEditingGovId" :class="{ 'disabled-input': !isEditingGovId }"/>
                        </div>
                        <div>
                            <label class="label-field"><b>PHILHEALTH ID:</b></label>
                            <input class="input-field" type="text" v-model="governmentIdFields.philHealthId" :disabled="!isEditingGovId" :class="{ 'disabled-input': !isEditingGovId }"/>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-6">
                    <Button v-if="!isEditingGovId" label="EDIT" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="toggleFamilyEditing" />
                    <div v-if="isEditingGovId" class="space-x-4">
                        <Button label="CANCEL" class="px-8 py-2 text-white custom-cancel-button" @click="cancelGovIdEditing" />
                        <Button label="SAVE" class="px-8 py-2 text-white bg-blue-500 rounded-lg" @click="updateGovIdData" />
                    </div>
                </div>
            </div>

            <!-- Other Information Tab -->
            <div v-if="activeTab === 5" class="p-6 bg-white border border-blue-900 rounded-lg">
                <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200"></h2>
                <div class="other-info">
                    <div class='columns'>
                        <h2 style="margin-bottom: 1%;"><b>Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed</b></h2>
                        <div class="form-group">
                            <label style="margin-left: 1%;">a. within the third degree?</label>
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_34a" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_34a" value="No" /> No
                        </div>
                        <div class="form-group">
                            <label style="margin-left: 1%;">b. within the fourth degree (for Local Government Unit - Career Employees)?</label>
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_34b" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_34bif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_34b" value="No" /> No
                        </div>
                    </div>
                    <span class="broken-line"></span>
                    <div>
                        <h2 style="margin-bottom: 1%;"><b>Have you ever been found guilty of any administrative offense?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_35a" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_35aif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_35a" value="No" /> No
                        </div>
                        <h2 style=" margin-bottom: 1%;"><b>Have you been criminally charged before any court?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_35b" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_35bif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="date" v-model="otherInfo.other_35bfiled" placeholder="Date Filed" />
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_35stat" placeholder="Status of Case/s" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_35b" value="No" /> No
                        </div>
                    </div>
                    <span class="broken-line"></span>
                    <div>
                        <h2 style="margin-bottom: 1%;"><b>Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_36" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_36if" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_36" value="No" /> No
                        </div>
                        <h2 style="margin-bottom: 1%;"><b>Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_37" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_37if" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_37" value="No" /> No
                        </div>
                    </div>
                    <span class="broken-line"></span>
                    <div>
                        <h2 style=" margin-bottom: 1%;"><b>Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_38a" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_38aif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_38a" value="No" /> No
                        </div>
                        <h2 style="margin-bottom: 1%;"><b>Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_38b" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.resignedGovtServiceDetails" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_38b" value="No" /> No
                        </div>
                    </div>
                    <span class="broken-line"></span>
                    <div>
                        <h2 style="margin-bottom: 1%;"><b>Have you acquired the status of an immigrant or permanent resident of another country?</b></h2>
                        <div class="form-group">
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_39" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_39if" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_39" value="No" /> No
                        </div>
                        <span class="broken-line"></span>
                        <h2 style="margin-bottom: 1%;"><b>Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</b></h2>
                        <div class="form-group">
                            <label style="margin-left: 1%; margin-bottom: 1%;">a. Are you a member of any indigenous group?</label>
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40a" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_40aif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40a" value="No" /> No
                        </div>
                        <div class="form-group">
                            <label style="margin-left: 1%; margin-bottom: 1%;">b. Are you a person with disability?</label>
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40b" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_40bif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40b" value="No" /> No
                        </div>
                        <div class="form-group">
                            <label style="margin-left: 1%; margin-bottom: 1%;">c. Are you a solo parent?</label>
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40c" value="Yes" /> Yes
                            <input style="margin-left: 1%;" type="text" v-model="otherInfo.other_40cif" placeholder="If YES, give details" />
                            <input style="margin-left: 1%;" type="radio" v-model="otherInfo.other_40c" value="No" /> No
                        </div>
                                <div class="flex justify-end gap-4 mt-6">
                                    <Button label="SAVE" class="px-8 py-2 text-white bg-green-500 rounded-lg" @click="confirmUpdate" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Edit Modal -->
                    <div v-if="showEditDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                        <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg">
                            <div class="p-4">
                                <div class="text-center">
                                    <h2 class="mb-4 text-xl font-semibold">Edit {{ currentTabLabel }}</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <!-- Fields will be dynamically rendered here based on the selected row -->
                                    <div v-for="(value, key) in filteredEditFields" :key="key">
                                        <label class="block mb-2 text-sm font-bold text-gray-700">{{ formatFieldLabel(key) }}</label>

                                        <!-- Alphabet-only validation for names  -->
                                        <template v-if="key === 'eli_service' || key === 'eli_poe' || key === 'vol_name' || key === 'vol_pos' || key === 'learn_title' || key === 'learn_type' || key === 'learn_con'
                                        || key === 'recog_name'">
                                            <input
                                                class="input-field"
                                                :type="getInputType(key, value)"
                                                v-model="editFields[key]"
                                                @input="validateAlphabetOnly(key, 'editFields')"
                                            />
                                        </template>

                                        <!-- Number-only validation for fields  -->
                                        <template v-else-if="key === 'eli_rating' || key === 'eli_license_no' || key === 'vol_hrs' || key === 'learn_hrs'">
                                            <input
                                                class="input-field"
                                                :type="getInputType(key, value)"
                                                v-model="editFields[key]"
                                                @input="validateNumberOnly(key, 'editFields')"
                                            />
                                        </template>

                                        <!-- Date input fields  -->
                                        <template v-else-if="key === 'eli_doe' || key === 'eli_licen_valid' || key === 'vol_fr'  || key === 'vol_to'
                                        || key ===  'learn_fr'  || key === 'learn_to'">
                                            <input
                                                class="input-field"
                                                type="date"
                                                v-model="editFields[key]"
                                                :max="maxDate"
                                            />
                                        </template>

                                        <!-- Default input (for any other fields) -->
                                        <template v-else>
                                            <input
                                                class="input-field"
                                                :type="getInputType(key, value)"
                                                v-model="editFields[key]"
                                            />
                                        </template>
                                    </div>
                                </div>
                                <div class="flex justify-center gap-4 mt-4">
                                    <button @click="hideEditDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                                        Cancel
                                    </button>
                                    <button @click="saveEdit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Add CS Eligibility Modal -->
                    <div v-if="showAddCSEligibilityDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h2 class="mb-4 text-xl font-semibold">Add CS Eligibility</h2>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="label-field">CAREER SERVICE/RA 1080</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_service" @input="validateName('eli_service', 'newCSEligibility')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">RATING (IF APPLICABLE)</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_rating" @input="validateDecimal('eli_rating', 'newCSEligibility')" />
                                        </div>
                                        <div>
                                            <label class="label-field">DATE OF EXAMINATION/CONFERMENT</label>
                                            <input class="input-field" type="date" v-model="newCSEligibility.eli_doe" :max="maxDate"/>
                                        </div>
                                        <div>
                                            <label class="label-field">PLACE OF EXAMINATION/CONFERMENT</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_poe" @input="validateName('eli_poe', 'newCSEligibility')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">LICENSE (IF APPLICABLE)</label>
                                            <input class="input-field" type="text" v-model="newCSEligibility.eli_license_no" />
                                        </div>
                                        <div>
                                            <label class="label-field">VALIDITY</label>
                                            <input class="input-field" type="date" v-model="newCSEligibility.eli_licen_valid" :max="maxDate"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-4 mt-4">
                                        <button @click="hideAddCSEligibilityDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button @click="addCSEligibility" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Add Voluntary Work Modal -->
                    <div v-if="showAddVoluntaryWorkDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h2 class="mb-4 text-xl font-semibold">Add Voluntary Work</h2>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="label-field">NAME OF ORGANIZATION (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_name" @input="validateName('vol_name', 'newVoluntaryWork')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">ADDRESS OF ORGANIZATION</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_add" />
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                            <input class="input-field" type="date" v-model="newVoluntaryWork.vol_fr" :max="maxDate"/>
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                            <input class="input-field" type="date" v-model="newVoluntaryWork.vol_to"/>
                                        </div>
                                        <div>
                                            <label class="label-field">NUMBER OF HOURS</label>
                                            <input class="input-field" type="number" v-model="newVoluntaryWork.vol_hrs" @input="validateNumber('vol_hrs', 'newVoluntaryWork')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">POSITION / NATURE OF WORK</label>
                                            <input class="input-field" type="text" v-model="newVoluntaryWork.vol_pos" @input="validateName('vol_pos', 'newVoluntaryWork')"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-4 mt-4">
                                        <button @click="hideAddVoluntaryWorkDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button @click="addVoluntaryWork" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Add Learning & Development Modal -->
                    <div v-if="showAddLearndevDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h2 class="mb-4 text-xl font-semibold">Add Learning & Development</h2>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="label-field">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAM (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_title" @input="validateName('learn_title', 'newLearndev')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                            <input class="input-field" type="date" v-model="newLearndev.learn_fr" :max="maxDate"/>
                                        </div>
                                        <div>
                                            <label class="label-field">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                            <input class="input-field" type="date" v-model="newLearndev.learn_to"/>
                                        </div>
                                        <div>
                                            <label class="label-field">NUMBER OF HOURS</label>
                                            <input class="input-field" type="number" v-model="newLearndev.learn_hrs" @input="validateNumber('learn_hrs', 'newLearndevk')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">TYPE OF LD (MANAGERIAL/SUPERVISORY/TECHNICAL/ETC)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_type" @input="validateName('learn_type', 'newLearndev')"/>
                                        </div>
                                        <div>
                                            <label class="label-field">CONDUCTED/SPONSORED BY (WRITE IN FULL)</label>
                                            <input class="input-field" type="text" v-model="newLearndev.learn_con" @input="validateName('learn_con', 'newLearndev')"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-4 mt-4">
                                        <button @click="hideAddLearndevDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button @click="addLearndev" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Add Recognition & Distinctions Modal -->
                    <div v-if="showAddRecogdistDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h2 class="mb-4 text-xl font-semibold">Add Recognition & Distinctions</h2>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="label-field">NON-ACADEMIC DISTINCTIONS/RESTRICTIONS</label>
                                            <input class="input-field" type="text" v-model="newRecogdist.recog_name" @input="validateName('recog_name', 'newRecogdist')"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-center gap-4 mt-4">
                                        <button @click="hideAddRecogdistDialog" class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button @click="addRecogdist" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Update Confirmation Modal -->
                    <div v-if="showUpdateDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-md p-6 overflow-hidden text-center transition-all transform bg-white rounded-lg shadow-xl">
                                <i class="mt-4 mb-4 text-4xl fas fa-circle-question" style="color: red;"></i>
                                <h2 class="mb-4 text-xl font-semibold">Are you sure you want to update?</h2>
                                <p class="mb-4">If you are certain, click 'Confirm' to proceed. Otherwise, click 'Cancel' to go back and review the information.</p>
                                <div class="flex justify-center gap-4">
                                    <button @click="hideUpdateDialog" class="py-2 px-4 rounded bg-red-300 text-#dc3545-700 hover:bg-#dc3545-400">
                                        Cancel
                                    </button>
                                    <button @click="saveUpdate" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                        Confirm
                                    </button>
                                </div>
                            </div>
                    </div>

                    <!-- Update Success Modal -->
                    <div v-if="showSuccessDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="w-full max-w-lg overflow-hidden transition-all transform bg-white rounded-lg shadow-xl">
                                <div class="p-4">
                                    <div class="text-center">
                                        <i class="mb-4 text-4xl fas fa-check-circle" style="color: green;"></i>
                                        <h2 class="mb-4 text-xl font-semibold">Updated Successfully!</h2>
                                        <p class="mb-4">Details have been successfully updated. Press 'Back' to continue.</p>
                                    </div>
                                    <div class="flex justify-center">
                                        <button @click="hideSuccessDialog" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
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

    data() {
        return {
            governmentIdFields: {
            sssId: '',
            pagIbigId: '',
            tinId: '',
            gsisId: '',
            philHealthId: ''
        },
        otherInfo: {
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
            soloParentDetails: '',
        },
        currentPage: 1,
        totalPages: 5,
        activeTab: 0,
        isEditingProfile: false,
        originalProfileFields: {},
        cseligibilityData: [],
        voluntaryworkData: [],
        learndevData: [],
        recogdistData: [],
        originalGovIdFields: {},
        newCSEligibility: {
            eli_service: '',
            eli_rating: '',
            eli_doe: '',
            eli_poe: '',
            eli_license_no: '',
            eli_licen_valid: ''
        },

        newVoluntaryWork: {
            vol_name: '',
            vol_add: '',
            vol_fr: '',
            vol_to: '',
            vol_hrs: '',
            vol_pos: ''
        },

        newLearndev: {
            learn_title: '',
            learn_fr: '',
            learn_to: '',
            learn_hrs: '',
            learn_type: '',
            learn_con: ''
        },

        newRecogdist: {
            recog_name: ''
        },
        isEditingGovId: false,
        showAddCSEligibilityDialog: false,
        showAddVoluntaryWorkDialog: false,
        showAddLearndevDialog: false,
        showAddRecogdistDialog: false,
        showSuccessDialog: false,
        showUpdateDialog: false,
        showEditDialog: false,
        selectedRow: null,
        editFields: {},
        currentTabLabel: '',
    };
    },

    computed: {
        maxDate() {
      const today = new Date();
      const year = today.getFullYear();
      const month = (today.getMonth() + 1).toString().padStart(2, '0');
      const day = today.getDate().toString().padStart(2, '0');
      return `${year}-${month}-${day}`;
    },
        filteredEditFields() {
            return Object.fromEntries(
                Object.entries(this.editFields).filter(([key]) =>
                    !key.endsWith('_count') && !key.startsWith('Emp') && !key.endsWith('at')
                )
            );
        },
        maxDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
    },


    methods: {


    validateAlphabetOnly(field, model) {
        this[model][field] = this[model][field].replace(/[^a-zA-Z\s]/g, '');
    },

    validateName(field, model) {
      this[model][field] = this[model][field].replace(/[0-9]/g, '');
    },

    validateMobileNumber(field, model) {
      this[model][field] = this[model][field].replace(/\D/g, '').slice(0, 10);
    },

    validateTelephoneNumber(field, model) {
      this[model][field] = this[model][field].replace(/\D/g, '').slice(0, 7);
    },

    validateNumberOnly(field, model) {
        this[model][field] = this[model][field].replace(/\D/g, '');
    },

    validateDecimal(field, model) {
        const value = this[model][field];
        // Regex to allow only numbers and one decimal point
        const regex = /^\d*\.?\d*$/;

        if (!regex.test(value)) {
            // If the value doesn't match the regex, strip non-numeric characters except for the first decimal
            this[model][field] = value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
        }
    },

    hideEditDialog() {
        this.showEditDialog = false;
    },

    saveEdit() {
        this.hideEditDialog();
    },

    getInputType(key, value) {
        if (typeof value === 'number') return 'number';
        if (key.includes('date')) return 'date';
        return 'text';
    },

    tabButtonClass(tabName) {
            return {
                'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
                'bg-blue-900 text-white': this.activeTab === tabName,
                'bg-gray-300 text-gray-700': this.activeTab !== tabName,
            };
        },

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
                url = '/emp_eligibility/UpdateCSEligibilityData';
                dataArray = this.cseligibilityData;
                countField = 'eli_count';
                break;
            case 1:
                url = '/emp_voluntary/UpdateVoluntaryWorkData';
                dataArray = this.voluntaryworkData;
                countField = 'vol_count';
                break;
            case 2:
                url = '/emp_learning/UpdateLearnDevData';
                dataArray = this.learndevData;
                countField = 'learn_count';
                break;
            case 3:
                url = '/emp_recog/UpdateRecogDistData';
                dataArray = this.recogdistData;
                countField = 'recog_count';
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
                case 0: return 'CS ELigibility';
                case 1: return 'Voluntary Work';
                case 2: return 'Learning & Development';
                case 3: return 'Recognition and Distinctions';
                default: return '';
            }
        },

        updateData() {
            const urlMap = {
                0: '/emp_eligibility/UpdateCSEligibilityData',
                1: '/emp_voluntary/UpdateVoluntaryWorkData',
                2: '/emp_learning/UpdateLearnDevData',
                3: '/emp_recog/UpdateRecogDistData'
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
            if (!this.isEditingGovId) {
                // Save the current state of fields to allow canceling
                this.originalGovIdFields = JSON.parse(JSON.stringify(this.governmentIdFields));
            }
            this.isEditingGovId = !this.isEditingGovId;
        },

        cancelGovIdEditing() {
            // Revert changes by restoring original fields
            this.governmentIdFields = JSON.parse(JSON.stringify(this.originalGovIdFields));
            this.isEditingGovId = false;
        },

        async fetchSSSid() {
            try {
                const response = await axios.get('/sssinfo/SSSId');
                this.governmentIdFields.sssId = response.data.sssId;
            } catch (error) {
                this.errorMessage = 'Failed to load SSS Id.';
            }
        },

        async fetchGSISid() {
            try {
                const response = await axios.get('/gsisinfo/GSISId');
                this.governmentIdFields.gsisId = response.data.gsisId;
            } catch (error) {
                this.errorMessage = 'Failed to load GSIS Id.';
            }
        },

        async fetchPagIbigId() {
            try {
                const response = await axios.get('/pagibiginfo/PagIbigId');
                this.governmentIdFields.pagIbigId = response.data.pagIbigId;
            } catch (error) {
                this.errorMessage = 'Failed to load PagIbig Id.';
            }
        },

        async fetchPhilHealthId() {
            try {
                const response = await axios.get('/philhealthinfo/PhilHealthId');
                this.governmentIdFields.philHealthId = response.data.philHealthId;
            } catch (error) {
                this.errorMessage = 'Failed to load PhilHealth Id.';
            }
        },

        async fetchTINId() {
            try {
                const response = await axios.get('/tininfo/TINId');
                this.governmentIdFields.tinId = response.data.tinId;
            } catch (error) {
                this.errorMessage = 'Failed to load TIN Id.';
            }
        },


        async updateGovIdData() {
            try {
                await axios.patch('/governmentId/updateGovIdData', this.governmentIdFields);
                this.isEditing = false;
                this.showUpdateDialog = false;
                this.showSuccessDialog = true;
                // location.reload();
                } catch (error) {
                this.errorMessage = 'Failed to update ID. Please try again.';
                this.showUpdateDialog = false;
            }
        },

        fetchData() {
        axios.get('/emp_otherinfo/other-info')
            .then(response => {
                this.otherInfo = response.data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    },

    confirmUpdate() {
        this.showUpdateDialog = true; // Show the update confirmation modal
    },
    updateData() {
        axios.put('/emp_otherinfo/other-info', this.otherInfo)
            .then(response => {
                this.showUpdateDialog = false; // Hide the update confirmation dialog
                this.showSuccessDialog = true; // Show success dialog
            })
            .catch(error => {
                console.error('Error updating data:', error);
            });
    },
    saveUpdate() {
        this.updateData(); // Call the updateData method to proceed with the update
    },
    hideUpdateDialog() {
        this.showUpdateDialog = false; // Hide the update confirmation dialog
    },
    hideSuccessDialog() {
        this.showSuccessDialog = false; // Hide the success dialog
    },

    },

    mounted() {
        this.fetchSSSid();
        this.fetchGSISid();
        this.fetchPagIbigId();
        this.fetchPhilHealthId();
        this.fetchTINId();
        this.fetchData();
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

        const showAddCSEligibilityDialog = ref(false);
        const showAddVoluntaryWorkDialog = ref(false);
        const showAddLearndevDialog = ref(false);
        const showAddRecogdistDialog = ref(false);
        const showSuccessDialog = ref(false);
        const showUpdateDialog = ref(false);


        const openAddDialog = () => {
            if (activeTab.value === 0) {
                showAddCSEligibilityDialog.value = true;
            } else if (activeTab.value === 1) {
                showAddVoluntaryWorkDialog.value = true;
            } else if (activeTab.value === 2) {
                showAddLearndevDialog.value = true;
            } else if (activeTab.value === 3) {
                showAddRecogdistDialog.value = true;
            }
        };

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
            vol_add: '',
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

        const searchQuery = ref('');


        const hideUpdateDialog = () => {
            showUpdateDialog.value = false;
        };

        const hideSuccessDialog = () => {
            showSuccessDialog.value = false;
        };

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
        });

        return {
            activeTab,
            currentPage,
            totalPages,
            previousPage,
            nextPage,
            cseligibilityData,
            voluntaryworkData,
            learndevData,
            recogdistData,
            openAddDialog,
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
            otherInfo,
            showSuccessDialog,
            searchQuery,
            search,
            showUpdateDialog,
            hideSuccessDialog,
            hideUpdateDialog
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

.custom-cancel-button {
  background-color: #dc3545 !important; /* Red background for cancel button */
  border-color: #dc3545 !important; /* Red border for cancel button */
}

.custom-cancel-button:hover {
  background-color: #e57373 !important; /* Lighter red for hover state */
  border-color: #e57373 !important; /* Lighter red border for hover state */
}

.broken-line {
  display: block;
  width: 100%;
  border-bottom: 1px dashed #000;
  margin: 20px 0;
}

.disabled-input {
  color: #707A88;
  background-color: #eeeeee;
}
</style>

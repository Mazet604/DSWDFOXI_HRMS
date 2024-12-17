<template>
    <AdminLayout>
        <div class="relative z-10">
            <!-- Profile Search Section -->

                <div class="w-full p-8 bg-white border-4 rounded-lg shadow-lg">
                <h1 class="pb-2 mb-4 text-3xl font-bold text-blue-800 border-b border-yellow-200">EMPLOYEE PROFILE</h1>
                <!-- Search Bar -->
                <div class="relative items-center w-1/4 mb-4 search-bar">
                    <div class="flex items-center border border-gray-300 rounded">
                        <!-- Prefix Section -->
                        <div class="flex items-center p-3 text-sm font-semibold text-white bg-blue-800 rounded-l">
                            11<span class="ml-1 text-gray-200 whitespace-nowrap"> — </span>
                        </div>
                        <!-- Input Field -->
                        <input
                            type="text"
                            class="w-full p-2 rounded-r focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter 4-digit Employee ID..."
                            v-model="searchQuery"
                            @input="validateInput"
                            maxlength="4"
                        />
                    </div>
                </div>

                <button
                    class="p-4 py-2 font-semibold text-white bg-blue-800 rounded text-md hover:bg-blue-700"
                    @click="search(searchQuery)"
                >
                    find ID
                </button>

                <!-- Error Message -->
                <div v-if="errorMessage" class="mt-4 text-red-600">
                    {{ errorMessage }}
                </div>

                <!-- Employee Data Table -->
                <div v-if="profileData" class="mt-6">
                <h2 class="text-xl font-bold">Search Result</h2>
                <DataTable
                    :value="[profileData]"
                    selectionMode="single"
                    dataKey="empid"
                    @row-click="showEditModalx"
                    tableStyle="min-width: 100%;"
                    class="mt-4 border border-gray-300"
                >
                    <Column
                    field="empid"
                    header="EMPLOYEE ID"
                    headerStyle="background-color: #1E40AF; color: white; text-align: center;"
                    ></Column>
                    <!-- Combine First Name and Last Name into Full Name -->
                    <Column
                    header="EMPLOYEE NAME"
                    headerStyle="background-color: #1E40AF; color: white; text-align: center;"
                    >
                    <template #body="slotProps">
                        {{ slotProps.data.emp_fname }} {{ slotProps.data.emp_lname }}
                    </template>
                    </Column>
                    <Column
                    field="emp_position"
                    header="POSITION"
                    headerStyle="background-color: #1E40AF; color: white; text-align: center;"
                    ></Column>
                </DataTable>
                </div>
            </div>
            <div v-if="isEditModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                        <div class="relative p-6 bg-white rounded-lg shadow-lg modal">
                            <!-- Close Button -->
                            <button
                                class="absolute text-4xl font-bold text-gray-500 top-2 right-4 hover:text-gray-800"
                                @click="handleCloseModal"
                                aria-label="Close">
                                &times;
                            </button>

                        <!-- Modal Header -->
                        <div>
                            <h2 class="pb-2 mb-4 text-3xl font-bold text-blue-800 border-b border-yellow-200">EDIT EMPLOYEE DETAILS</h2>
                        </div>
                    <!-- Tabs Navigation -->
                    <div class="mb-4">
                        <button @click="activeMainTab = 0" :class="mainTabButtonClass(0)">PERSONAL</button>
                        <button @click="activeMainTab = 1" :class="mainTabButtonClass(1)">BACKGROUND</button>
                        <button @click="activeMainTab = 2" :class="mainTabButtonClass(2)">OTHER INFO</button>
                    </div>
                    <!-- PERSONAL Tab -->
                    <div v-if="activeMainTab === 0">
                        <div class="flex justify-end -mb-px">
                            <button @click="activeSubTab = 0" :class="subTabButtonClass(0)">PERSONAL INFORMATION</button>
                            <button @click="activeSubTab = 1" :class="subTabButtonClass(1)">ADDRESS</button>
                        </div>
                        <div v-if="activeSubTab === 0" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <!-- PERSONAL INFORMATION CONTENT-->
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">PERSONAL INFORMATION</h2>

                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">SURNAME <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_lname" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">FIRST NAME <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_fname" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_mname" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">SUFFIX</label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.emp_ext">
                                        <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">{{ ext.text }}</option>
                                    </select>
                                </div>

                            </div>

                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">DATE OF BIRTH <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="date" v-model="profileData.emp_dob" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">PLACE OF BIRTH</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_pob" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">SEX <span style="color: red;">*</span></label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.emp_sex">
                                        <option v-for="sex in sexOptions" :key="sex.value" :value="sex.value">{{ sex.text }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">CIVIL STATUS <span style="color: red;">*</span></label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.emp_civ_stat">
                                        <option v-for="status in civilStatusOptions" :key="status.value" :value="status.value">{{ status.text }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">HEIGHT (CM) <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_height" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">WEIGHT (KG) <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.emp_weight" />
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">BLOOD TYPE</label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.emp_blood">
                                        <option v-for="type in bloodTypeOptions" :key="type.value" :value="type.value">{{ type.text }}</option>
                                    </select>
                                </div>
                            </div>

                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">CONTACT INFORMATION</h2>
                            <div class="grid grid-cols-4 gap-4 mb-6">
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">MOBILE NUMBER <span style="color: red;">*</span></label>
                                    <div class="flex items-center">
                                    <span class="p-2 bg-gray-200 border border-gray-300 rounded-l-md" style="color:#707A88;">+63</span>
                                    <input class="w-5 p-2 border rounded" v-model="profileData.emp_cnum" />
                                </div>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-bold text-gray-700">TELEPHONE NUMBER <span style="color: red;">*</span></label>
                                    <input class="w-full p-2 border rounded" v-model="profileData.emp_telnum" />
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">SAVE</button>
                                </div>
                        </div>
                        <div v-if="activeSubTab === 1" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <!-- ADDRESS CONTENT-->
                        <!-- Residential Address -->
                        <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">RESIDENTIAL ADDRESS</h2>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">REGION <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.residentialRegion" @change="fetchProvinces(profileData.residentialRegion, 'residential')">
                                    <option v-for="region in regions" :key="region.reg_psgc" :value="region.reg_psgc">{{ region.col_region }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">PROVINCE <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.residentialProvince" @change="fetchCities(profileData.residentialProvince, 'residential')">
                                    <option v-for="province in provinces" :key="province.prv_psgc" :value="province.prv_psgc">{{ province.col_province }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">CITY <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.residentialCity" @change="fetchBarangays(profileData.residentialCity, 'residential')">
                                    <option v-for="city in cities" :key="city.citmun_psgc" :value="city.citmun_psgc">{{ city.col_citymuni }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">BARANGAY <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.residentialBarangay">
                                    <option v-for="barangay in barangays" :key="barangay.brgy_psgc" :value="barangay.brgy_psgc">{{ barangay.col_brgy }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">ZIP CODE <span style="color: red;">*</span></label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.residentialZipcode" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">VILLAGE/SUBDIVISION</label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.residentialVillage" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.residentialStreet" />
                            </div>
                        </div>

                        <!-- Permanent Address -->
                        <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">PERMANENT ADDRESS</h2>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">REGION <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.permanentRegion2" @change="fetchProvinces(profileData.permanentRegion2, 'permanent')">
                                    <option v-for="region in regions" :key="region.reg_psgc" :value="region.reg_psgc">{{ region.col_region }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">PROVINCE <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.permanentProvince2" @change="fetchCities(profileData.permanentProvince2, 'permanent')">
                                    <option v-for="province in permanentProvinces" :key="province.prv_psgc" :value="province.prv_psgc">{{ province.col_province }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">CITY <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.permanentCity2" @change="fetchBarangays(profileData.permanentCity2, 'permanent')">
                                    <option v-for="city in permanentCities" :key="city.citmun_psgc" :value="city.citmun_psgc">{{ city.col_citymuni }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">BARANGAY <span style="color: red;">*</span></label>
                                <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.permanentBarangay2">
                                    <option v-for="barangay in permanentBarangays" :key="barangay.brgy_psgc" :value="barangay.brgy_psgc">{{ barangay.col_brgy }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">ZIP CODE <span style="color: red;">*</span></label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.permanentZipcode2" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">VILLAGE/SUBDIVISION</label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.permanentVillage2" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-bold text-gray-700">BLOCK/STREET/PUROK</label>
                                <input class="w-full p-2 border border-gray-300 rounded-md addgrid" type="text" v-model="profileData.permanentStreet2" />
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">SAVE</button>
                                </div>
                    </div>
                </div>
                    <!-- BACKGROUND Tab -->
                    <div v-if="activeMainTab === 1">
                        <div class="flex justify-end -mb-px">
                            <button @click="activeSubTab = 0" :class="subTabButtonClass(0)">FAMILY</button>
                            <button @click="activeSubTab = 1" :class="subTabButtonClass(1)">EDUCATION</button>
                            <button @click="activeSubTab = 2" :class="subTabButtonClass(2)">ORGANIZATION</button>
                            <button @click="activeSubTab = 3" :class="subTabButtonClass(3)">WORK EXPERIENCE</button>
                            <button @click="activeSubTab = 4" :class="subTabButtonClass(4)">SKILLS</button>
                            <button @click="activeSubTab = 5" :class="subTabButtonClass(5)">REFERENCES</button>
                        </div>
                        <!-- FAMILY Sub-Tab -->
                        <div v-if="activeSubTab === 0" class="p-6 bg-white border-2 border-blue-800 rounded-lg">
                            <!-- SPOUSE SECTION -->
                            <div class="grid grid-cols-5 gap-4">
                                <div class="col-span-5 pb-2 mb-1 text-blue-800 border-b border-yellow-200">
                                    <h1 class="text-lg font-bold">SPOUSE</h1>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_lname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_fname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_mname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SUFFIX</label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.spouse_xname">
                                        <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">{{ ext.text }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">OCCUPATION</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_occup" />
                                </div>
                                <div class="col-span-2">
                                    <label class="block mb-2 text-sm font-bold text-gray-700">EMPLOYER'S/BUSINESS NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_office" />
                                </div>
                                <div class="col-span-2">
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BUSINESS ADDRESS</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_busadd" />
                                </div>
                                <div class="col-span-1">
                                    <label class="block mb-2 text-sm font-bold text-gray-700">TEL. NO.</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.spouse_tel" />
                                </div>
                            </div>

                            <!-- FATHER SECTION -->
                            <div class="grid grid-cols-5 gap-4 mt-6">
                                <div class="col-span-5 pb-2 mb-1 text-blue-800 border-b border-yellow-200">
                                    <h1 class="text-lg font-bold">FATHER</h1>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.father_lname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.father_fname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.father_mname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SUFFIX</label>
                                    <select class="w-full p-2 border border-gray-300 rounded-md" v-model="profileData.father_xname">
                                        <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">{{ ext.text }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- MOTHER SECTION -->
                            <div class="grid grid-cols-5 gap-4 mt-6">
                                <div class="col-span-5 pb-2 mb-1 text-blue-800 border-b border-yellow-200">
                                    <h1 class="text-lg font-bold">MOTHER</h1>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SURNAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.mother_lname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.mother_fname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.mother_mname" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MAIDEN NAME</label>
                                    <input class="w-full p-2 border border-gray-300 rounded-md" type="text" v-model="profileData.maidenname" />
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4">
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">SAVE</button>
                                </div>
                        </div>
                        <!-- Education -->
                        <div v-if="activeSubTab === 1" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">EDUCATION</h2>
                            <DataTable :value="educationList" class="mt-8" @row-click="openEditModal('education', $event.data)" :paginator="true" :rows="5">
                                <Column field="educ_level" header="LEVEL OF EDUCATION"></Column>
                                <Column field="educ_school" header="NAME OF SCHOOL"></Column>
                                <Column field="educ_degree" header="BASIC EDUCATION | DEGREE | COURSE"></Column>
                                <Column field="educ_from" header="DATE ENROLLED"></Column>
                                <Column field="educ_hl_earned" header="HIGHEST LEVEL EARNED"></Column>
                                <Column field="educ_year_grad" header="YEAR GRADUATED"></Column>
                                <Column field="educ_academic_honor" header="SCHOLARSHIPS & ACADEMIC EXCELLENCE"></Column>
                            </DataTable>
                        </div>
                        <!-- Organization -->
                        <div v-if="activeSubTab === 2" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">ORGANIZATIONS</h2>
                            <DataTable :value="organizationList" class="mt-8" @row-click="openEditModal('organization', $event.data)" :paginator="true" :rows="5">
                                <Column field="org_name"></Column>
                            </DataTable>
                        </div>
                        <!-- Work Experience -->
                        <div v-if="activeSubTab === 3" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">WORK EXPERIENCE</h2>
                            <DataTable :value="workExperienceList" class="mt-8" @row-click="openEditModal('workExperience', $event.data)" :paginator="true" :rows="5">
                                <Column field="workfr" header="WORK FROM"></Column>
                                <Column field="workto" header="WORK TO"></Column>
                                <Column field="work_pos" header="POSITION"></Column>
                                <Column field="work_dept" header="DEPARTMENT | AGENCY | OFFICE | COMPANY"></Column>
                                <Column field="work_salary" header="MONTHLY SALARY"></Column>
                                <Column field="work_salarygrade" header="SALARY GRADE"></Column>
                                <Column field="work_stat" header="STATUS OF APPOINTMENT"></Column>
                                <Column field="work_gov" header="GOV'T SERVICE"></Column>
                            </DataTable>
                        </div>
                        <!-- Skills -->
                        <div v-if="activeSubTab === 4" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">SKILLS</h2>
                            <DataTable :value="skillsList" class="mt-8" @row-click="openEditModal('skills', $event.data)" :paginator="true" :rows="5">
                                <Column field="skill"></Column>
                            </DataTable>
                        </div>
                        <!-- References Tab -->
                        <div v-if="activeSubTab === 5" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">REFERENCES</h2>
                            <DataTable :value="referencesList" class="mt-8" @row-click="openEditModal('references', $event.data)" :paginator="true" :rows="5">
                                <Column field="full_name" header="FULL NAME"></Column>
                                <Column field="ref_add" header="BLOCK | STREET | PUROK"></Column>
                                <Column field="ref_cnum" header="TELEPHONE NUMBER"></Column>
                            </DataTable>
                        </div>
                    </div>
                    <!-- OTHER INFO Tab -->
                    <div v-if="activeMainTab === 2">
                        <div class="flex justify-end -mb-px">
                            <button @click="activeSubTab = 0" :class="subTabButtonClass(0)">CS ELIGIBILITY</button>
                            <button @click="activeSubTab = 1" :class="subTabButtonClass(1)">VOLUNTARY WORK</button>
                            <button @click="activeSubTab = 2" :class="subTabButtonClass(2)">LEARNING & DEVELOPMENT</button>
                            <button @click="activeSubTab = 3" :class="subTabButtonClass(3)">RECOGNITION & DISTINCTION</button>
                            <button @click="activeSubTab = 4" :class="subTabButtonClass(4)">GOVERNMENT ID</button>
                        </div>
                    <!-- CS Eligibility -->
                    <div v-if="activeSubTab === 0" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                        <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">CS ELIGIBILITY</h2>
                        <DataTable :value="csEligibilityList" class="mt-8" @row-click="openEditModal('csEligibility', $event.data)" :paginator="true" :rows="5">
                            <Column field="eli_service" header="CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES/CSEE/BARANGAY ELIGIBILITY/DRIVERS LICENSE"></Column>
                            <Column field="eli_rating" header="RATING (IF APPLICABLE)"></Column>
                            <Column field="eli_doe" header="DATE OF EXAMINATION/CONFERMENT"></Column>
                            <Column field="eli_poe" header="PLACE OF EXAMINATION/CONFERMENT"></Column>
                            <Column field="eli_license_no" header="LICENSE (IF APPLICABLE)"></Column>
                            <Column field="eli_licen_valid" header="VALIDITY"></Column>
                        </DataTable>
                    </div>
                        <!-- Voluntary Work -->
                        <div v-if="activeSubTab === 1" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">VOLUNTARY WORK</h2>
                            <DataTable :value="voluntaryWorkList" class="mt-8" @row-click="openEditModal('voluntaryWork', $event.data)" :paginator="true" :rows="5">
                                <Column field="vol_name" header="NAME OF ORGANIZATION"></Column>
                                <Column field="vol_add" header="ADDRESS OF ORGANIZATION"></Column>
                                <Column field="vol_fr" header="INCLUSIVE DATES FROM"></Column>
                                <Column field="vol_to" header="INCLUSIVE DATES TO"></Column>
                                <Column field="vol_hrs" header="NUMBER OF HOURS"></Column>
                                <Column field="vol_pos" header="POSITION | NATURE OF WORK"></Column>
                            </DataTable>
                        </div>
                        <!-- Learning & Development -->
                        <div v-if="activeSubTab === 2" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">LEARNING & DEVELOPMENT</h2>
                            <DataTable :value="learningDevelopmentList" class="mt-8" @row-click="openEditModal('learningDevelopment', $event.data)" :paginator="true" :rows="5">
                                <Column field="learn_title" header="TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS | TRAINING PROGRAM (WRITE IN FULL)"></Column>
                                <Column field="learn_fr" header="INCLUSIVE DATES (MM/DD/YYYY) FROM"></Column>
                                <Column field="learn_to" header="INCLUSIVE DATES (MM/DD/YYYY) TO"></Column>
                                <Column field="learn_hrs" header="NUMBER OF HOURS"></Column>
                                <Column field="learn_type" header="TYPE OF LD (MANAGERIAL | SUPERVISORY | TECHNICAL | ETC)"></Column>
                                <Column field="learn_con" header="CONDUCTED/SPONSORED BY (WRITE IN FULL)"></Column>
                            </DataTable>
                        </div>
                        <!-- Recognition & Distinctions -->
                        <div v-if="activeSubTab === 3" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">RECOGNITION & DISTINCTION</h2>
                            <DataTable :value="recognitionList" class="mt-8" @row-click="openEditModal('recognition', $event.data)" :paginator="true" :rows="5">
                                <Column field="recog_name"></Column>
                            </DataTable>
                        </div>
                        <!-- Government IDs -->
                        <div v-if="activeSubTab === 4" class="p-6 bg-white border-2 border-blue-800 rounded-sm">
                            <h2 class="pb-2 mb-4 text-lg font-semibold text-blue-800 border-b border-yellow-200">GOVERNMENT ID</h2>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 font-bold text-gray-700 text-md">GSIS ID</label>
                                    <input type="text" v-model="profileData.pb_no" class="w-full p-2 border rounded addgrid" placeholder="Enter GSIS ID">
                                </div>
                                <div>
                                    <label class="block mb-2 font-bold text-gray-700 text-md">Pag-IBIG ID</label>
                                    <input type="text" v-model="profileData.pgbg_id" class="w-full p-2 border rounded addgrid" placeholder="Enter Pag-IBIG ID">
                                </div>
                                <div>
                                    <label class="block mb-2 font-bold text-gray-700 text-md">PhilHealth ID</label>
                                    <input type="text" v-model="profileData.ph_lid" class="w-full p-2 border rounded addgrid" placeholder="Enter PhilHealth ID">
                                </div>
                                <div>
                                    <label class="block mb-2 font-bold text-gray-700 text-md">SSS ID</label>
                                    <input type="text" v-model="profileData.sss_num" class="w-full p-2 border rounded addgrid" placeholder="Enter SSS ID">
                                </div>
                                <div>
                                    <label class="block mb-2 font-bold text-gray-700 text-md">TIN ID</label>
                                    <input type="text" v-model="profileData.tin_id" class="w-full p-2 border rounded addgrid" placeholder="Enter TIN ID">
                                </div>
                            </div>
                            <div class="flex justify-end space-x-4">
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-md hover:bg-blue-800">SAVE</button>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center ">
                    <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                        <h3 class="mb-4 text-lg font-bold">Edit {{ currentEditType }}</h3>
                    <!-- Education Modal -->
                    <div v-if="isModalOpen && currentEditType === 'education'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT EDUCATION</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">LEVEL OF EDUCATION</label>
                                    <input v-model="selectedRow.educ_level" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">NAME OF SCHOOL</label>
                                    <input v-model="selectedRow.educ_school" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BASIC EDUCATION | DEGREE | COURSE</label>
                                    <input v-model="selectedRow.educ_degree" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">DATE ENROLLED</label>
                                    <input v-model="selectedRow.educ_from" type="date" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">HIGHEST LEVEL EARNED</label>
                                    <input v-model="selectedRow.educ_hl_earned" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">YEAR GRADUATED</label>
                                    <input v-model="selectedRow.educ_year_grad" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                                    <input v-model="selectedRow.educ_academic_honor" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>"py-2 text-sm
                            </div>
                        </div>
                    </div>

                    <!-- Organization Modal -->
                    <div v-if="isModalOpen && currentEditType === 'organization'" class="fixed inset-0 z-50 flex items-center justify-center">
                        <div class="w-1/4 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT ORGANIZATION</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">ORGANIZATION NAME</label>
                                    <input v-model="selectedRow.org_name" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="justify-end mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Work Experience Modal -->
                    <div v-if="isModalOpen && currentEditType === 'workExperience'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT WORK EXPERIENCE</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">WORK FROM</label>
                                    <input v-model="selectedRow.workfr" type="date" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">WORK TO</label>
                                    <input v-model="selectedRow.workto" type="date" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">POSITION</label>
                                    <input v-model="selectedRow.work_pos" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">DEPARTMENT | AGENCY | OFFICE | COMPANY</label>
                                    <input v-model="selectedRow.work_dept" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MONTHLY SALARY</label>
                                    <input v-model="selectedRow.work_salary" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SALARY GRADE</label>
                                    <input v-model="selectedRow.work_salarygrade" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">STATUS OF APPOINTMENT</label>
                                    <input v-model="selectedRow.work_stat" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">GOV'T SERVICE</label>
                                    <input v-model="selectedRow.work_gov" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Skills Modal -->
                    <div v-if="isModalOpen && currentEditType === 'skills'" class="fixed inset-0 z-50 flex items-center justify-center">
                        <div class="w-1/4 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT SKILLS</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SKILL</label>
                                    <input v-model="selectedRow.skill" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- References Form Modal -->
                    <div v-if="isModalOpen && currentEditType === 'references'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT REFERENCES</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">FIRST NAME</label>
                                    <input v-model="selectedRow.ref_fname" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">MIDDLE NAME</label>
                                    <input v-model="selectedRow.ref_mname" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">LAST NAME</label>
                                    <input v-model="selectedRow.ref_lname" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">SUFFIX</label>
                                    <select v-model="selectedRow.ref_xname" class="w-full p-2 mb-4 border border-gray-300 rounded">
                                        <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">
                                            {{ ext.text }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">BLOCK | STREET | PUROK</label>
                                    <input v-model="selectedRow.ref_add" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">TELEPHONE NUMBER</label>
                                    <input v-model="selectedRow.ref_cnum" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                   <!-- CS Eligibility Modal -->
                    <div v-if="isModalOpen && currentEditType === 'csEligibility'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT CS ELIGIBILITY</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">CAREER SERVICE | RA 1080</label>
                                    <input v-model="selectedRow.eli_service" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">RATING (IF APPLICABLE)</label>
                                    <input v-model="selectedRow.eli_rating" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">DATE OF EXAMINATION | CONFERMENT</label>
                                    <input type="date" v-model="selectedRow.eli_doe" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">PLACE OF EXAMINATION | CONFERMENT</label>
                                    <input v-model="selectedRow.eli_poe" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">LICENSE (IF APPLICABLE)</label>
                                    <input v-model="selectedRow.eli_license_no" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">VALIDITY</label>
                                    <input v-model="selectedRow.eli_licen_valid" type="date" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Voluntary Work Modal -->
                    <div v-if="isModalOpen && currentEditType === 'voluntaryWork'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT VOLUNTARY WORK</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">NAME OF ORGANIZATION (WRITE IN FULL)</label>
                                    <input v-model="selectedRow.vol_name" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">ADDRESS OF ORGANIZATION</label>
                                    <input v-model="selectedRow.vol_add" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                    <input type="date" v-model="selectedRow.vol_fr" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                    <input type="date" v-model="selectedRow.vol_to" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">NUMBER OF HOURS</label>
                                    <input v-model="selectedRow.vol_hrs" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">POSITION / NATURE OF WORK</label>
                                    <input v-model="selectedRow.vol_pos" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Learning & Development Modal -->
                    <div v-if="isModalOpen && currentEditType === 'learningDevelopment'" class="fixed inset-0 z-50 flex items-center justify-center ">
                        <div class="w-1/2 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center">EDIT LEARNING & DEVELOPMENT</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">LEARNING AND DEVELOPMENT INTERVENTIONS</label>
                                    <input v-model="selectedRow.learn_title" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                                    <input type="date" v-model="selectedRow.learn_fr" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                                    <input type="date" v-model="selectedRow.learn_to" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">NUMBER OF HOURS</label>
                                    <input v-model="selectedRow.learn_hrs" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">TYPE OF LD (MANAGERIAL | SUPERVISORY | TECHNICAL | ETC)</label>
                                    <input v-model="selectedRow.learn_type" class="w-full p-2 mb-4 border rounded">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-gray-700">CONDUCTED | SPONSORED BY (WRITE IN FULL)</label>
                                    <input v-model="selectedRow.learn_con" class="w-full p-2 mb-4 border rounded">
                                </div>
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                    <!-- Recognition & Distinction Modal -->
                    <div v-if="isModalOpen && currentEditType === 'recognition'" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-75">
                        <div class="w-1/4 p-6 bg-white rounded shadow-lg">
                            <h3 class="mb-4 text-xl font-bold text-center uppercase">Edit Recognition & Distinction</h3>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-gray-700">NON-ACADEMIC DISTINCTIONS | RESTRICTIONS</label>
                                <input v-model="selectedRow.recog_name" class="w-full p-2 mb-4 border rounded">
                            </div>
                            <div class="mt-4 space-x-4 text-center">
                                <button @click="closeModal" class="px-4 py-2 text-sm font-semibold text-white bg-red-700 rounded-md hover:bg-red-800">CANCEL</button>
                                <button class="py-2 text-sm font-semibold text-white bg-blue-900 rounded-md px-7 hover:bg-blue-800">SAVE</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </AdminLayout>
</template>

<script>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import axios from 'axios';
import DashboardScripts from './Scripts/DashboardScripts.vue';
import Dashboard from '@/Pages/Dashboard.vue';
import Background from '@/Pages/Background.vue';
import OtherInfo from '@/Pages/OtherInfo.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';


export default {
  components: {
    AdminLayout,
    DashboardScripts,
    Dashboard,
    Background,
    OtherInfo,
    DataTable,
    Column,
  },
  data() {
  return {
    searchQuery: '',
    errorMessage: '',
    profileData: null,
    residentialRegion: '',
    isEditModalVisible: false,
    activeMainTab: 0, // Tracks the main tab (Personal, Background, Other Info)
    activeSubTab: 0, // Tracks the sub-tab for each main tab
    isEditing: false,
    showUpdateDialog: false,
    showSuccessDialog: false,
    sexOptions: [], // Sex for dropdown
    civilStatusOptions: [], // Civil Status for dropdown
    bloodTypeOptions: [], // Blood Type for dropdown
    extOptions: [], // Extension for dropdown
    regions: [], // Regions for dropdown
    provinces: [], // Provinces for dropdown
    cities: [], // Cities for dropdown
    barangays: [], // Barangays for dropdown
    permanentRegions: [], // For permanent address
    permanentProvinces: [], // For permanent address
    permanentCities: [], // For permanent address
    permanentBarangays: [], // For permanent address
// new added 12/11
    organizationList: [], // List of organizations dynamically populated
    skillsList: [], // List to store skills dynamically
    recognitionList: [], // List to store recognition & distinction data
    referencesList: [],
    educationList: [], // List to store education data
    workExperienceList: [],
    csEligibilityList: [],
    voluntaryWorkList: [],
    learningDevelopmentList: [],
    isModalOpen: false,
    currentEditType: '',
    selectedRow: null,

  };
},

watch: {
  'profileData.residentialRegion': function (newVal) {
  if (newVal) {
    this.fetchProvinces(newVal, 'residential');
  }
},
  'profileData.residentialProvince': function (newVal) {
    if (newVal) this.fetchCities(newVal, 'residential'); // Correct method
  },
  'profileData.residentialCity': function (newVal) {
    if (newVal) this.fetchBarangays(newVal, 'residential'); // Correct method
  },
  'profileData.permanentRegion2': function (newVal) {
//   console.log(`Region changed to: ${newVal}`);
  if (newVal) {
    this.fetchProvinces(newVal, 'permanent');
  }
},
  'profileData.permanentProvince2': function (newVal) {
    if (newVal) this.fetchCities(newVal, 'permanent'); // Correct method
  },
  'profileData.permanentCity2': function (newVal) {
    if (newVal) this.fetchBarangays(newVal, 'permanent'); // Correct method
  },
},


  methods: {

    mainTabButtonClass(tabIndex) {
      return {
        'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
        'bg-blue-900 text-white': this.activeMainTab === tabIndex,
        'bg-gray-300 text-gray-700': this.activeMainTab !== tabIndex,
      };
    },
    subTabButtonClass(tabIndex) {
      return {
        'px-4 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
        'bg-blue-800 text-white': this.activeSubTab === tabIndex,
        'bg-gray-200 text-gray-600': this.activeSubTab !== tabIndex,
      };
    },

    openEditModal(type, row) {
      this.currentEditType = type;
      this.selectedRow = { ...row }; // Avoid direct mutation
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedRow = null;
    },

    handleCloseModal() {
        // Add any additional logic if needed
        console.log("Closing modal...");
        this.isEditModalVisible = false; // Hide the modal
    },


    validateInput() {
      this.searchQuery = this.searchQuery.replace(/\D/g, ''); // Replace non-digit characters
    },

    search(query) {
      if (!query.trim() || query.length !== 4) {
        this.errorMessage = 'Please enter a valid 4-digit Employee ID.';
        this.profileData = null;
        return;
      }

      const fullEmpId = `11-${query}`; // Construct the full Employee ID with the prefix

      axios
        .get(`/api/search-employee?empid=${fullEmpId}`)
        .then((response) => {
          if (response.data && response.data.empid) {
            this.profileData = response.data; // Populate profile details
            this.errorMessage = ''; // Clear any previous error
//new added 11/22
            this.fetchEmployeeAddress(response.data.emp_count); // Pass emp_count for address fetching
//new added 11/25
            this.fetchEmployeeAddress2(response.data.emp_count); // Fetch permanent address
// Fetch spouse details
            this.fetchSpouseDetails(response.data.emp_count); // Spouse details
// added 11/30
            this.fetchFatherDetails(response.data.emp_count); // Fetch father details
            this.fetchMotherDetails(response.data.emp_count); // Fetch mother details
// added 12/01
            if (response.data.educ_count) {
                this.fetchEducation(response.data.educ_count, null); // Fetch by educ_count
                 } else {
                this.fetchEducation(null, response.data.empid); // Fallback to empid
                }
            if (response.data.org_count) {
                    this.fetchOrganization(response.data.org_count, null); // Fetch by org_count
                } else {
                    this.fetchOrganization(null, response.data.empid); // Fallback to empid
                }
            if (response.data.work_count) {
                    this.fetchWorkExperience(response.data.work_count, null); // Fetch by work_count
                } else {
                    this.fetchWorkExperience(null, response.data.empid); // Fallback to empid
                }
            if (response.data.skill_count) {
                    this.fetchSkills(response.data.skill_count, null); // Fetch by skill_count
                } else {
                    this.fetchSkills(null, response.data.empid); // Fallback to empid
                }
// new added 12/02
            if (response.data.ref_count) {
                    this.fetchReference(response.data.ref_count, null); // Fetch by reference_count
                } else {
                    this.fetchReference(null, response.data.empid); // Fallback to empid
                }
            this.fetchExtOptions();
            this.fetchSexOptions();
            this.fetchCivilStatusOptions();
            this.fetchBloodTypeOptions();
// new added 12/06
            if (response.data.eli_count) {
                    this.fetchCSEligiblity(response.data.eli_count, null); // Fetch by eli_count
                } else {
                    this.fetchCSEligiblity(null, response.data.empid); // Fallback to empid
                }
            if (response.data.vol_count) {
                    this.fetchVoluntaryWork(response.data.vol_count, null); // Fetch by vol_count
                } else {
                    this.fetchVoluntaryWork(null, response.data.empid); // Fallback to empid
                }
            if (response.data.learn_count) {
                    this.fetchLearningDevelopment(response.data.learn_count, null); // Fetch by learn_count
                } else {
                    this.fetchLearningDevelopment(null, response.data.empid); // Fallback to empid
                }
            if (response.data.recog_count) {
                    this.fetchRecognitionDistinction(response.data.recog_count, null); // Fetch by recog_count
                } else {
                    this.fetchRecognitionDistinction(null, response.data.empid); // Fallback to empid
                }
// new added 12/07
            if (response.data.sss_count) {
                    this.fetchSSSId(response.data.sss_count, null); // Fetch by sss_count
                } else {
                    this.fetchSSSId(null, response.data.empid); // Fallback to empid
                }
            if (response.data.pgbg_count) {
                    this.fetchPagIbigId(response.data.pgbg_count, null); // Fetch by pgbg_count
                } else {
                    this.fetchPagIbigId(null, response.data.empid); // Fallback to empid
                }
            if (response.data.gsis_count) {
                    this.fetchGSISId(response.data.gsis_count, null); // Fetch by gsis_count
                } else {
                    this.fetchGSISId(null, response.data.empid); // Fallback to empid
                }
// new added 12/09
            if (response.data.phl_count) {
                    this.fetchPhilhealthId(response.data.phl_count, null); // Fetch by phl_count
                } else {
                    this.fetchPhilhealthId(null, response.data.empid); // Fallback to empid
                }
            if (response.data.tin_count) {
                    this.fetchTINId(response.data.tin_count, null); // Fetch by phl_count
                } else {
                    this.fetchTINId(null, response.data.empid); // Fallback to empid
                }
          } else {
            this.errorMessage = 'Employee not found.';
            this.profileData = null; // Clear previous data
          }
        })
        .catch((error) => {
          console.error('Error during search:', error);
          this.errorMessage = 'Invalid ID.';
          this.profileData = null; // Clear previous data
        });
    },

    fetchEmployeeAddress(emp_count) {
            axios
                .get(`/api/get-employee-address?emp_count=${emp_count}`)
                .then((response) => {
                    if (response.data) {
                        // Bind address data to profileData object
                         this.profileData.residentialRegion = response.data.emp_region;
                         this.profileData.residentialProvince = response.data.emp_prov;
                         this.profileData.residentialCity = response.data.emp_city;
                         this.profileData.residentialBarangay = response.data.emp_brgy;
                         this.profileData.residentialZipcode = response.data.emp_zip;
                         this.profileData.residentialVillage = response.data.emp_subd;
                         this.profileData.residentialStreet = response.data.emp_house;
                    }
                })
                .catch((error) => {
                    console.error('Error fetching employee address:', error);
                });
    },

    fetchEmployeeAddress2(emp_count) {
    axios
        .get(`/api/get-employee-address2?emp_count=${emp_count}`)
        .then((response) => {
            if (response.data) {
                // Bind permanent address data to profileData object
                this.profileData.permanentRegion2 = response.data.emp_region2;
                this.profileData.permanentProvince2 = response.data.emp_prov2;
                this.profileData.permanentCity2 = response.data.emp_city2;
                this.profileData.permanentBarangay2 = response.data.emp_brgy2;
                this.profileData.permanentZipcode2 = response.data.emp_zip2;
                this.profileData.permanentVillage2 = response.data.emp_subd2;
                this.profileData.permanentStreet2 = response.data.emp_house2;

                // Fetch provinces, cities, and barangays based on fetched data
                if (response.data.emp_region2) {
                    this.fetchProvinces(response.data.emp_region2, 'permanent');
                }
                if (response.data.emp_prov2) {
                    this.fetchCities(response.data.emp_prov2, 'permanent');
                }
                if (response.data.emp_city2) {
                    this.fetchBarangays(response.data.emp_city2, 'permanent');
                }
            } else {
                console.error("No data received for the permanent address.");
            }
        })
        .catch((error) => {
            console.error("Error fetching permanent address:", error);
        });
},

    fetchSpouseDetails(emp_count) {
        axios
            .get(`/api/get-spouse-details?emp_count=${emp_count}`)
            .then((response) => {
                if (response.data) {
                    this.profileData.spouse_lname = response.data.spouseSurname;
                    this.profileData.spouse_fname = response.data.spouseFirstName;
                    this.profileData.spouse_mname = response.data.spouseMiddleName;
                    this.profileData.spouse_xname = response.data.spouseExtName;
                    this.profileData.spouse_occup = response.data.spouseOccupation;
                    this.profileData.spouse_office = response.data.spouseBusinessName;
                    this.profileData.spouse_busadd = response.data.spouseBusinessAddress;
                    this.profileData.spouse_tel = response.data.spouseTelNo;
                }
            })
            .catch((error) => {
                console.error("Error fetching spouse details:", error);
            });
    },

    fetchFatherDetails(emp_count) {
        axios
            .get(`/api/get-father-details?emp_count=${emp_count}`)
            .then((response) => {
                this.profileData.father_lname = response.data.fatherSurname;
                this.profileData.father_fname = response.data.fatherFirstName;
                this.profileData.father_mname = response.data.fatherMiddleName;
                this.profileData.father_xname = response.data.fatherExtName;
            })
            .catch((error) => {
                console.error('Error fetching father details:', error);
            });
    },

    fetchMotherDetails(emp_count) {
        axios
            .get(`/api/get-mother-details?emp_count=${emp_count}`)
            .then((response) => {
                if (response.data) {
                    this.profileData.mother_lname = response.data.motherSurname;
                    this.profileData.mother_fname = response.data.motherFirstName;
                    this.profileData.mother_mname = response.data.motherMiddleName;
                    this.profileData.maidenname = response.data.motherMaidenName;
                }
            })
            .catch((error) => {
                console.error("Error fetching mother details:", error);
            });
    },

    fetchEducation(educ_count, empid) {
    const queryParam = educ_count ? `educ_count=${educ_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-education-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                // Populate the education list
                if (Array.isArray(response.data)) {
                    this.educationList = response.data.map((educ) => ({
                        educ_count: educ.educ_count,
                        educ_level: educ.educ_level,
                        educ_school: educ.educ_school,
                        educ_degree: educ.educ_degree,
                        educ_from: educ.educ_from,
                        educ_year_grad: educ.educ_year_grad,
                        educ_academic_honor: educ.educ_academic_honor,
                        educ_hl_earned: educ.educ_hl_earned,
                    }));
                } else {
                    // Handle single education entry response
                    const data = response.data;
                    this.educationList = [
                        {
                            educ_count: data.educ_count,
                            educ_level: data.educ_level,
                            educ_school: data.educ_school,
                            educ_degree: data.educ_degree,
                            educ_from: data.educ_from,
                            educ_year_grad: data.educ_year_grad,
                            educ_academic_honor: data.educ_academic_honor,
                            educ_hl_earned: data.educ_hl_earned,
                        },
                    ];
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching education details:", error);
        });
},

    fetchOrganization(org_count, empid) {
    const queryParam = org_count ? `org_count=${org_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-organization-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                // If the response is an array, populate the organization list
                if (Array.isArray(response.data)) {
                    this.organizationList = response.data.map((org) => ({
                        org_count: org.org_count,
                        org_name: org.org_name,
                    }));
                } else {
                    // Handle a single organization response
                    const data = response.data;
                    this.organizationList = [
                        {
                            org_count: data.org_count,
                            org_name: data.org_name,
                        },
                    ];
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching organization name:", error);
        });
},

    fetchWorkExperience(work_count, empid) {
        const queryParam = work_count ? `work_count=${work_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-workexperience-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    // Populate the work experience list
                    if (Array.isArray(response.data)) {
                        this.workExperienceList = response.data.map((work) => ({
                            work_count: work.work_count,
                            workfr: work.workfr,
                            workto: work.workto,
                            work_pos: work.work_pos,
                            work_dept: work.work_dept,
                            work_salary: work.work_salary,
                            work_salarygrade: work.work_salarygrade,
                            work_stat: work.work_stat,
                            work_gov: work.work_gov,
                        }));
                    } else {
                        // Handle single work experience entry response
                        const data = response.data;
                        this.workExperienceList = [
                            {
                                work_count: data.work_count,
                                workfr: data.workfr,
                                workto: data.workto,
                                work_pos: data.work_pos,
                                work_dept: data.work_dept,
                                work_salary: data.work_salary,
                                work_salarygrade: data.work_salarygrade,
                                work_stat: data.work_stat,
                                work_gov: data.work_gov,
                            },
                        ];
                    }
                }
            })
            .catch((error) => {
                console.error("Error fetching work experience details:", error);
            });
    },

    fetchSkills(skill_count, empid) {
    const queryParam = skill_count ? `skill_count=${skill_count}` : `empid=${empid}`;
    axios
      .get(`/api/get-skill-data?${queryParam}`)
      .then((response) => {
        if (response.data) {
          // If the response is an array, populate the skills list
          if (Array.isArray(response.data)) {
            this.skillsList = response.data.map((skill) => ({
              skill_count: skill.skill_count,
              skill: skill.skill,
            }));
          } else {
            // Handle a single skill response
            const data = response.data;
            this.skillsList = [
              {
                skill_count: data.skill_count,
                skill: data.skill,
              },
            ];
          }
        }
      })
      .catch((error) => {
        console.error("Error fetching skills:", error);
        // this.errorMessage = "Unable to fetch skills.";
      });
  },

    fetchReference(ref_count, empid) {
        const queryParam = ref_count ? `ref_count=${ref_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-reference-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    // If the response is an array, populate the references list
                    if (Array.isArray(response.data)) {
                        this.referencesList = response.data.map((ref) => ({
                            ref_count: ref.ref_count,
                            ref_fname: ref.ref_fname,
                            ref_mname: ref.ref_mname,
                            ref_lname: ref.ref_lname,
                            ref_xname: ref.ref_xname,
                            full_name: ref.full_name,
                            ref_add: ref.ref_add,
                            ref_cnum: ref.ref_cnum,
                        }));
                    } else {
                        // Handle a single reference response
                        const data = response.data;
                        this.referencesList = [
                            {
                                ref_count: data.ref_count,
                                ref_fname: data.ref_fname,
                                ref_mname: data.ref_mname,
                                ref_lname: data.ref_lname,
                                ref_xname: data.ref_xname,
                                ref_add: data.ref_add,
                                ref_cnum: data.ref_cnum,
                            },
                        ];
                    }
                }
            })
            .catch((error) => {
                console.error("Error fetching reference details:", error);
            });
    },

    fetchCSEligiblity(eli_count, empid) {
        const queryParam = eli_count ? `eli_count=${eli_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-cseligibility-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                // Populate the CS Eligibility list
                if (Array.isArray(response.data)) {
                    this.csEligibilityList = response.data.map((eligibility) => ({
                        eli_count: eligibility.eli_count,
                        eli_service: eligibility.eli_service,
                        eli_rating: eligibility.eli_rating,
                        eli_doe: eligibility.eli_doe,
                        eli_poe: eligibility.eli_poe,
                        eli_license_no: eligibility.eli_license_no,
                        eli_licen_valid: eligibility.eli_licen_valid,
                    }));
                } else {
                    // Handle single eligibility entry response
                    const data = response.data;
                    this.csEligibilityList = [
                        {
                            eli_count: data.eli_count,
                            eli_service: data.eli_service,
                            eli_rating: data.eli_rating,
                            eli_doe: data.eli_doe,
                            eli_poe: data.eli_poe,
                            eli_license_no: data.eli_license_no,
                            eli_licen_valid: data.eli_licen_valid,
                        },
                    ];
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching CS eligibility details:", error);
        });
},

fetchVoluntaryWork(vol_count, empid) {
    const queryParam = vol_count ? `vol_count=${vol_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-voluntarywork-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                if (Array.isArray(response.data)) {
                    // Populate Voluntary Work list if response is an array
                    this.voluntaryWorkList = response.data.map((work) => ({
                        vol_count: work.vol_count, // Include count
                        vol_name: work.vol_name,
                        vol_add: work.vol_add,
                        vol_fr: work.vol_fr,
                        vol_to: work.vol_to,
                        vol_hrs: work.vol_hrs,
                        vol_pos: work.vol_pos,
                    }));
                } else {
                    // Handle a single Voluntary Work response
                    const data = response.data;
                    this.voluntaryWorkList = [
                        {
                            vol_count: data.vol_count, // Include count
                            vol_name: data.vol_name,
                            vol_add: data.vol_add,
                            vol_fr: data.vol_fr,
                            vol_to: data.vol_to,
                            vol_hrs: data.vol_hrs,
                            vol_pos: data.vol_pos,
                        },
                    ];
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching Voluntary Work details:", error);
        });
},

fetchLearningDevelopment(learn_count, empid) {
    const queryParam = learn_count ? `learn_count=${learn_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-learndev-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                if (Array.isArray(response.data)) {
                    // Populate Learning & Development list if response is an array
                    this.learningDevelopmentList = response.data.map((learn) => ({
                        learn_count: learn.learn_count, // Include count
                        learn_title: learn.learn_title,
                        learn_fr: learn.learn_fr,
                        learn_to: learn.learn_to,
                        learn_hrs: learn.learn_hrs,
                        learn_type: learn.learn_type,
                        learn_con: learn.learn_con,
                    }));
                } else {
                    // Handle a single Learning & Development response
                    const data = response.data;
                    this.learningDevelopmentList = [
                        {
                            learn_count: data.learn_count, // Include count
                            learn_title: data.learn_title,
                            learn_fr: data.learn_fr,
                            learn_to: data.learn_to,
                            learn_hrs: data.learn_hrs,
                            learn_type: data.learn_type,
                            learn_con: data.learn_con,
                        },
                    ];
                }
            }
        })
        .catch((error) => {
            console.error("Error fetching Learning & Development details:", error);
        });
},

    fetchRecognitionDistinction(recog_count, empid) {
    const queryParam = recog_count ? `recog_count=${recog_count}` : `empid=${empid}`;
    axios
      .get(`/api/get-recogdist-data?${queryParam}`)
      .then((response) => {
        if (response.data) {
          // If the response is an array, populate the recognition list
          if (Array.isArray(response.data)) {
            this.recognitionList = response.data.map((recog) => ({
              recog_count: recog.recog_count,
              recog_name: recog.recog_name,
            }));
          } else {
            // Handle a single recognition response
            const data = response.data;
            this.recognitionList = [
              {
                recog_count: data.recog_count,
                recog_name: data.recog_name,
              },
            ];
          }
        }
      })
      .catch((error) => {
        console.error("Error fetching recognition and distinctions:", error);
        this.errorMessage = "Unable to fetch recognition and distinctions.";
      });
  },

    fetchSSSId(sss_count, empid) {
        const queryParam = sss_count ? `sss_count=${sss_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-sssid-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.sss_num = data.sss_num;
                }
            })
            .catch((error) => {
                console.error("Error fetching SSS ID:", error);
            });
    },

    fetchPagIbigId(pgbg_count, empid) {
        const queryParam = pgbg_count ? `pgbg_count=${pgbg_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-pagibigid-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.pgbg_id = data.pgbg_id;
                }
            })
            .catch((error) => {
                console.error("Error fetching Pag-Ibig ID:", error);
            });
    },

    fetchGSISId(gsis_count, empid) {
    const queryParam = gsis_count ? `gsis_count=${gsis_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-gsisid-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                this.profileData.pb_no = response.data.gsis_id; // Use gsis_id
            }
        })
        .catch((error) => {
            console.error("Error fetching GSIS ID:", error);
        });
},

    fetchPhilhealthId(phl_count, empid) {
    const queryParam = phl_count ? `phl_count=${phl_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-philhealthid-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                this.profileData.ph_lid = response.data.ph_lid; // Use ph_lid
            }
        })
        .catch((error) => {
            console.error("Error fetching Philhealth ID:", error);
        });
},

    fetchTINId(tin_count, empid) {
    const queryParam = tin_count ? `tin_count=${tin_count}` : `empid=${empid}`;
    axios
        .get(`/api/get-tinid-data?${queryParam}`)
        .then((response) => {
            if (response.data) {
                this.profileData.tin_id = response.data.tin_id; // Use ph_lid
            }
        })
        .catch((error) => {
            console.error("Error fetching TIN ID:", error);
        });
},


    //12/02
    //libraries
    fetchExtOptions() {
      axios
        .get('/api/ext-options')
        .then((response) => {
          this.extOptions = response.data.map((item) => ({
            value: item.lib1_count,
            text: item.lib1_suffix,
          }));
        })
        .catch((error) => {
          console.error('Error fetching name extensions:', error);
        });
    },

    fetchSexOptions() {
      axios
        .get('/api/sex-options')
        .then((response) => {
          this.sexOptions = response.data.map((item) => ({
            value: item.lib4_count,
            text: item.lib4_sex,
          }));
        })
        .catch((error) => {
          console.error('Error fetching sexes:', error);
        });
    },

    fetchCivilStatusOptions() {
      axios
        .get('/api/civilstatus-options')
        .then((response) => {
          this.civilStatusOptions = response.data.map((item) => ({
            value: item.lib3_count,
            text: item.lib3_civil_stat,
          }));
        })
        .catch((error) => {
          console.error('Error fetching civil statuses:', error);
        });
    },

    fetchBloodTypeOptions() {
      axios
        .get('/api/bloodtype-options')
        .then((response) => {
          this.bloodTypeOptions = response.data.map((item) => ({
            value: item.lib2_count,
            text: item.lib2_blood_type,
          }));
        })
        .catch((error) => {
          console.error('Error fetching blood types:', error);
        });
    },

    //fetching region not working
    fetchRegions(type = 'residential') {
    console.log(`Fetching regions for: ${type}`);
    axios
        .get('/api/regions')
        .then((response) => {
        console.log('Regions fetched:', response.data);
        if (Array.isArray(response.data)) {
            if (type === 'residential') {
            this.regions = response.data; // Update regions for residential address
            } else if (type === 'permanent') {
            this.permanentRegions = response.data; // Update regions for permanent address
            }
        } else {
            console.error('Unexpected response format for regions:', response.data);
        }
        })
        .catch((error) => {
        console.error(`Error fetching regions for ${type}:`, error);
        });
    },

    fetchProvinces(reg_psgc, type) {
    axios
        .get('/api/provinces', { params: { reg_psgc } })
        .then((response) => {
        if (type === 'residential') {
            this.provinces = response.data;
        } else if (type === 'permanent') {
            this.permanentProvinces = response.data;
            // Check if the current selected province exists in the options
            const currentProvince = this.permanentProvinces.find(
            (province) => province.prov_psgc === this.profileData.permanentProvince2
            );
            if (!currentProvince) {
            // Handle the case when the current province is not found (if needed)
            }
        }
        })
        .catch((error) => {
        console.error('Error fetching provinces:', error);
        });
    },

  fetchCities(provinceCode, type) {
    axios
      .get('/api/cities', { params: { prv_psgc: provinceCode } })
      .then((response) => {
        if (type === 'residential') {
          this.cities = response.data;
        } else if (type === 'permanent') {
          this.permanentCities = response.data;
        }
      })
      .catch((error) => {
        console.error('Error fetching cities:', error);
      });
  },

  fetchBarangays(cityCode, type) {
    axios
      .get('/api/barangays', { params: { citmun_psgc: cityCode } })
      .then((response) => {
        if (type === 'residential') {
          this.barangays = response.data;
        } else if (type === 'permanent') {
          this.permanentBarangays = response.data;
        }
      })
      .catch((error) => {
        console.error('Error fetching barangays:', error);
      });
  },

    showEditModal() {
      this.isEditModalVisible = true;
      this.currentPage = 1;
      //gibutang nko then ang region kay na fetch na
      this.fetchRegions();

    },
    hideEditModal() {
      this.isEditModalVisible = false;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    saveProfile() {
    this.isLoading = true;  // Show loading state
    axios
        .patch(`/employee/updateEditProfile/${this.profileData.empid}`, this.profileData)
        .then((response) => {
        this.isEditing = false;
        this.showUpdateDialog = false;
        this.showSuccessDialog = true;
        this.hideEditModal();  // Close the modal on successful save

        // Optionally, you can display the success message returned from the backend, if any
        console.log(response.data.message || 'Profile updated successfully');
        })
        .catch((error) => {
        this.isLoading = false;  // Hide loading state on error

        // Log the error and display a meaningful message
        console.error('Error updating profile:', error);

        // Show an error dialog or message
        this.showErrorDialog = true;
        this.errorMessage = error.response?.data?.message || 'An error occurred while updating the profile.';
        })
        .finally(() => {
        this.isLoading = false;  // Hide loading state after request is finished
        });
    },
  }
};
</script>


<style scoped>
  .search-bar {
    position: relative;
  }

  .text-red-600 {
    color: #e3342f;
  }

  .fixed {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(95, 93, 93, 0.7);
  }


  .modal {
    position: absolute;
    top: 20px;
    margin: 0 auto; /* Center the modal horizontally */
    width: 100%;
    max-width: 1500px;
    margin-left: 250px;
    border-radius: 0.5rem;
    background-color: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    overflow-y: auto; /* Allow vertical scrolling */
    max-height: 90vh; /* Ensure the modal doesn't exceed screen height */
}

  input {
    width: 100%; /* Full width of the container */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    text-align: left; /* Ensure text is left-aligned */
  }

  .addgrid {
    text-align: center;
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
</style>

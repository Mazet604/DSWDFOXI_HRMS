<template>
    <AdminLayout>
      <div class="relative z-10">
        <!-- Profile Search Section -->
        <div class="w-full p-8 bg-white rounded-lg shadow-lg">
          <h1 class="mb-6 text-2xl font-bold">Employee Profile</h1>

          <div class="relative mb-4 search-bar">
            <div class="flex items-center">
              <span class="p-2 bg-gray-200 rounded-l">11-</span>
              <input
                type="text"
                class="w-full p-2 border rounded-r"
                placeholder="Enter 4-digit Employee ID..."
                v-model="searchQuery"
                @input="validateInput"
                maxlength="4"
              />
            </div>
          </div>

          <button class="p-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="search(searchQuery)">
            SEARCH
          </button>

          <div v-if="errorMessage" class="mt-4 text-red-600">
            {{ errorMessage }}
          </div>

          <div v-if="profileData" class="mt-6">
            <h2 class="text-xl font-bold">Employee Details:</h2>
            <p><strong>ID:</strong> {{ profileData.empid }}</p>
            <p><strong>Name:</strong> {{ profileData.emp_fname }} {{ profileData.emp_lname }}</p>
            <p><strong>Position:</strong> {{ profileData.emp_position }} </p>

            <!-- Edit Button -->
            <button class="p-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700" @click="showEditModal">
              EDIT
            </button>
          </div>
        </div>
        <div v-if="isEditModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="modal">
            <h2 class="mb-4 text-xl font-bold">Edit Employee Details</h2>

            <!-- Page 1 -->
            <div class="grid grid-cols-2 gap-4">
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_lname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_fname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_mname" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Name Extension</label>
                <select class="w-full p-2 border rounded" v-model="profileData.emp_ext">
                <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">
                {{ ext.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Date of Birth</label>
                <input type="date" class="w-full p-2 border rounded" v-model="profileData.emp_dob" />
             </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Place of Birth</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_pob" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Sex</label>
                <select class="w-full p-2 border rounded" v-model="profileData.emp_sex">
                <option v-for="sex in sexOptions" :key="sex.value" :value="sex.value">
                {{ sex.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Civil Status</label>
                <select class="w-full p-2 border rounded" v-model="profileData.emp_civ_stat">
                <option v-for="status in civilStatusOptions" :key="status.value" :value="status.value">
                {{ status.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Height</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_height" />
              </div>
              <div v-if="currentPage === 1">
                <label class="block mb-1 text-sm font-medium text-gray-700">Weight</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp_weight" />
              </div>
              <!-- Page 2 -->
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Blood Type</label>
                <select class="w-full p-2 border rounded" v-model="profileData.emp_blood">
                <option v-for="type in bloodTypeOptions" :key="type.value" :value="type.value">
                {{ type.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">GSIS ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.pb_no" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">PAG-IBIG ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.pgbg_id" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">PhilHealth ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ph_lid" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">SSS ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.sss_num" />
              </div>
              <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">TIN ID</label>
                <input class="w-full p-2 border rounded" v-model="profileData.tin_id" />
              </div>
              <!-- <div v-if="currentPage === 2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Agency Employee NO.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.emp" />
              </div> -->
              <!-- Page 3 - Residential Address -->
            <div v-if="currentPage === 3">
                <h3 class="mb-4 text-lg font-semibold">RESIDENTIAL ADDRESS</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                        <select class="w-full p-2 border rounded"  v-model="profileData.residentialRegion">
                        <option v-for="region in regions" :key="region.reg_psgc" :value="region.reg_psgc">
                        {{ region.col_region }}
                        </option>
                    </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                        <select class="w-full p-2 border rounded" v-model="profileData.residentialProvince">
                        <option v-for="province in provinces" :key="province.prv_psgc" :value="province.prv_psgc">
                        {{ province.col_province }}
                        </option>
                    </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                        <select class="w-full p-2 border rounded" v-model="profileData.residentialCity">
                        <option v-for="city in cities" :key="city.citmun_psgc" :value="city.citmun_psgc">
                        {{ city.col_citymuni }}
                        </option>
                    </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                        <select class="w-full p-2 border rounded" v-model="profileData.residentialBarangay">
                        <option v-for="barangay in barangays" :key="barangay.brgy_psgc" :value="barangay.brgy_psgc">
                        {{ barangay.col_brgy }}
                        </option>
                    </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialZipcode" />
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialVillage" />
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                        <input class="w-full p-2 border rounded" v-model="profileData.residentialStreet" />
                </div>
            </div>
            </div>
            <!-- Page 4 - Permanent Address -->
            <div v-if="currentPage === 4">
            <h2 class="mb-4 text-lg font-semibold">PERMANENT ADDRESS</h2>
            <div class="gap-4 mb-6 ">
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Region</label>
                <select class="w-full p-2 border rounded" v-model="profileData.permanentRegion2">
                <option v-for="region in regions" :key="region.reg_psgc" :value="region.reg_psgc">
                {{ region.col_region }}
                </option>
                </select>
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Province</label>
                <select class="w-full p-2 border rounded" v-model="profileData.permanentProvince2">
                <option v-for="province in permanentProvinces" :key="province.prv_psgc" :value="province.prv_psgc">
                {{ province.col_province }}
                </option>
                </select>
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">City</label>
                <select class="w-full p-2 border rounded" v-model="profileData.permanentCity2">
                <option v-for="city in permanentCities" :key="city.citmun_psgc" :value="city.citmun_psgc">
                {{ city.col_citymuni }}
                </option>
                </select>
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Barangay</label>
                <select class="w-full p-2 border rounded" v-model="profileData.permanentBarangay2">
                <option v-for="barangay in permanentBarangays" :key="barangay.brgy_psgc" :value="barangay.brgy_psgc">
                {{ barangay.col_brgy }}
                </option>
                </select>
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Zip Code</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentZipcode2" />
                </div>
                <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">Village/Subdivision</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentVillage2" />
                </div>
                <div class="col-span-2">
                <label class="block mb-1 text-sm font-medium text-gray-700">Block/Street/Purok</label>
                <input class="w-full p-4 border border-gray-300 rounded-md" v-model="profileData.permanentStreet2" />
                </div>
            </div>
            </div>
            <!-- Page 5 - Background - Family -->
            <div v-if="currentPage === 5">
            <h2 class="mb-4 text-lg font-semibold">SPOUSE</h2>
            <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_lname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_fname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_mname" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Suffix</label>
                <select class="w-full p-2 border rounded" v-model="profileData.spouse_xname">
                <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">
                {{ ext.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Occupation</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_occup" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Employer's/Business Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_office" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Business Address</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_busadd" />
              </div>
              <div v-if="currentPage === 5">
                <label class="block mb-1 text-sm font-medium text-gray-700">Tel No.</label>
                <input class="w-full p-2 border rounded" v-model="profileData.spouse_tel" />
              </div>
            </div>
            <div v-if="currentPage === 6">
            <h2 class="mb-4 text-lg font-semibold">FATHER</h2>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.father_lname" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.father_fname" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.father_mname" />
              </div>
              <div v-if="currentPage === 6">
                <label class="block mb-1 text-sm font-medium text-gray-700">Suffix</label>
                <select class="w-full p-2 border rounded" v-model="profileData.father_xname">
                <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">
                {{ ext.text }}
                </option>
            </select>
              </div>
            </div>
            <div v-if="currentPage === 7">
              <h2 class="mb-4 text-lg font-semibold">MOTHER</h2>
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">Surname</label>
                <input class="w-full p-2 border rounded" v-model="profileData.mother_lname" />
              </div>
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">First Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.mother_fname" />
              </div>
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">Middle Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.mother_mname" />
              </div>
              <div v-if="currentPage === 7">
                <label class="block mb-1 text-sm font-medium text-gray-700">Maiden Name</label>
                <input class="w-full p-2 border rounded" v-model="profileData.maidenname" />
              </div>
            </div>
            <div v-if="currentPage === 8">
              <h2 class="mb-4 text-lg font-semibold">EDUCATION</h2>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">LEVEL OF EDUCATION</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_level" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">NAME OF SCHOOL</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_school" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">BASIC EDUCATION|DEGREE|COURSE</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_degree" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">DATE ENROLLED</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_from" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">HIGHEST LEVEL EARNED</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_hl_earned" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">YEAR GRADUATED</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_year_grad" />
              </div>
              <div v-if="currentPage === 8">
                <label class="block mb-1 text-sm font-medium text-gray-700">SCHOLARSHIPS & ACADEMIC EXCELLENCE</label>
                <input class="w-full p-2 border rounded" v-model="profileData.educ_academic_honor" />
              </div>
            </div>
            <div v-if="currentPage === 9">
              <h2 class="mb-4 text-lg font-semibold">OORGANIZATIONS</h2>
              <div v-if="currentPage === 9">
                <label class="block mb-1 text-sm font-medium text-gray-700">ORGANIZATION NAME</label>
                <input class="w-full p-2 border rounded" v-model="profileData.org_name" />
              </div>
            </div>
            <div v-if="currentPage === 10">
              <h2 class="mb-4 text-lg font-semibold">WORK EXPERIENCE</h2>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">WORK FROM</label>
                <input class="w-full p-2 border rounded" v-model="profileData.workfr" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">WORK TO</label>
                <input class="w-full p-2 border rounded" v-model="profileData.workto" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">POSITION</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_pos" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">DEPARTMENT|AGENCY|OFFICE|COMPANY</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_dept" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">MONTHLY SALARY</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_salary" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">SALARY GRADE</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_salarygrade" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">STATUS OF APPOINTMENT</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_stat" />
              </div>
              <div v-if="currentPage === 10">
                <label class="block mb-1 text-sm font-medium text-gray-700">GOV'T SERVICE</label>
                <input class="w-full p-2 border rounded" v-model="profileData.work_gov" />
              </div>
            </div>
            <div v-if="currentPage === 11">
              <h2 class="mb-4 text-lg font-semibold">SKILLS</h2>
              <div v-if="currentPage === 11">
                <label class="block mb-1 text-sm font-medium text-gray-700">SKILLS</label>
                <input class="w-full p-2 border rounded" v-model="profileData.skill" />
              </div>
            </div>
            <div v-if="currentPage === 12">
              <h2 class="mb-4 text-lg font-semibold">REFERENCES</h2>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">FIRST NAME</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ref_fname" />
              </div>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">MIDDLE NAME</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ref_mname" />
              </div>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">LAST NAME</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ref_lname" />
              </div>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">SUFFIX</label>
                <select class="w-full p-2 border rounded" v-model="profileData.ref_xname">
                <option v-for="ext in extOptions" :key="ext.value" :value="ext.value">
                {{ ext.text }}
                </option>
            </select>
              </div>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">BLOCK/STREET/PUROK</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ref_add" />
              </div>
              <div v-if="currentPage === 12">
                <label class="block mb-1 text-sm font-medium text-gray-700">CONTACT NUMBER</label>
                <input class="w-full p-2 border rounded" v-model="profileData.ref_cnum" />
              </div>
            </div>
            <div v-if="currentPage === 13">
              <h2 class="mb-4 text-lg font-semibold">CS ELIGIBILITY</h2>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER SPECIAL LAWS/CES/CSEE/BARANGAY ELIGIBILITY/DRIVERS LICENSE</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_service" />
              </div>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">RATING (IF APPLICABLE)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_rating" />
              </div>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">DATE OF EXAMINATION/CONFERMENT</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_doe" />
              </div>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">PLACE OF EXAMINATION/CONFERMENT</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_poe" />
              </div>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">LICENSE (IF APPLICABLE)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_license_no" />
              </div>
              <div v-if="currentPage === 13">
                <label class="block mb-1 text-sm font-medium text-gray-700">VALIDITY</label>
                <input class="w-full p-2 border rounded" v-model="profileData.eli_licen_valid" />
              </div>
            </div>
            <div v-if="currentPage === 14">
              <h2 class="mb-4 text-lg font-semibold">VOLUNTARY WORK</h2>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">NAME OF ORGANIZATION</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_name" />
              </div>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">ADDRESS OF ORGANIZATION</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_add" />
              </div>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">INCLUSIVE DATES FROM</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_fr" />
              </div>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">INCLUSIVE DATES TO</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_to" />
              </div>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">NUMBER OF HOURS</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_hrs" />
              </div>
              <div v-if="currentPage === 14">
                <label class="block mb-1 text-sm font-medium text-gray-700">POSITION / NATURE OF WORK</label>
                <input class="w-full p-2 border rounded" v-model="profileData.vol_pos" />
              </div>
            </div>
            <div v-if="currentPage === 15">
              <h2 class="mb-4 text-lg font-semibold">LEARNING & DEVELOPMENT</h2>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAM (WRITE IN FULL)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_title" />
              </div>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) FROM</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_fr" />
              </div>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">INCLUSIVE DATES (MM/DD/YYYY) TO</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_to" />
              </div>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">NUMBER OF HOURS</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_hrs" />
              </div>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">TYPE OF LD (MANAGERIAL/SUPERVISORY/TECHNICAL/ETC)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_type" />
              </div>
              <div v-if="currentPage === 15">
                <label class="block mb-1 text-sm font-medium text-gray-700">CONDUCTED/SPONSORED BY (WRITE IN FULL)</label>
                <input class="w-full p-2 border rounded" v-model="profileData.learn_con" />
              </div>
            </div>
            <div v-if="currentPage === 16">
              <h2 class="mb-4 text-lg font-semibold">RECOGNITION & DISTINCTIONS</h2>
              <div v-if="currentPage === 16">
                <label class="block mb-1 text-sm font-medium text-gray-700">RECOGNITION & DISTINCTIONS</label>
                <input class="w-full p-2 border rounded" v-model="profileData.recog_name" />
              </div>
            </div>
            </div>
            <!-- Pagination Buttons -->
            <div class="mt-6 text-right">
              <button v-if="currentPage > 1" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="prevPage">Previous</button>
              <button v-if="currentPage < totalPages" class="px-4 py-2 ml-4 text-white bg-blue-600 rounded hover:bg-blue-700" @click="nextPage">Next</button>
            </div>

            <!-- Modal Buttons -->
            <div class="mt-6 text-right">
              <button class="px-4 py-2 mr-4 text-white bg-red-600 rounded hover:bg-red-700" @click="hideEditModal">
                CANCEL
              </button>
              <button class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700" @click="saveProfile">
                SAVE
             </button>
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

export default {
  components: {
    AdminLayout,
    DashboardScripts,
    Dashboard,
    Background,
    OtherInfo
  },
  data() {
  return {
    searchQuery: '',
    errorMessage: '',
    profileData: null,
    residentialRegion: '',
    isEditModalVisible: false,
    currentPage: 1,
    totalPages: 20,
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
            .get(`/api/get-employee-address2?emp_count=${emp_count}`) // Correct endpoint
            .then((response) => {
                if (response.data) {
                    // Bind permanent address data to profileData object
                    this.profileData.permanentRegion2 = response.data.Region2;
                    this.profileData.permanentProvince2 = response.data.Province2;
                    this.profileData.permanentCity2 = response.data.City2;
                    this.profileData.permanentBarangay2 = response.data.Barangay2;
                    this.profileData.permanentZipcode2 = response.data.zipcode2;
                    this.profileData.permanentVillage2 = response.data.villsub2;
                    this.profileData.permanentStreet2 = response.data.block2;
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
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.educ_level = data.educ_level;
                    this.profileData.educ_school = data.educ_school;
                    this.profileData.educ_degree = data.educ_degree;
                    this.profileData.educ_from = data.educ_from;
                    this.profileData.educ_year_grad = data.educ_year_grad;
                    this.profileData.educ_academic_honor = data.educ_academic_honor;
                    this.profileData.educ_hl_earned = data.educ_hl_earned;
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
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.org_name = data.org_name;
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
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.workfr = data.workfr;
                    this.profileData.workto = data.workto;
                    this.profileData.work_pos = data.work_pos;
                    this.profileData.work_dept = data.work_dept;
                    this.profileData.work_salary = data.work_salary;
                    this.profileData.work_salarygrade = data.work_salarygrade;
                    this.profileData.work_stat = data.work_stat;
                    this.profileData.work_gov = data.work_gov;
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
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.skill = data.skill;
                }
            })
            .catch((error) => {
                console.error("Error fetching skills:", error);
            });
    },

    fetchReference(ref_count, empid) {
        const queryParam = ref_count ? `ref_count=${ref_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-reference-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.ref_fname = data.ref_fname;
                    this.profileData.ref_mname = data.ref_mname;
                    this.profileData.ref_lname = data.ref_lname;
                    this.profileData.ref_xname = data.ref_xname;
                    this.profileData.ref_add = data.ref_add;
                    this.profileData.ref_cnum = data.ref_cnum;
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
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.eli_service = data.eli_service;
                    this.profileData.eli_rating = data.eli_rating;
                    this.profileData.eli_doe = data.eli_doe;
                    this.profileData.eli_poe = data.eli_poe;
                    this.profileData.eli_license_no = data.eli_license_no;
                    this.profileData.eli_licen_valid = data.eli_licen_valid;
                }
            })
            .catch((error) => {
                console.error("Error fetching cs eligibility details:", error);
            });
    },

    fetchVoluntaryWork(vol_count, empid) {
        const queryParam = vol_count ? `vol_count=${vol_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-voluntarywork-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.vol_name = data.vol_name;
                    this.profileData.vol_add = data.vol_add;
                    this.profileData.vol_fr = data.vol_fr;
                    this.profileData.vol_to = data.vol_to;
                    this.profileData.vol_hrs = data.vol_hrs;
                    this.profileData.vol_pos = data.vol_pos;
                }
            })
            .catch((error) => {
                console.error("Error fetching voluntary work details:", error);
            });
    },

    fetchLearningDevelopment(learn_count, empid) {
        const queryParam = learn_count ? `learn_count=${learn_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-learndev-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.learn_title = data.learn_title;
                    this.profileData.learn_fr = data.learn_fr;
                    this.profileData.learn_to = data.learn_to;
                    this.profileData.learn_hrs = data.learn_hrs;
                    this.profileData.learn_type = data.learn_type;
                    this.profileData.learn_con = data.learn_con;
                }
            })
            .catch((error) => {
                console.error("Error fetching learning and development details:", error);
            });
    },

    fetchRecognitionDistinction(recog_count, empid) {
        const queryParam = recog_count ? `recog_count=${recog_count}` : `empid=${empid}`;
        axios
            .get(`/api/get-recogdist-data?${queryParam}`)
            .then((response) => {
                if (response.data) {
                    const data = Array.isArray(response.data) ? response.data[0] : response.data; // Handle both array and object response
                    this.profileData.recog_name = data.recog_name;
                }
            })
            .catch((error) => {
                console.error("Error fetching recognition and distinction name:", error);
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
    background-color: rgba(0, 0, 0, 0.7);
  }


  .modal {
    width: 95%;
    max-width: 810px;
    height: auto;
    padding: 2.3rem;
    background-color: white;
    border-radius: 0.5rem;
  }

  /* Keep buttons responsive */
  button {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 0.375rem;
  }

  /* Adjust input field size for larger modal */
  input {
    font-size: 1rem;
    padding: 0.8rem;
    width: 100%;
  }

  .grid-cols-2 input {
    padding: 0.9rem;
  }
</style>

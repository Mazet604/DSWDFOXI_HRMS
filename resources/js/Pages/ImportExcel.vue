<template>
    <AdminLayout>
      <!-- ADD EMPLOYEE Tab -->
      <h1 class="dashboard-title">Admin Dashboard - ADD EMPLOYEE</h1>

      <h2 class="form-heading">Create Employee Account</h2>
      <form @submit.prevent="createAccount" class="form">
        <div class="form-group">
          <label for="empid">Employee ID:</label>
          <input
            v-model="newAccount.empid"
            type="text"
            id="empid"
            placeholder="11-XXXX"
            required
          />
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input
              v-model="newAccount.position"
              type="text"
              id="position"
              placeholder="Enter Position"
              required
            />
          </div>
        <div class="form-group">
          <label for="empmail">Email:</label>
          <input
            v-model="newAccount.empmail"
            type="email"
            id="empmail"
            required
          />
        </div>
        <div class="form-group">
          <label for="empuser">Username:</label>
          <input
            v-model="newAccount.empuser"
            type="text"
            id="empuser"
            required
          />
        </div>
        <div class="form-group">
          <label for="emppass">Password:</label>
          <input
            v-model="newAccount.emppass"
            type="password"
            id="emppass"
            required
          />
        </div>
        <button type="submit" class="btn-submit">Create Account</button>
      </form>

      <!-- Section for uploading and reviewing Excel file -->
      <h2 class="form-heading">Upload Excel File</h2>
      <form @submit.prevent="uploadFile" class="form">
        <input
          type="file"
          @change="handleFile"
          accept=".xlsx,.xls"
          class="file-input"
        />
        <button type="submit" class="btn-submit">Upload and Review</button>
      </form>

      <!-- Section to display parsed Excel data -->
      <div v-if="excelData" class="preview-container">
        <h3 class="preview-heading">Preview Uploaded Data</h3>
        <pre class="preview-content">{{ excelData }}</pre>
        <button @click="confirmUpload" class="btn-confirm">Confirm and Save</button>
      </div>
    </AdminLayout>
  </template>


<script>
import { App } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import axios from 'axios';
import { nextTick } from 'vue';
import * as XLSX from 'xlsx';



export default {
  name: 'AdminDashboard',

  props: {
    successMessage: String, // Define a prop for the success message
  },

  components: {
    AdminLayout
  },

  data() {
    return {
      file: null,
      excelData: null, // For displaying parsed data
      newAccount: {
        empid: "",
        empmail: "",
        empuser: "",
        emppass: "",
        position: "",
      },
    };
  },


  methods: {
  formatEmployeeId() {
      if (!this.employeeId.startsWith('11-')) {
        this.employeeId = '11-' + this.employeeId.slice(3);
      }
      if (this.employeeId.length > 7) {
        this.employeeId = this.employeeId.slice(0, 7);
      }
    },

    handleFile(event) {
      this.file = event.target.files[0];
    },

    async createAccount() {
      try {
        const response = await axios.post("/create-account", this.newAccount);
        alert(response.data.message);
      } catch (error) {
        alert("Error creating account: " + error.response?.data?.message || error.message);
      }
    },

async uploadFile() {
  console.log("UploadFile method triggered.");
  if (!this.file) {
    alert("Please select a file!");
    return;
  }

  const formData = new FormData();
  formData.append("file", this.file);

  try {
    const response = await axios.post("/preview-excel", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    this.excelData = response.data; // Store the parsed data for review
    console.log("Excel Data:", this.excelData);
  } catch (error) {
    alert("Error uploading file: " + error.response?.data?.message || error.message);
  }
},

    async previewExcel(file) {
        const formData = new FormData();
        formData.append('file', file);

        try {
            const response = await axios.post('/preview-excel', formData);
            console.log('Preview Excel Response:', response.data);
            this.sheet1 = response.data.sheet1; // Save sheet1 data for the next step
        } catch (error) {
            console.error('Error previewing Excel:', error.response.data);
        }
    },
    async confirmUpload() {
        const data = { sheet1: this.sheet1 }; // Send the parsed sheet1 data

        try {
            const response = await axios.post('/confirm-upload', { data });
            console.log('Upload Confirm Response:', response.data);
        } catch (error) {
            console.error('Error uploading data:', error.response.data);
        }
    },




  }
}
</script>

<style scoped>
.dashboard-title {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.form-heading {
  color: #555;
  margin-bottom: 15px;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.file-input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-submit {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-submit:hover {
  background-color: #0056b3;
}

.preview-container {
  margin-top: 30px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #f9f9f9;
}

.preview-heading {
  color: #555;
  margin-bottom: 15px;
}

.preview-content {
  background-color: #eef;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  max-height: 200px;
  overflow-y: auto;
}

.btn-confirm {
  background-color: #ffc107;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

.btn-confirm:hover {
  background-color: #d39e00;
}
</style>


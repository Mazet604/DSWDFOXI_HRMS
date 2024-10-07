<template>
    <AppLayout>
      <div>
        <!-- Custom Tabs for Admin Dashboard -->
        <div class="flex justify-end -mb-px">
          <button @click="activeTab = 'overview'" :class="tabButtonClass('overview')">OVERVIEW</button>
          <button @click="activeTab = 'demographic'" :class="tabButtonClass('demographic')">DEMOGRAPHIC</button>
        </div>

        <!-- Overview Tab -->
        <div v-if="activeTab === 'overview'">
          <h1>Admin Dashboard - Overview</h1>
          <div class="dashboard-grid-overview">
            <!-- Left Column -->
            <div class="left-column">
              <!-- Total Employees Card -->
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Total number of Employees:</h5>
                  <h1 class="card-text">{{ totalEmployees }}</h1>
                </div>
              </div>

              <!-- Gender Distribution Card -->
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Gender Distribution</h5>
                  <canvas id="genderChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Right Column: Civil Status Distribution Card -->
            <div class="card civil-status-card">
              <div class="card-body">
                <h5 class="card-title">Civil Status Distribution</h5>
                <canvas id="civilStatusChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Demographic Tab -->
        <div v-show="activeTab === 'demographic'" class="flex flex-col items-center">
            <h1>Admin Dashboard - Demographic</h1>

            <!-- Centered Card with Buttons -->
            <div class="card centered-card">
              <div class="card-body">
                <div class="flex justify-between mb-4">
                  <!-- Buttons to switch between Barangay, City, Province, and Region charts -->
                  <button @click="activeDemographic = 'barangay'" :class="demographicButtonClass('barangay')">Barangay</button>
                  <button @click="activeDemographic = 'city'" :class="demographicButtonClass('city')">City</button>
                  <button @click="activeDemographic = 'province'" :class="demographicButtonClass('province')">Province</button>
                  <button @click="activeDemographic = 'region'" :class="demographicButtonClass('region')">Region</button>
                </div>

                <!-- Chart Display: All charts are rendered but hidden except the active one -->
                <canvas id="barangayChart" v-show="activeDemographic === 'barangay'"></canvas>
                <canvas id="cityChart" v-show="activeDemographic === 'city'"></canvas>
                <canvas id="provinceChart" v-show="activeDemographic === 'province'"></canvas>
                <canvas id="regionChart" v-show="activeDemographic === 'region'"></canvas>
              </div>
            </div>
        </div>
      </div>
    </AppLayout>
</template>

<script>
import { App } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';
import { nextTick } from 'vue';

Chart.register(...registerables);

export default {
  name: 'AdminDashboard',

  components: {
    AppLayout
  },

  data() {
    return {
      totalEmployees: 0,
      maleEmployees: 0,
      femaleEmployees: 0,
      civilStatusData: {},
      activeTab: 'overview', // Default to the overview tab
      activeDemographic: 'barangay', // Default to Barangay
      employeeAddressData: [],
      chartInstances: {} // To store references to the chart instances
    };
  },

  mounted() {
    this.fetchTotalEmployees();
    this.fetchGenderDistribution();
    this.fetchCivilStatusDistribution();
    this.fetchEmployeeAddressData(); // Initial fetch without filters
  },

  methods: {
    fetchTotalEmployees() {
      axios.get('/total-employees')
        .then(response => {
          this.totalEmployees = response.data.totalEmployees;
        })
        .catch(error => {
          console.error('Error fetching total employees:', error);
        });
    },

    fetchGenderDistribution() {
      axios.get('/gender-distribution')
        .then(response => {
          this.maleEmployees = response.data.male;
          this.femaleEmployees = response.data.female;
          this.renderGenderChart();
        })
        .catch(error => {
          console.error('Error fetching gender distribution:', error);
        });
    },

    fetchCivilStatusDistribution() {
      axios.get('/civil-status-distribution')
        .then(response => {
          this.civilStatusData = response.data;
          this.renderCivilStatusChart();
        })
        .catch(error => {
          console.error('Error fetching civil status distribution:', error);
        });
    },

    fetchEmployeeAddressData() {
      axios.get('/employee-address-data')
        .then(response => {
          console.log('Fetched Employee Address Data:', response.data); // Log the response to ensure data is being fetched
          this.employeeAddressData = response.data;
          this.renderAllAddressCharts(); // Render all the charts at once
        })
        .catch(error => {
          console.error('Error fetching employee address data:', error);
        });
    },

    renderAllAddressCharts() {
      // Destroy any previously rendered charts to avoid duplicates
      if (this.chartInstances['barangay']) {
        this.chartInstances['barangay'].destroy();
      }
      if (this.chartInstances['city']) {
        this.chartInstances['city'].destroy();
      }
      if (this.chartInstances['province']) {
        this.chartInstances['province'].destroy();
      }
      if (this.chartInstances['region']) {
        this.chartInstances['region'].destroy();
      }

      // Helper function to render each chart
      const renderChart = (canvasId, labelField, nameField) => {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
          console.error(`Canvas element for ${canvasId} not found.`);
          return;
        }

        const ctx = canvas.getContext('2d');
        if (!ctx) {
          console.error(`Unable to get context for ${canvasId}.`);
          return;
        }

        const labels = this.employeeAddressData.map(emp => emp[nameField]); // Fetch human-readable name field
        const data = this.employeeAddressData.map(emp => emp.count);

        this.chartInstances[canvasId] = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels, // Display names instead of PSGC codes
            datasets: [{
              label: 'Number of Employees',
              data: data,
              backgroundColor: '#36A2EB',
              borderColor: '#36A2EB',
              borderWidth: 1
            }]
          },
          options: {
            indexAxis: 'y',
            scales: {
              x: {
                beginAtZero: true,
                    ticks: {
                display: false // Hide the numbers on the x-axis
                }
              }
            }
          }
        });
      };

      // Render all the charts for barangay, city, province, and region
      nextTick(() => {
        renderChart('barangayChart', 'emp_brgy', 'barangay_name'); // Use 'barangay_name' for labels
        renderChart('cityChart', 'emp_city', 'city_name'); // Use 'city_name' for labels
        renderChart('provinceChart', 'emp_prov', 'province_name'); // Use 'province_name' for labels
        renderChart('regionChart', 'emp_region', 'region_name'); // Use 'region_name' for labels
      });
    },

    renderGenderChart() {
      nextTick(() => {
        const canvasId = 'genderChart';
        const ctx = document.getElementById(canvasId).getContext('2d');

        // Destroy the previous gender chart if it exists
        if (this.chartInstances[canvasId]) {
          this.chartInstances[canvasId].destroy();
        }

        this.chartInstances[canvasId] = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ['Male', 'Female'],
            datasets: [{
              data: [this.maleEmployees, this.femaleEmployees],
              backgroundColor: ['#36A2EB', '#FF6384']
            }]
          }
        });
      });
    },

    renderCivilStatusChart() {
      nextTick(() => {
        const canvasId = 'civilStatusChart';
        const ctx = document.getElementById(canvasId).getContext('2d');

        // Destroy the previous civil status chart if it exists
        if (this.chartInstances[canvasId]) {
          this.chartInstances[canvasId].destroy();
        }

        const civilStatusColors = {
          'Single': '#36A2EB',
          'Married': '#FF6384',
          'Separated': '#4CAF50',
          'Widowed': '#000000',
          'Divorced': '#A9A9A9'
        };

        const backgroundColors = Object.keys(this.civilStatusData).map(status => civilStatusColors[status] || '#CCCCCC');

        this.chartInstances[canvasId] = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: Object.keys(this.civilStatusData),
            datasets: [{
              label: 'Number of Employees',
              data: Object.values(this.civilStatusData),
              backgroundColor: backgroundColors,
              borderColor: backgroundColors,
              borderWidth: 1
            }]
          },
          options: {
            plugins: {
              legend: {
                display: true,
                labels: {
                  generateLabels: function(chart) {
                    return Object.keys(civilStatusColors).map(function(status) {
                      return {
                        text: status,
                        fillStyle: civilStatusColors[status]
                      };
                    });
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  display: false
                }
              }
            }
          }
        });
      });
    },

    // Button class handler for tabs
    tabButtonClass(tabName) {
      return {
        'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
        'bg-blue-900 text-white': this.activeTab === tabName,
        'bg-gray-300 text-gray-700': this.activeTab !== tabName,
      };
    },

    // Button class handler for demographic buttons
    demographicButtonClass(demographic) {
      return {
        'px-4 py-2 border': true,
        'bg-blue-900 text-white': this.activeDemographic === demographic,
        'bg-gray-300 text-gray-700': this.activeDemographic !== demographic,
      };
    }
  },

  computed: {
    activeDemographicChart() {
      return `${this.activeDemographic}Chart`;
    }
  },

  watch: {
    // Watch for changes in activeTab to re-render the charts
    activeTab(newTab) {
      if (newTab === 'overview') {
        this.renderGenderChart();
        this.renderCivilStatusChart();
      } else if (newTab === 'demographic') {
        nextTick(() => {
          this.renderAllAddressCharts();
        });
      }
    }
  }
}
</script>

<style scoped>
/* Overview panel styling */
.dashboard-grid-overview {
  display: grid;
  grid-template-columns: 1fr 2fr; /* Left column smaller than right */
  gap: 20px; /* Space between the columns */
}

.left-column {
  display: flex;
  flex-direction: column;
}

.card {
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.card-body {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-title {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.card-text {
  font-size: 40px;
}

/* Ensure the civil status chart occupies the height of the two cards combined */
.civil-status-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%; /* Full height of the parent container */
}

/* Centered card for demographic section */
.centered-card {
  margin-top: 40px;
  width: 60%;
  padding: 20px;
  text-align: center;
  border: 2px solid #000;
  border-radius: 12px;
}

/* Buttons for demographic selection */
button {
  border-bottom: 2px solid transparent;
  margin-right: 4px;
}

button:hover {
  cursor: pointer;
}

button.bg-blue-900 {
  border-color: yellow;
}
</style>

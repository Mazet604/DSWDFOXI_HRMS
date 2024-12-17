<template>
    <AdminLayout>
        <div>
            <h1 class="pb-2 mb-4 text-3xl font-bold text-blue-800 border-b border-yellow-200">QUICK ANALYTICS</h1>

            <!-- Overview Section -->
            <div class="grid grid-cols-3 gap-8 mb-12">
                <!-- Left Column -->
                <div class="flex flex-col col-span-1">
                    <!-- Total Employees Card -->
                    <div class="p-6 mb-6 text-center bg-white border-2 rounded-lg shadow">
                        <h5 class="mb-4 text-lg font-semibold">Total number of Employees:</h5>
                        <h1 class="text-6xl font-bold text-blue-600">{{ totalEmployees }}</h1>
                    </div>

                    <!-- Gender Distribution Card -->
                    <div class="p-6 bg-white border-2 rounded-lg shadow">
                        <h5 class="mb-4 text-lg font-semibold">Gender Distribution</h5>
                        <canvas id="genderChart" class="w-full h-80"></canvas>
                    </div>
                </div>

                <!-- Right Column: Civil Status Distribution Card -->
                <div class="col-span-2 p-12 bg-white border-2 rounded-lg shadow"  style="height: 733px;">
                    <h5 class="mb-4 text-lg font-semibold">Civil Status Distribution</h5>
                    <canvas id="civilStatusChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <div>

                <div class="p-12 bg-white border-2 rounded-lg shadow">
                    <h2 class="mb-6 text-xl font-bold text-center">DEMOGRAPHICS</h2>

                    <div class="flex justify-center mb-6">
                    <!-- Buttons to switch between Barangay, City, Province, and Region charts -->
                    <button
                        @click="fetchEmployeeAddressData('barangay')"
                        :class="demographicButtonClass('barangay')"
                    >
                        Barangay
                    </button>
                    <button
                        @click="fetchEmployeeAddressData('city')"
                        :class="demographicButtonClass('city')"
                    >
                        City
                    </button>
                    <button
                        @click="fetchEmployeeAddressData('province')"
                        :class="demographicButtonClass('province')"
                    >
                        Province
                    </button>
                    <button
                        @click="fetchEmployeeAddressData('region')"
                        :class="demographicButtonClass('region')"
                    >
                        Region
                    </button>
                </div>
                    <!-- Single Canvas for Demographic Chart -->
                    <canvas id="demographicChart" class="w-full h-96"></canvas>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
import { App } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';
import { nextTick } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

Chart.register(...registerables);

export default {
    name: 'AdminDashboard',

    components: {
        AdminLayout
    },

    data() {
        return {
            activeTab: 'overview', // Default to the overview tab
            activeDemographic: 'barangay', // Default to Barangay
            totalEmployees: 0,
            maleEmployees: 0,
            femaleEmployees: 0,
            prefernottosay: 0,
            civilStatusData: {},
            employeeAddressData: [],
            chartInstances: {}, // Store chart instances for each chart
        };
    },

    mounted() {
        this.fetchTotalEmployees();
        this.fetchGenderDistribution();
        this.fetchCivilStatusDistribution();
        this.fetchEmployeeAddressData(this.activeDemographic); // Initial fetch for demographic data
    },

    methods: {
        tabButtonClass(tabName) {
            return {
                'px-6 py-2 rounded-t-lg font-semibold border-t border-l border-r border-gray-200': true,
                'bg-blue-900 text-white': this.activeTab === tabName,
                'bg-gray-300 text-gray-700': this.activeTab !== tabName,
            };
        },

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
                    this.prefernottosay = response.data.prefer;
                    nextTick(() => this.renderGenderChart());
                })
                .catch(error => {
                    console.error('Error fetching gender distribution:', error);
                });
        },

        fetchCivilStatusDistribution() {
            axios.get('/civil-status-distribution')
                .then(response => {
                    this.civilStatusData = response.data;
                    nextTick(() => this.renderCivilStatusChart());
                })
                .catch(error => {
                    console.error('Error fetching civil status distribution:', error);
                });
        },

        renderGenderChart() {
            const canvas = document.getElementById('genderChart');
            if (!canvas) {
                console.error("Canvas element for genderChart not found.");
                return;
            }

            const ctx = canvas.getContext('2d');
            this.chartInstances.gender = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female', 'Prefer not to say'],
                    datasets: [{
                        data: [this.maleEmployees, this.femaleEmployees, this.prefernottosay],
                        backgroundColor: ['#203c8c', '#a83464', '#AAAAAA'],
                    }]
                },
            });
        },

        renderCivilStatusChart() {
            const canvasId = 'civilStatusChart';
            const ctx = document.getElementById(canvasId).getContext('2d');

            if (this.chartInstances[canvasId]) {
                this.chartInstances[canvasId].destroy();
            }

            const civilStatusColors = {
                'Single': '#203c8c',        
                'Married': '#a83464',       
                'Separated': '#08046c',     
                'Widowed': '#48444c',       
                'Divorced': '#282424',      
                'Unknown Status': '#A9A9A9' 
            };

            const backgroundColors = Object.keys(this.civilStatusData).map(status => civilStatusColors[status] || '#CCCCCC');

            this.chartInstances[canvasId] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(this.civilStatusData), // Data-driven labels
                    datasets: [{
                        label: 'Number of Employees',
                        data: Object.values(this.civilStatusData),
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allow canvas to expand based on the container
                    animation: false,
                    scales: {
                        y: {
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                callback: function(value) { return Number.isInteger(value) ? value : null; }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                generateLabels: function(chart) {
                                    // Use civilStatusColors to generate all labels
                                    return Object.keys(civilStatusColors).map(function(label) {
                                        return {
                                            text: label,  // Show the label for each civil status
                                            fillStyle: civilStatusColors[label],  // Apply corresponding color
                                        };
                                    });
                                }
                            }
                        }
                    }
                }
            });
        },

        fetchEmployeeAddressData(demographic) {
            this.activeDemographic = demographic;
            axios.get('/employee-address-data', { params: { demographic } })
                .then(response => {
                    this.employeeAddressData = response.data;
                    nextTick(() => this.renderDemographicChart());
                })
                .catch(error => {
                    console.error('Error fetching employee address data:', error);
                });
        },

        renderDemographicChart() {
            if (this.chartInstances.demographic) {
                this.chartInstances.demographic.destroy();
            }

            const canvas = document.getElementById('demographicChart');
            if (!canvas) {
                console.error("Canvas element for demographicChart not found.");
                return;
            }

            const ctx = canvas.getContext('2d');
            const labels = this.employeeAddressData.map(
                (emp) => emp[`${this.activeDemographic}_name`]
            );
            const data = this.employeeAddressData.map((emp) => emp.count);

            const backgroundColors = data.map((_, index) => index % 2 === 0 ? '#082c94' : '#203c8c');

            const combined = labels.map((label, index) => ({ label, data: data[index] }));
            combined.sort((a, b) => a.data - b.data);

            const sortedLabels = combined.map(item => item.label);
            const sortedData = combined.map(item => item.data);

            this.chartInstances.demographic = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                        label: 'Number of Employees',
                        data: sortedData,
                        backgroundColor: backgroundColors,
                        borderWidth: 1,
                    }],
                },
                options: {
                    indexAxis: 'x',
                    animation: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { display: true },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) { return Number.isInteger(value) ? value : null; }
                            }
                        }
                    },
                },
            });
        },

        demographicButtonClass(demographic) {
            return {
                'px-4 py-2 border': true,
                'bg-blue-900 text-white': this.activeDemographic === demographic,
                'bg-gray-300 text-gray-700': this.activeDemographic !== demographic,
            };
        },
    },

    watch: {
        activeTab(newTab) {
            if (newTab === 'overview') {
                nextTick(() => {
                    this.renderGenderChart();
                    this.renderCivilStatusChart();
                });
            } else if (newTab === 'demographic') {
                nextTick(() => this.renderDemographicChart());
            }
        },
    },
};
</script>

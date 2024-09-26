<template>
  <AppLayout>
    <div>
      <h1>Admin Dashboard</h1>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Total number of Employees:</h5>
          <h1 class="card-text">{{ totalEmployees }}</h1>
        </div>
      </div>

      <!-- New card for gender distribution -->
      <!-- <div class="card">
        <div class="card-body">
          <h5 class="card-title">Gender Distribution</h5>
          <canvas id="genderChart"></canvas>
        </div>
      </div> -->
    </div>
  </AppLayout>
</template>

<script>
import { App } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

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
      femaleEmployees: 0
    };
  },

  mounted() {
    this.fetchTotalEmployees();
    this.fetchGenderDistribution();
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
    renderGenderChart() {
      const ctx = document.getElementById('genderChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['Male', 'Female'],
          datasets: [{
            data: [this.maleEmployees, this.femaleEmployees],
            backgroundColor: ['#36A2EB', '#FF6384']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
  }
};
</script>

<style scoped>
.card {
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  width: 100%;
  max-width: 400px;
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

</style>
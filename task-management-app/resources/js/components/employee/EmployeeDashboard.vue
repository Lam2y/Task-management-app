<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const total_score = ref(0);
const total_tasks = ref(0);
const tasks = ref([]);
const taskStatus = ref([]);

const getTaskStatus = () => {
  return axios.get('/api/task-status')
    .then(response => {
      taskStatus.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching task status:', error);
    });
};

const getTasks = () => {
  return axios.get('/api/tasks')
    .then(response => {
      const taskAssignments = response.data.taskAssignments.data;
      const tasksData = response.data.tasks.data;
      tasks.value = [...taskAssignments, ...tasksData];
      total_tasks.value = tasks.value.length;
      for (let i = 0; i < tasks.value.length; i++) {
        if (tasks.value[i].Status === 'Completed') {
          console.log(tasks.value[i].Priority);
          if (tasks.value[i].Priority === 'High') {
            total_score.value += 3;
          } else if (tasks.value[i].Priority === 'Medium') {
            total_score.value += 2;
          } else {
            total_score.value += 1;
          }
        }
      }
    })
    .catch(error => {
      console.error('Error fetching tasks:', error);
    });
};

const getStatusClass = (status) => {
  switch (status) {
    case 'Completed':
      return 'badge-success';
    case 'In progress':
      return 'badge-warning';
    case 'Late':
      return 'badge-danger';
    case 'Assigned':
      return 'badge-primary';
    case 'Cancelled':
      return 'badge-secondary';
    default:
      return '';
  }
};

const renderChart = () => {
  const statusCounts = tasks.value.reduce((acc, task) => {
    acc[task.Status] = (acc[task.Status] || 0) + 1;
    return acc;
  }, {});

  const ctx = document.getElementById('task-status-chart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: Object.keys(statusCounts),
      datasets: [{
        label: 'Task Status',
        data: Object.values(statusCounts),
        backgroundColor: [
          'rgba(75, 192, 192, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
        ],
        borderColor: [
          'rgba(75, 192, 192, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(153, 102, 255, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
};

onMounted(() => {
  getTaskStatus();
  getTasks().then(renderChart);
});
</script>
<style>
.custom-height {
  height: 50vh; /* or any other height you want */
}
</style>

<template>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6 col-6">
                    <div class="small-box bg-info">
                      <div class="inner text-center">
                        <h1>Total Tasks</h1>
                        <h3>{{ total_tasks }}</h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-6">
                    <div class="small-box bg-success">
                      <div class="inner text-center">
                        <h1>Total Score</h1>
                        <h3>{{ total_score }}</h3>
                      </div>
                    </div>
                  </div>
                </div>
  
                <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h2 class="card-title">
                        Task Status Accumulation 
                      </h2>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="chart">
                            <canvas id="task-status-chart" style="height: 300px; width:100%"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const total_score = ref(0);
const total_tasks = ref(0);
const tasks = ref([]);
const taskStatus = ref([]);
const userTasks = ref([]);
const userAssignTasks = ref([]);
let best_emp = ref("");
const final_ranking = ref([]);

const getTaskStatus = () => {
  return axios.get('/api/task-status')
    .then(response => {
      taskStatus.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching task status:', error);
    });
};

const groupTasks = () => {
  axios.get('/api/usertasks')
    .then(response => {
      const tasks = response.data.tasks;
      const taskAssignments = response.data.taskAssignments;
      console.log('Tasks:', tasks);
      console.log('Task Assignments:', taskAssignments);

      // Create a map to hold the count and score of tasks for each employee
      const employeeScores = new Map();

      // Helper function to add tasks to the map
      const addTasksToMap = (array, isAssignment = false) => {
        array.forEach(item => {
          const employee = isAssignment ? item.Assigned_To : item.Assigned_By;
          const count = isAssignment ? item.count : 1;
          let score = 0;

          // Log the status of each item
          console.log(`Item Status: ${item.Status}, Priority: ${item.Priority}, Count: ${count}`);

          // Check if the item is completed (update this if there's a different field indicating completion)
          const isCompleted = item.Status === 'Completed'; // Change this line if the completion status is determined differently

          if (isCompleted) {
            if (!isAssignment) {
              if (item.Priority === 'High') {
                score = 3;
              } else if (item.Priority === 'Medium') {
                score = 2;
              } else {
                score = 1;
              }
            } else {
              if (item.Priority === 'High') {
                score = 3 * count;
              } else if (item.Priority === 'Medium') {
                score = 2 * count;
              } else {
                score = 1 * count;
              }
            }
          } else {
            console.log(`Item not completed: ${JSON.stringify(item)}`);
          }

          if (employeeScores.has(employee)) {
            const current = employeeScores.get(employee);
            employeeScores.set(employee, {
              count: current.count + count,
              score: current.score + score
            });
          } else {
            employeeScores.set(employee, { count, score });
          }
        });
      };

      // Add tasks and task assignments to the map
      addTasksToMap(tasks);
      addTasksToMap(taskAssignments, true);

      // Convert map to an array for logging or other uses
      const resultArray = Array.from(employeeScores, ([employee, data]) => ({ employee, ...data }));

      // Sort the result array in descending order by score
      const final_ranking = resultArray.sort((a, b) => b.score - a.score);

      console.log('Final Ranking:', final_ranking);
      best_emp.value = final_ranking[0].employee;
    })
    .catch(error => {
      console.error('Error fetching user tasks:', error);
    });
};





const getTasks = () => {
  return axios.get('/api/admintasks')
    .then(response => {
      const taskAssignments = response.data.taskAssignments.data;
      tasks.value = [...taskAssignments];
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
  groupTasks();
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
                        <h1>Total Tasks Assigned</h1>
                        <h3>{{ total_tasks }}</h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-6">
                    <div class="small-box bg-success">
                      <div class="inner text-center">
                        <h1>Best Employee</h1>
                        <h3>{{ best_emp }}</h3>
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
  
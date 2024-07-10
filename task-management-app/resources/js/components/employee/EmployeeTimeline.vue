<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DatePicker from 'vue3-datepicker';


const tasks = ref([]);
const taskStatus = ref([]);
const selectedDate = ref(null);

const getTaskStatus = () => {
  axios.get('/api/task-status')
    .then(response => {
      taskStatus.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching task status:', error);
    });
};

const getTasks = () => {
  axios.get('/api/tasks')
    .then(response => {
      const taskAssignments = response.data.taskAssignments.data;
      const tasksData = response.data.tasks.data;
      tasks.value = [...taskAssignments, ...tasksData];

      // Sort tasks by Due_Date in ascending order
      tasks.value.sort((a, b) => new Date(a.Due_Date) - new Date(b.Due_Date));

      console.log(tasks.value);
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

// Filter tasks by selected date
const filteredTasks = computed(() => {
  if (!selectedDate.value) {
    return tasks.value;
  }
  return tasks.value.filter(task => {
    const taskDate = new Date(task.Due_Date).toDateString();
    const selected = new Date(selectedDate.value).toDateString();
    return taskDate === selected;
  });
});

onMounted(() => {
  getTaskStatus();
  getTasks();
});
</script>

<template>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Task Timeline</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Timeline</li>
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
                <div class="d-flex justify-content-between mb-2">
                   <h5>Select date to filter:</h5>
                  <DatePicker v-model="selectedDate" input-class="form-control" placeholder="Select Date" type="date" style="margin-right: 120px;"/>
            </div>
            <div class="timeline">
              <div v-for="(task, index) in filteredTasks" :key="index" class="timeline-item mb-3">
                <div class="timeline-marker"></div>
                <div class="card card-outline timeline-content" :class="['p-3', 'shadow', getStatusClass(task.Status)]">
                  <div class="card-header">
                    <h5 class="card-title">{{ task.Task }}</h5>
                  </div>
                  <div class="card-body">
                    <p class="card-text"><strong>Due Date:</strong> {{ task.Due_Date }}</p>
                    <p class="card-text"><strong>Priority:</strong> {{ task.Priority }}</p>
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
  
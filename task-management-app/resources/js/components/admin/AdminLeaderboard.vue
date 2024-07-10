<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const final_ranking = ref([]);

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
      final_ranking.value = resultArray.sort((a, b) => b.score - a.score);

      console.log('Final Ranking:', final_ranking.value);
 
    })
    .catch(error => {
      console.error('Error fetching user tasks:', error);
    });
};

onMounted(() => {
  groupTasks();
});
</script>

<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Leaderboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Leaderboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Score</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in final_ranking" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.employee }}</td>
                    <td>{{ item.score }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

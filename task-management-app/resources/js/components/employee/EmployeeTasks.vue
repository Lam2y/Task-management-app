<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Form, Field } from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../toastr.js';

const toastr=useToastr();
const tasks = ref([]);
const taskStatus = ref([]);
const editing = ref(false);
const searchQuery=ref(null);
const taskIdBeingDeleted=ref(null);

const search=()=>{
    axios.get('/api/tasks/search',{
        params:{
            query:searchQuery.value
        }
    })
    .then(response=>{
        tasks.value=response.data;
    })
    .catch(error=>{
        console.error('Error searching tasks:', error);
    })

}

const confirmTaskDeletion =(item)=>{
    console.log(item);
    taskIdBeingDeleted.value=item.id;
    $('#deleteTaskModal').modal('show');
}
const handleSubmit=()=>{
    if (editing.value) {
        updateTask(formValues.value);
      } else {
        createTask(formValues.value);
      }
}

const formValues = ref({
  Task: '',
  Description: '',
  Date_Given: '',
  Due_Date: '',
  Priority: '',
  Status: '',
});

const form = ref({
  Task: '',
  Description: '',
  Date_Given: '',
  Due_Date: '',
  Priority: '',
  Status: '',
});

const deleteTask=()=>{
    console.log(taskIdBeingDeleted.value);
    axios.delete(`/api/tasks/${taskIdBeingDeleted.value}`)
    .then(() => {
        $('#deleteTaskModal').modal('hide');
        toastr.success('Task deleted successfully');
        getTasks();
        getTaskStatus();
    })
    .catch(error => {
      console.error('Error deleting task:', error);
    });

}
const schema = yup.object({
  Task: yup.string().required('Task is required'),
  Description: yup.string().required('Description is required'),
  Date_Given: yup.date().required('Date given is required'),
  Due_Date: yup.date().required('Due date is required'),
  Priority: yup.string().required('Priority is required'),
  Status: yup.string().required('Status is required'),
});

const updateTask=(values)=>{
    console.log(values);
    axios.put('/api/tasks/'+formValues.value.id, values)
    .then((response) => {
        const taskIndex = tasks.value.findIndex(task => task.id === response.data.id);
        tasks.value[taskIndex] = response.data;
        $('#createTaskModal').modal('hide');
        getTasks();
        getTaskStatus();
        toastr.success('Task updated successfully');
    })
    .catch(error => {
      console.error('Error updating task:', error);
    });
}

const createTask = (value) => {
  console.log(value);
  axios.post('/api/tasks', formValues.value)
   .then(response => {
    formValues.value = {
       Task: '',
       Date_Given: '',
     Due_Date: '',
       Priority: '',
      Status: '',
     };
     getTasks();
     getTaskStatus();
     $('#createTaskModal').modal('hide');
   })
   .catch(error => {
     console.error('Error creating task:', error);
   });
};

const getTaskStatus = () => {
  axios.get('/api/task-status')
    .then(response => {
      taskStatus.value = response.data;
      console.log(taskStatus.value);
    })
    .catch(error => {
      console.error('Error fetching task status:', error);
    });
};

const editTask = (task) => {
    console.log(task);
    editing.value = true;
    
    formValues.value = { ...task }; // Use formValues when editing
    $('#createTaskModal').modal('show');
  };

const addTask = () => {
  editing.value = false;
  $('#createTaskModal').modal('show');  // Show modal for adding new task
};


const getTasks = (status) => {
  axios.get('/api/tasks')
    .then(response => {
      const taskAssignments = response.data.taskAssignments.data;
      const tasksData = response.data.tasks.data;
      tasks.value = [...taskAssignments, ...tasksData];
      if (status) {
        tasks.value = tasks.value.filter(task => task.Status === status);
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
          <h1 class="m-0">My Tasks</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">My Tasks</li>
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
            <div class="d-flex">
              <button class="mb-2 btn btn-primary" @click="addTask()">
                <i class="fa fa-plus-circle mr-1"></i> Add New Tasks
              </button>
              <div class="ml-5">
                  <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..."/>
              </div>
              <button @click.prevent="search" class="ml-2 btn btn-primary mb-2">
                Search
              </button>
            </div>
            <div class="btn-group">
              <button type="button" @click="getTasks('')" class="btn btn-secondary">
                <span class="mr-1">{{ taskStatus[5] ? taskStatus[5].name : '' }}</span>
                <span class="badge badge-pill badge-info">{{ taskStatus[5] ? taskStatus[5].count : '' }}</span>
              </button>

              <button type="button" @click="getTasks('Assigned')" class="btn btn-default">
                <span class="mr-1">{{ taskStatus[2] ? taskStatus[2].name : '' }}</span>
                <span class="badge badge-pill badge-primary">{{ taskStatus[2] ? taskStatus[2].count : '' }}</span>
              </button>

              <button type="button" @click="getTasks('Completed')" class="btn btn-default">
                <span class="mr-1">{{ taskStatus[0] ? taskStatus[0].name : '' }}</span>
                <span class="badge badge-pill badge-success">{{ taskStatus[0] ? taskStatus[0].count : '' }}</span>
              </button>

              <button type="button" @click="getTasks('Late')" class="btn btn-default">
                <span class="mr-1">{{ taskStatus[3] ? taskStatus[3].name : '' }}</span>
                <span class="badge badge-pill badge-danger">{{ taskStatus[3] ? taskStatus[3].count : '' }}</span>
              </button>

              <button type="button" @click="getTasks('In progress')" class="btn btn-default">
                <span class="mr-1">{{ taskStatus[1] ? taskStatus[1].name : '' }}</span>
                <span class="badge badge-pill badge-warning text-dark">{{ taskStatus[1] ? taskStatus[1].count : '' }}</span>
              </button>

              <button type="button" @click="getTasks('Cancelled')" class="btn btn-default">
                <span class="mr-1">{{ taskStatus[4] ? taskStatus[4].name : '' }}</span>
                <span class="badge badge-pill badge-secondary">{{ taskStatus[4] ? taskStatus[4].count : '' }}</span>
              </button>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Task</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date given</th>
                    <th scope="col">Due date</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in tasks" :key="item.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ item.Task }}</td>
                    <td>{{ item.Description }}</td>
                    <td>{{ item.Date_Given }}</td>
                    <td>{{ item.Due_Date }}</td>
                    <td>{{ item.Priority }}</td>
                    <td>
                      <span class="badge" :class="getStatusClass(item.Status)">
                        {{ item.Status }}
                      </span>
                    </td>
                    <td>
                      <template v-if="item.Assigned_By_Usertype !== 'admin'">
                        <a href="#" @click.prevent="editTask(item)"><i class="fa fa-edit mr-2"></i></a>
                        <a href="#" @click.prevent="confirmTaskDeletion(item)"><i class="fa fa-trash text-danger"></i></a>
                      </template>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="createTaskModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">
            <span v-if="editing">Edit Task</span>
            <span v-else>Add New Task</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <Form autocomplete="off" @submit.prevent="handleSubmit" :validation-schema="schema" v-slot="{ errors }" :initial-values="editing ? formValues : form">
            <div class="form-group">
              <label for="Task">Task</label>
              <Field type="text" v-model="formValues.Task" class="form-control" name="Task" :class="{'is-invalid': errors.Task}" id="Task" placeholder="Enter task"/>
              <span class="invalid-feedback">{{ errors.Task }}</span>
            </div>
            <div class="form-group">
              <label for="Description">Description</label>
              <Field type="text" v-model="formValues.Description" class="form-control" name="Description" :class="{'is-invalid': errors.Description}" id="Description" placeholder="Enter description"/>
              <span class="invalid-feedback">{{ errors.Description }}</span>
            </div>
            <div class="form-group">
              <label for="Date_Given">Date Given</label>
              <Field type="date" v-model="formValues.Date_Given" class="form-control" name="Date_Given" :class="{'is-invalid': errors.Date_Given}" id="Date_Given" placeholder="Enter Date_Given"/>
              <span class="invalid-feedback">{{ errors.Date_Given }}</span>
            </div>
            <div class="form-group">
              <label for="Due_Date">Due Date</label>
              <Field type="date" v-model="formValues.Due_Date" class="form-control" name="Due_Date" :class="{'is-invalid': errors.Due_Date}" id="Due_Date" placeholder="Due Date"/>
              <span class="invalid-feedback">{{ errors.Due_Date }}</span>
            </div>
            <div class="form-group">
              <label for="Priority">Priority</label>
              <Field as="select" v-model="formValues.Priority" class="form-control" name="Priority" :class="{'is-invalid': errors.Priority}" id="Priority">
                <option value="">Select Priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
              </Field>
              <span class="invalid-feedback">{{ errors.Priority }}</span>
            </div>
            <div class="form-group">
              <label for="Status">Status</label>
              <Field as="select" v-model="formValues.Status" class="form-control" name="Status" :class="{'is-invalid': errors.Status}" id="Status">
                <option value="">Enter Status</option>
                <option value="Assigned">Assigned</option>
                <option value="In progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Late">Late</option>
                <option value="Cancelled">Cancelled</option>
              </Field>
              <span class="invalid-feedback">{{ errors.Status }}</span>
            </div>
          </Form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button @click="handleSubmit" type="button" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteTaskModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">
            <span>Delete Task</span>       
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>Are you sure you want to delete this task?</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button @click.prevent="deleteTask" type="button" class="btn btn-primary">Delete Task</button>
        </div>
      </div>
    </div>
  </div>
</template>

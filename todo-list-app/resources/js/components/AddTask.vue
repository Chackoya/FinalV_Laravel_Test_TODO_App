<template>
    <!-- Add task form  -->
    <div class="form-center">
      <form @submit.prevent="addTask">
        <input type="text" v-model="newTask.title" placeholder="Task title" />
        <select v-model="newTask.status">
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
        <button type="submit">Add Task</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    // init component data
    data() {
      return {
        newTask: {
          title: '',
          status: 'pending',
        },
        errorMessage: ''
      };
    },
    methods: {
      // Method to add a new task
      addTask() {
        axios.post('/api/tasks', this.newTask)
          .then(() => {
            // On successful task addition, reset the form and emit an event
            this.$emit('task-added');
            this.newTask.title = '';
            this.errorMessage = '';
          })
          .catch(error => {
            // Show error message if title validation fails: in case the user inputs a long title (+ 255 chars) or empty string
            if (error.response && error.response.status === 400) {
              this.errorMessage = 'Title must be between 1 and 255 characters';
            }
          });
      },
    },
  };
  </script>
  

  
  <style scoped>
  /* simple styling... */
  .form-center {
    text-align: center;
    margin-top: 20px;
  }
  </style>
  
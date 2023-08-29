<template>
    <!-- Form to update a task (from edit btn) -->
    <div>
      <form @submit.prevent="updateTask">
        <input type="text" v-model="task.title" />
        <select v-model="task.status">
          <!-- selection of the status (only 2 options) -->  
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
        <button type="submit">Update Task</button>
      </form>
      <!-- error messages (too long string etc) -->
      <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    // Accept the task to edit as a prop
    props: ['taskToEdit'],
    data() {
      return {
        // copy of the task to edit
        task: { ...this.taskToEdit },
        errorMessage: ''
      };
    },
    methods: {
      // Method to update task
      updateTask() {
        axios.put(`/api/tasks/${this.task.id}`, this.task)
          .then(() => {
            // successful update ->  emit an event
            this.$emit('task-updated');
            this.errorMessage = '';
          })
          .catch(error => {
            // Error msg (bad response)
            if (error.response && error.response.status === 400) {
              this.errorMessage = 'Title must be between 1 and 255 characters';
            }
          });
      },
    },
  };
  </script>
  
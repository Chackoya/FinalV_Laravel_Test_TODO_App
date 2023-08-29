<template>
  <!-- Template to display the list of tasks from db; -->
  <div>
    <ul>
      <!-- Loop through tasks and display each one  -->
      <li v-for="task in tasks" :key="task.id" :class="{completed: task.status === 'completed'}">
        {{ task.title }} - {{ task.status }}
        <!-- buttons for editing and deleting tasks -->
        <button @click="editTask(task)">Edit</button>
        <button @click="deleteTask(task)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  // Accept 'tasks' prop from parent component
  props: ['tasks'],
  methods: {
    // Emit event to edit selected task
    editTask(task) {
      this.$emit('edit-task', task);
    },
    // Emit event to delete selected task
    deleteTask(task) {
      this.$emit('delete-task', task);
    }
  }
};
</script>

<style>
/* Style completed tasks in green: */
.completed {
  color: darkgreen;
}
</style>

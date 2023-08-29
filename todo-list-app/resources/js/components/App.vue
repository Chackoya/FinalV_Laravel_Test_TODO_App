<template>
    <!-- Main App -->
    <div>
      <h1>Todo List App</h1>
      <!-- Button to show Add Task Form -->
      <button @click="showAddTaskForm = true">Add Task</button>
      <!--         
        conditional rendering and event tracking from child components; 
        Those childs emit events that are tracked here (update task, delete , add)

        ex. when in EditTask component: if a task is updated then we will emit an event and it will call taskUpdated method from parent (this file)
      -->
      <AddTask v-if="showAddTaskForm" @task-added="refreshTasks" />
      <TodoList :tasks="tasks" @edit-task="editSelectedTask" @delete-task="deleteSelectedTask" />
      <EditTask v-if="taskToEdit" :taskToEdit="taskToEdit" @task-updated="taskUpdated" />
    </div>
  </template>
  
  <script>
  // Import required components and axios for HTTP requests
  import axios from 'axios';
  import TodoList from './TodoList.vue';
  import AddTask from './AddTask.vue';
  import EditTask from './EditTask.vue';
  
  export default {
    // Register components
    components: {
      TodoList,
      AddTask,
      EditTask,
    },
    // Initialize component data
    data() {
      return {
        tasks: [],
        showAddTaskForm: false,
        taskToEdit: null,
      };
    },
    // Fetch tasks when component is mounted
    mounted() {
      this.refreshTasks();
    },
    // Define methods
    methods: {
      // Fetch all tasks from API
      refreshTasks() {
        axios.get('/api/tasks')
          .then(response => {
            this.tasks = response.data;
          });
      },
      // Set selected task to edit
      editSelectedTask(task) {
        this.taskToEdit = task;
      },
      // Delete option;
      deleteSelectedTask(task) {
        axios.delete(`/api/tasks/${task.id}`)
          .then(() => {
            this.refreshTasks();
          });
      },
      // refresh tasks and reset taskToEdit after a task has been updated
      taskUpdated() {
        this.refreshTasks();
        this.taskToEdit = null;  
      }
    },
  };
  </script>
  

<style scoped>
h1 {
  text-align: center;
  font-weight: bold;  
}

button {
  display: block;
  margin: 0 auto;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  background-color: #3507d8;
  border: none;
  color: white;
  border-radius: 4px;
}
</style>

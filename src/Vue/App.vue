<template>
  <div class="todo-list-container bg-container">
    <header class="sticky-top bg-light mb-3 px-2 rounded">
      <h2 id="title" class="text-center">Tasks <i class="bi bi-list-check"></i></h2>
      <AddItemForm v-on:reloadTasks="getTasks()" />
    </header>
    <ListView :tasks="tasks" v-on:reloadTasks="getTasks()" />
  </div>
</template>

<script>
import { fetch } from '@/service.js';
import AddItemForm from '@/Vue/Components/AddItemForm.vue'
import ListView from '@/Vue/Components/ListView.vue';
export default {
  components: {
    AddItemForm,
    ListView
  },
  data: function () {
    return {
      tasks: []
    }
  },
  methods: {
    async getTasks() {
      try {
        const tasks = await fetch();
        this.tasks = [...tasks.data];
      } catch (err) {
        console.log(err)
      }
    }
  },
  created() {
    this.getTasks()
  }
}
</script>
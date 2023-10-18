<template>
  <section>
    <div v-if="showError" class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error:</strong> {{ errorMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div v-for="taskItem in tasks" :key="taskItem.id">
      <ListTask :taskItem="taskItem" v-on:taskChanged="$emit('reloadTasks')" v-on:errorOccurred="handleError" />
    </div>
  </section>
</template>

<script>
import ListTask from './ListTask.vue';


export default {
  props: ['tasks'],
  components: { ListTask },
  data() {
    return {
      showError: false,
      errorMessage: ""
    };
  },
  methods: {
    handleError(message) {
      this.showError = true;
      this.errorMessage = message;
    }
  }
}
</script>
<template>
  <form class="d-flex justify-content-between needs-validation">
    <div class="w-100 me-2">
      <label for="task" class="visually-hidden">Tasks</label>
      <input type="text" :class="descriptionClass" id="task" v-model="task.description" placeholder="Enter Task" required>
      <div class="invalid-feedback">
        {{ error }}
      </div>
    </div>
    <div>
      <button type="button" id="btn-add" :class="[task.description ? 'btn-success' : 'btn-secondary', ' rounded-circle btn mb-3']" @click="addTask()">
        <i class="bi bi-plus"></i>
      </button>
    </div>
  </form>
</template>

<script>
import { store } from '@/service.js';
import { descriptionClassMixin } from '@/Vue/Mixins/descriptionValidationMixin.js'

export default {
  mixins: [descriptionClassMixin],
  data: function () {
    return {
      task: {
        description: ""
      },
      error: null
    }
  },
  methods: {
    async addTask() {
      try {
        await store(this.task);
        this.error = null;
        this.$emit('reloadTasks')
        this.task.description = "";
      } catch (err) {
        if (err.response.data.errors.description) {
          this.error = Object.values(err.response.data.errors.description)[0];
        } else {
          console.err(err.response.data.errors);
        }
      }
    }
  }
}
</script>
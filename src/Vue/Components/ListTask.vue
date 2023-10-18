<template>
  <div>
    <div class="shadow px-2 py-1 mb-2 bg-body-tertiary rounded bg-item">
      <div v-if="!isEditing" class="d-flex justify-content-between align-items-center">
        <input class="m-0 form-check-input" @change="updateStatus()" v-model="status.completed" type="checkbox" value=""
          :id="`check-${taskItem.id}`">
        <label :class="[status.completed ? 'text-decoration-line-through' : '', 'form-check-label flex-fill']"
          :for="`check-${taskItem.id}`">
          {{ taskItem.description }}
        </label>
        <button v-if="!status.completed" type="button" class="btn btn-outline-primary btn-sm rounded-circle me-2 mb-0"
          @click="startEditing">
          <i class="bi bi-pencil"></i>
        </button>
        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle mb-0" @click="deleteTask"><i
            class="bi bi-trash"></i></button>
      </div>
      <div v-else class="d-flex justify-content-between align-items-start py-2 edit-container">
        <div class="flex-fill me-2">
          <input type="text" :class="[descriptionClass, 'mb-0 mt-auto flex-fill']" v-model="task.description">
          <div class="invalid-feedback">
            {{ error }}
          </div>
        </div>
        <div class="py-1">
          <button type="button" class="btn btn-outline-success btn-sm rounded-circle me-1" @click="confirmEdit"><i
              class="bi bi-check"></i></button>
          <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" @click="cancelEdit"><i
              class="bi bi-x"></i></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { update, destroy } from '@/service.js';
import { descriptionClassMixin } from '@/Vue/Mixins/descriptionValidationMixin.js'

export default {
  mixins: [descriptionClassMixin],
  props: ['taskItem'],
  data: function () {
    return {
      status: {
        completed: this.taskItem.status_id == 2 ? true : false
      },
      task: {
        description: this.taskItem.description
      },
      isEditing: false,
      error: null
    }
  },
  methods: {
    startEditing() {
      this.isEditing = true;
    },
    cancelEdit() {
      this.isEditing = false;
      this.task.description = this.taskItem.description;
    },
    resetEditingState() {
        this.isEditing = false;
        this.task.description = this.taskItem.description;
        this.error = null;
    },
    async updateStatus() {
      try {
        if (this.isEditing) {
          this.cancelEdit();
        }
        let newStatusId = this.status.completed ? 2 : 1;
        let data = {
          status_id: newStatusId
        };
        await update(this.taskItem.id, data, "PATCH", "/status");
        this.$emit('taskChanged');
        this.$root.$emit('closeEditing');
      } catch (err) {
        this.$emit('errorOccurred', err.response.data.message);
        console.log(err)
      }
    },
    async confirmEdit() {
      try {
        let data = {
          description: this.task.description
        };
        await update(this.taskItem.id, data, "PUT");
        this.isEditing = false;
        this.$emit('taskChanged');
      } catch (err) {
        if (err.response.data.errors.description) {
          this.error = Object.values(err.response.data.errors.description)[0];
        } else {
          this.$emit('errorOccurred', err.response.data.message);
          console.err(err.response.data);
        }
      }
    },
    async deleteTask() {
      try {
        await destroy(this.taskItem.id);
        this.$emit('taskChanged');
      } catch (err) {
        this.$emit('errorOccurred', err.response.data.message);
        console.log(err);
      }
    }
  },
  created() {
    this.$root.$on('closeEditing', this.resetEditingState);
  },
  beforeDestroy() {
    this.$root.$off('closeEditing', this.resetEditingState);
  },
}
</script>
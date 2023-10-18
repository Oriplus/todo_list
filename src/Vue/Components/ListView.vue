<template>
  <div>
    <div v-for="taskItem in tasks" :key="taskItem.id">
      <ListTask :taskItem="taskItem" v-on:taskChanged="$emit('reloadTasks')"/>
    </div>
  </div>
</template>

<script>
import ListTask from './ListTask.vue';


export default {
  props: ['tasks'],
  components: { ListTask }
}
</script>
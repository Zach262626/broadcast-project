<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id'])
const status = ref(0)
onMounted(() => {
  Echo.private('Counter.User.' + props.user_id)
    .listen('CounterStatus', (e) => {
      status.value = e.status;
      console.log(e.status);
    });
});


</script>

<template>
  <div class="mt-5 p-4 border border-3 container">
    <div class="row">
      <button class="btn btn-light border" type="submit">Start Count</button>
    </div>
    <div class="progress mt-3">
      <div class="progress-bar bg-success" role="progressbar" :style="{ width: status + '%' }" :aria-valuenow="status"
        aria-valuemin="0" aria-valuemax="100"></div>
    </div>
  </div>
</template>
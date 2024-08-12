<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id', '_token', 'counter_status_route', 'start_counter'])
const status = ref(0)
function statusReset() {
  status.value = 0;
}
function getOldStatus() {
  $.ajax({
    url: props.counter_status_route,
    type: 'GET',
    success: function (results) {
      status.value = results.status;
    },
    error: function (error) {
      console.log(JSON.stringify(error));
    }
  });
}
function startCounter() {
    var postData = JSON.stringify({
        user_id: props.user_id,
        _token: props._token
    });
    $.ajax({
        type: 'POST',
        url: props.start_counter,
        data: postData,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (results) {
            status.value = results;
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
    return true;
}
onMounted(() => {
  getOldStatus();
  Echo.private('Counter.User.' + props.user_id)
    .listen('CounterStatus', (e) => {
      status.value = e.status;
    });
});


</script>

<template>
  <div class="mt-5 p-4 border border-3 container">
    <div v-if="status == 0" class="row">
      <button class="btn btn-light border" @click="startCounter()" type="button">Start Count</button>
    </div>
    <div v-if="status != 0" class="progress mt-3" style="height: 30px;">
      <div :class="{ 'bg-success': status == 100, 'bg-danger': status < 100 }" class="progress-bar fs-5" role="progressbar" :style="{ width: status + '%' }" :aria-valuenow="status"
        aria-valuemin="0" aria-valuemax="100">{{ status }}%</div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id']);
const filename = ref("");
const filepath = ref("");
const filestatus = ref(0);
const files = ref([]);
const show = ref(false);

function showAlert() {
  var toast = new bootstrap.Toast(document.getElementById('download-alert'));
  toast.show();
  changeView(true);
}
function changeView(choice) {
  if (choice) {
    show.value = true;
  } else {
    show.value = false;
  }
}

onMounted(() => {
  Echo.private('Download.User.' + props.user_id)
    .listen('DownloadStatus', (e) => {
      files.value.push(e.filename);
      filename.value = e.filename;
      filepath.value = e.path;
      filestatus.value = e.status;
      showAlert();
    });
});


</script>

<template>
  <div v-show="show" class="toast bg-dark" id="download-alert" role="alert" aria-live="assertive" aria-atomic="true"
    data-bs-autohide="false">
    <div v-if="filestatus == 100">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Download Is Complete</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <input type='hidden' :value="filepath" name='path' id='path'>
        <button class="btn btn-light border" data-bs-dismiss="toast" @click="changeView(false)" type="submit">
          {{ filename }}
        </button>
      </div>
    </div>
    <div v-else>
      <div class="toast-header bg-danger text-white">
        <strong class="me-auto">Downloading</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <div class="progress-bar fs-5 bg-danger"
            role="progressbar" :style="{ width: filestatus + '%' }" :aria-valuenow="filestatus" aria-valuemin="0"
            aria-valuemax="100">
            {{ filestatus }}%
        </div>
      <ul>
        <li v-for="file in files"> {{ file }}</li>
      </ul>
    </div>
    </div>
  </div>
</template>

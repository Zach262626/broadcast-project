<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id', '_token', 'download_status', 'download_zip_delete']);
const filename = ref("");
const filepath = ref("");
const filestatus = ref(0);
const files = ref([]);
const show = ref(false);
const download = ref(true);

function showAlert() {
  var toast = new bootstrap.Toast(document.getElementById('download-alert'));
  toast.show();
  show.value = true;
}
function hideAlert() {
  var toast = new bootstrap.Toast(document.getElementById('download-alert'));
  toast.hide();
  show.value = false;
}
function deleteDownloaded() {
  files.value = [];
  hideAlert()
  var postData = JSON.stringify({
    user_id: props.user_id,
    _token: props._token,
    path: filepath.value
  });
  $.ajax({
    type: 'POST',
    url: props.download_zip_delete,
    data: postData,
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (results) {
    },
    error: function (error) {
      console.log(JSON.stringify(error));
    }
  });
}
function getOldStatus() {
  $.ajax({
    url: props.download_status,
    type: 'GET',
    success: function (results) {
      filename.value = results.name;
      filepath.value = results.path;
      if (results.status == false) {
        filestatus.value = 100;
        showAlert();
      }
    },
    error: function (error) {
      console.log(JSON.stringify(error));
    }
  });
}
onMounted(() => {
  getOldStatus()
  Echo.private('Download.User.' + props.user_id)
    .listen('DownloadStatus', (e) => {
      if (e.filename != 'start') {
        console.log(files.status);
      } else {
        files.value = [];
      }
      console.log(e.status);
      filename.value = e.filename;
      filepath.value = e.path;
      filestatus.value = e.status;
      showAlert();
    });
});


</script>

<template>
  <download-warning :data="{ 'filestatus': filestatus, 'filename': filename }" :route="props.download_status"
    @deletedownloaded="(choice) => { if (choice) { deleteDownloaded() } }"><!--Props and Emits-->
  </download-warning>
  <input type='hidden' :value="download" name='path' id='path'>
  <div v-show="show" class="toast bg-dark position-fixed end-0 bottom-0" id="download-alert" role="alert"
    aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
    <div v-if="filestatus == 100">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Download Is Complete</strong>
        <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>
      </div>
      <div class="toast-body">
        <input type='hidden' :value="filepath" name='path' id='path'>
        <input type='hidden' :value="filename" name='name' id='name'>
        <button class="btn btn-light border" data-bs-dismiss="toast" @click="hideAlert()" type="submit"
          id="download-submit">
          {{ filename }}
        </button>
      </div>
    </div>
    <div v-else>
      <div class="toast-header bg-danger text-white">
        <strong class="me-auto">Downloading</strong>
        <button type="button" class="btn-close" @click="hideAlert()" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <div class="progress-bar fs-5 bg-danger" role="progressbar" :style="{ width: filestatus + '%' }"
          :aria-valuenow="filestatus" aria-valuemin="0" aria-valuemax="100">
          {{ filestatus }}%
        </div>
        <ul>
          <li v-for="file in files"> {{ file }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>


<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id']);
const progress = ref(0);
const files = ref([]);
const show = ref(false);

// Methods
function showAlert() {
  var toast = new bootstrap.Toast(document.getElementById('upload-alert'));
  toast.show();
  changeView(true);
}

function changeView(choice) {
  if (choice) {
    show.value = true;
  }else {
    show.value = false;
  }
}
// Methods end
onMounted(() => {
    Echo.private('Upload.User.' + props.user_id)
        .listen('UploadStatus', (e) => {
            progress.value = e.status;
            files.value.push(e.file);
            showAlert();
        });
});

</script>

<template>
    <div v-show="show" class="toast bg-dark" id="upload-alert" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-header bg-success text-white">
        <strong v-if="progress < 100" class="me-auto">Uploading</strong>
        <strong v-else class="me-auto">The Upload is Complete</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" :style="{width: progress + '%'}" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <ul>
          <li v-for="file in files"> {{file}}</li>
        </ul>
      </div>
    </div>
</template>
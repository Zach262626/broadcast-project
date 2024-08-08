
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
            if (progress.value == 100) {
                showAlert();
            }
        });
});

</script>

<template>
    <div v-show="show" class="toast bg-dark" id="upload-alert" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">The Upload Is Complete</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <ul>
          <li v-for="file in files"> {{file}}</li>
        </ul>
      </div>
    </div>
</template>

  
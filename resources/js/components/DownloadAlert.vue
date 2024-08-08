
<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id'])
const filename = ref("")
const filepath = ref("");
const show = ref(false);

function showAlert() {
    var toast = new bootstrap.Toast(document.getElementById('download-alert'));
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


onMounted(() => {
    Echo.private('Download.User.' + props.user_id)
        .listen('DownloadStatus', (e) => {
          console.log(e);
            filename.value = e.filename;
            filepath.value = e.path;
            showAlert();
        });
});


</script>

<template>
    <div v-show="show" class="toast bg-dark" id="download-alert" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Download Is Complete</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <input type='hidden' :value="filepath" name='path' id='path'>
        <button class="btn btn-light border" data-bs-dismiss="toast" @click="changeView(false)" type="submit">{{ filename }}</button>
      </div>
    </div>
</template>

  
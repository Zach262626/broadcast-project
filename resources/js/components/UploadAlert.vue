
<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['user_id'])
const progress = ref(0)
const files = ref([]);

function showAlert() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl)
    })
    toastList.forEach(toast => toast.show()) 
    console.log(progress.value);
}

onMounted(() => {
    Echo.private('App.Models.User.' + props.user_id)
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
  <div class="container mt-3">
    <div class="toast bg-dark">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">The Upload Is Complete</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
      <ul>
        <li v-for="file in files"> {{file}}</li>
      </ul>
    </div>
    </div>
  </div>
</template>

  

<script setup>
import { onMounted, ref } from 'vue'


// Methods

// Methods end
onMounted(() => {
    Echo.private('Download.User.' + props.user_id)
        .listen('DownloadStatus', (e) => {
          console.log(e);
            filename.value = e.filename;
            filepath.value = e.path;
            showAlert();
        });
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
    
</template>
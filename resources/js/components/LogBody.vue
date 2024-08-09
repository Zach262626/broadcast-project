
<script setup>
import { onBeforeMount, onMounted, ref } from 'vue'
const file = ref([])
const props = defineProps(['user_id', '_token']);

// Methods
function updateFileLog(data) {
    var postData = JSON.stringify({
        name: data.name,
        description: data.description,
        type: data.type,
        _token: _token
    });
    $.ajax({
        type:'POST',
        url: "{{ route('update-file-log') }}",
        data: postData,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(results) {
            console.log(results)
            return results;
        },
        error: function(error) {
            console.log(JSON.stringify(error));
        }
    });
    return true;
}
function getOldLog() {
    let results = $.ajax({
        url: "{{ route('old-logs') }}",
        type: 'GET',
        success: function (results) {
            console.log
            return results;
        },
        error: function(error) {
            console.log(JSON.stringify(error));
        }
      });
    return false
}
// Methods end
onMounted(() => {
    getOldLog();
    Echo.private('Download.User.' + props.user_id)
        .listen('DownloadStatus', (e) => {
          console.log(e);
            const newFile = {}
            newFile.name =  e.filename;
            newFile.description = "The file" + e.filename + " is ready to download";
            newFile.type = "DownloadReady";
            newFile.path =  e.path;
            newFile.user =  e.user_id;
            file.value.push(newFile);
            console.log(file.value[0].name);
        });
    Echo.private('Upload.User.' + props.user_id)
    .listen('UploadStatus', (e) => {
        const newFile = {}
        newFile.name =  e.filename;
        newFile.description = "The file" + e.filename + " is uploaded";
        newFile.type = "Upload";
        newFile.status =  e.status;
        newFile.user =  e.user_id;
        file.value.push(newFile);
        console.log(file.value);
        if (e.status == 100) {
            console.log(true);
        }
    });
});

</script>

<template>
    <ul>
        <li v-for="item in file"> {{item.name}}</li>
    </ul>
</template>
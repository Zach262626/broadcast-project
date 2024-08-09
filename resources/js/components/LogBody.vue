<script setup>
import { onBeforeMount, onMounted, ref } from 'vue'
const file = ref([])
const props = defineProps(['user_id', '_token', 'old_log_route', 'new_log_route']);

// Methods
function updateFileLog(data) {
    var postData = JSON.stringify({
        name: data.name,
        description: data.description,
        type: data.type,
        _token: props._token
    });
    console.log(postData);
    $.ajax({
        type: 'POST',
        url: props.new_log_route,
        data: postData,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (results) {
            return results;
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
    return true;
}
function getOldLog() {
    $.ajax({
        url: props.old_log_route,
        type: 'GET',
        success: function (results) {
            console.log(results);
            for (let i = 0; i < results.length; ++i) {
                file.value.push(results[i]);
            }
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
}
getOldLog();
// Methods end
onMounted(() => {
    Echo.private('Download.User.' + props.user_id)
        .listen('DownloadStatus', (e) => {
            const newFile = {};
            newFile.name = e.filename;
            newFile.description = "The file " + e.filename + " is ready to download";
            newFile.type = "DownloadReady";
            newFile.path = e.path;
            newFile.user = e.userId;
            updateFileLog(newFile);
            file.value.push(newFile);
        });
    Echo.private('Upload.User.' + props.user_id)
        .listen('UploadStatus', (e) => {
            const newFile = {};
            newFile.name = e.file;
            newFile.description = "The file " + e.file + " is uploaded";
            newFile.type = "Upload";
            newFile.status = e.status;
            newFile.user = e.userId;
            updateFileLog(newFile);
            file.value.push(newFile);
            if (e.status == 100) {
                console.log(true);
            }
        });
});

</script>

<template>
    <ul>
        <li v-for="item in file"> 
            {{ item.type }} <strong>{{ item.name }}</strong> : {{ item.description }} // Time: {{ item.created_at }}.
        </li>
    </ul>
</template>
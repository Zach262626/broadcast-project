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
            file.value.unshift(newFile);
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
            file.value.unshift(newFile);
        });
});

</script>

<template>
    <ul>
        <li v-for="item in file">
            <button v-if="item.path">
                <input type='hidden' :value="item.name" name='path' id='path'>
                <a style="color: green; text-decoration: underline;">
                    <strong>{{ item.name }}</strong>
                    <input type='hidden' :value="item.path" name='path' id='path'>
                </a>
                : {{ item.description }}. // Type: {{ item.type }}
            </button>
            <div v-else>
                <strong style="color: green">{{ item.name }}</strong>
                : {{ item.description }}. // Type: {{ item.type }}
            </div>
        </li>
    </ul>
</template>
<style scoped>
button {
    all: unset;
}

button:focus {
    outline: revert;
}
</style>
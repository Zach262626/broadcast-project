<script setup>
import { onBeforeMount, onMounted, ref } from 'vue'
const file = ref([])
const props = defineProps(['user_id', '_token', 'old_log_route', 'new_log_route'])

function closeLog(toggle) {
    var myCollapse = document.getElementById('myCollapse')
    var bsCollapse = new bootstrap.Collapse(myCollapse, {
        toggle: toggle
    })
}
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
            if (e.status == 100) {
                newFile.description = "The file " + e.filename + " is ready to download";
                newFile.path = e.path;
                newFile.type = "DownloadReady";
            } else {
                newFile.description = "The file " + e.filename + " is added to downloads";
                newFile.type = "AddedDownload";
            }
            newFile.name = e.filename;
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
    Echo.private('Export.Files.User.' + props.user_id)
        .listen('ExcelExportEvent', (e) => {
            console.log(e);
        });
});

</script>

<template>
    <a @click="closeLog(true)" class="text-center w-100 btn btn-dark">toggle logs</a>
    <div id="myCollapse" class="collapse">
                <div class="container" id="log">
                    <div class="px-4 border-bottom border-3">
                        <div class="d-flex align-items-center justify-content-center py-2 border-bottom border-white">Logs</div>
                        <div style="height: 300px;" class="overflow-auto">
                            <div class="h-100">
                                <ul>
                                    <li v-for="item in file">
                                        <div>
                                            <strong style="color: green">{{ item.name }}</strong>
                                            : {{ item.description }}. // Type: {{ item.type }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</template>
<style scoped>
button {
    all: unset;
}

button:focus {
    outline: revert;
}
</style>
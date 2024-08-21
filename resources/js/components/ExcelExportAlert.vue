<script setup>
import { onMounted, ref, onUpdated } from 'vue'
const props = defineProps(['user_id', '_token', 'type', 'get_export_info', 'delete_export', 'download_export'])
const status = ref(0)
const audio = new Audio('/audio/tap-notification-180637.mp3');
const filename = ref("")
const filepath = ref("")
function deleteStatus() {
    if (status.value == 100) {
        status.value = 0;
        var postData = JSON.stringify({
            type: props.type,
            user_id: props.user_id,
            _token: props._token
        });
        $.ajax({
            type: 'POST',
            url: props.delete_export,
            data: postData,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (results) {
                console.log(results);
            },
            error: function (error) {
                console.log(JSON.stringify(error));
            }
        });
    }
}
function getOldStatus() {
    $.ajax({
    url: props.get_export_info,
        type: 'GET',
        data: {
            user_id: props.user_id,
            type: props.type,
        },
        success: function (results) {
            if (results && !results.status) {
                status.value = 100;
                filepath.value = results.path;
                filepath.name = results.name;
            }
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
}
getOldStatus()
onMounted(() => {
    console.log(filepath.value)
    Echo.private('Export.Files.User.' + props.user_id)
        .listen('ExcelExportEvent', (e) => {
            if (e.type == props.type) {
                status.value = e.status;
                filepath.value = e.path,
                filename.value = e.exportFileName;
                if (status.value == 100) {
                    console.log('job done');
                    audio.play();
                }
            }
        });
});
</script>

<template>
    <progress-bar-toast
    :headerClass="{'bg-success': status==100, 'bg-danger': status!=100}"
        :contentClass="{'bg-success': status==100, 'bg-danger': status!=100}"
        :TriggerId="type + '-alert'"
        :progressActive="status > 0"
        :progress="status"
        @closeToast="(choice) => { if (choice) { deleteStatus() } }"
    >
        <template #header>
            <strong v-if="status == 100" class="me-auto">Export Complete</strong>
            <strong v-else class="me-auto">Exporting</strong>
        </template>
        <template #content>
                <form :action="props.download_export" method="POST">
                    <input type="hidden" name="_token" id='_token':value="props._token">
                    <input type='hidden' :value="filepath" name='path' id='path'>
                    <input type='hidden' :value="filename" name='name' id='name'>
                    <input type='hidden' :value="type" name='type' id='type'>
                    <button class="btn btn-light border w-100 mt-3" data-bs-dismiss="toast" @click="status=0" type="submit"
                        id="download-submit">
                        Download
                    </button>
                </form>
        </template>
    </progress-bar-toast>
</template>
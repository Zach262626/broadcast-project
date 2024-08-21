<script setup>
import { onMounted, ref, onUpdated } from 'vue'
const props = defineProps(['user_id', '_token', 'delete_counter', 'counter_status_route'])
const status = ref(-1)
const audio = new Audio('/audio/tap-notification-180637.mp3');
function getOldStatus() {
    $.ajax({
        url: props.counter_status_route,
        type: 'GET',
        success: function (results) {
            status.value = results.status;
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
}
function deleteStatus() {
    if (status.value == 100) {
        var postData = JSON.stringify({
            user_id: props.user_id,
            _token: props._token
        });
        $.ajax({
            type: 'POST',
            url: props.delete_counter,
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
onMounted(() => {
    getOldStatus();
    Echo.private('Counter.User.' + props.user_id)
        .listen('CounterStatus', (e) => {
            status.value = e.status;
            if (status.value == 100) {
                console.log('counter done');
                audio.play();
            }
        });
});
</script>

<template>
    <progress-bar-toast
        :headerClass="{'bg-success': status==100, 'bg-danger': status!=100}"
        :contentClass="{'bg-success': status==100, 'bg-danger': status!=100}"
        TriggerId="counter-alert"
        :progressActive="status > 0"
        :progress="status"
        @closeToast="(choice) => { if (choice) { deleteStatus() } }"
    >
        <template #header>
            <strong v-if="status == 100" class="me-auto">Count Is Complete</strong>
            <strong v-else class="me-auto">Counting</strong>
        </template>
    </progress-bar-toast>
</template>
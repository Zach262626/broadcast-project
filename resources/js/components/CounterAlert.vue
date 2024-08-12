<script setup>
import { onMounted, ref, onUpdated } from 'vue'
const props = defineProps(['user_id', '_token', 'delete_counter', 'counter_status_route'])
const show = ref(false)
const done = ref(false)
const status = ref(0)
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
    changeView(false)
    if (status.value == 100) {
        changeView(false)
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
function showAlert() {
    {
        var toast = new bootstrap.Toast(document.getElementById('counter-alert'));
        toast.show();
        changeView(true);
    }
}
function changeView(choice) {
    if (choice) {
        show.value = true;
    } else {
        show.value = false;
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
onUpdated(() => {
    if (status.value > 0) {
        showAlert();
    }
    if (status.value == 100) {
        done.value = true;
    } else {
        done.value = false;
    }

});


</script>

<template>
    <div v-show="show" class="toast bg-dark" id="counter-alert" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="false">
        <div :class="{ 'bg-success': done, 'bg-danger': done == false }" class="toast-header text-white">
            <strong v-if="status == 100" class="me-auto">Count Is Complete</strong>
            <strong v-else class="me-auto">Counting</strong>
            <button type="button" class="btn-close" @click="deleteStatus()" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <div class="progress mt-3" style="height: 30px;">
                <div :class="{ 'bg-success': done, 'bg-danger': done == false }" class="progress-bar fs-5"
                    role="progressbar" :style="{ width: status + '%' }" :aria-valuenow="status" aria-valuemin="0"
                    aria-valuemax="100">{{ status }}%</div>
            </div>
        </div>
    </div>
</template>
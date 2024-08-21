<script setup>
import { onUpdated, onMounted, ref } from 'vue'
const props = defineProps(['headerClass', 'contentClass', 'TriggerId', 'progressActive', 'progress'])
const emit = defineEmits(["closeToast"]);
const show = ref(false)
function showAlert() {
    var toast = new bootstrap.Toast(document.getElementById(props.TriggerId));
    toast.show();
    show.value = true;
}
function hideAlert() {
    var toast = new bootstrap.Toast(document.getElementById(props.TriggerId));
    toast.hide();
    show.value = false;
}
onMounted(() => {
    if (props.progress > 0) {
        showAlert();
    }{
        hideAlert();
    }
});
onUpdated(() => {
    if (props.progressActive) {
        showAlert();
    }else {
        hideAlert();
    }
});

</script>

<template>
    <div v-show="show" class="toast bg-dark" :id="TriggerId" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="false">
        <div :class="headerClass" class="toast-header text-white">
            <slot name="header"></slot>
            <button type="button" class="btn-close" @click="[hideAlert(), emit('closeToast', true)]" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            <div v-if="progressActive == true" class="progress mt-3" style="height: 30px;">
                <div :class="contentClass" class="progress-bar fs-5"
                    role="progressbar" :style="{ width: progress + '%' }" :aria-valuenow="progress" aria-valuemin="0"
                    aria-valuemax="100">{{ progress }}%</div>
            </div>
            <slot name="content"></slot>
        </div>
    </div>
</template>

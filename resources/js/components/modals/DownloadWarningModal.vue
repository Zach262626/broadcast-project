<script setup>
import { onMounted, ref } from 'vue'
const props = defineProps(['data', 'route']);
const emit = defineEmits(["deletedownloaded"]);
</script>

<template>
    <!-- Warning Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <!-- X Button -->
    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModal"></button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="color: black">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Download</h5>
                    <button @click="emit('deletedownloads', false)" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div>
                            Are you sure you want to cancel the download?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="emit('deletedownloaded', false)" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Cancel</button>
                    <button @click="emit('deletedownloaded', true)" type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

</template>

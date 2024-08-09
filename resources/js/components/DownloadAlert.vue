<script>
import { ref } from 'vue'
export default {
  props: ['user_id'],
  setup(props) {
    const filename = ref("")
    const filepath = ref("");
    const show = ref(false);
    const user_id = ref(props.user_id)
    return {
      filename, filepath, show, user_id
    }
  },
  methods: {
    showAlert() {
      var toast = new bootstrap.Toast(document.getElementById('download-alert'));
      toast.show();
      changeView(true);
    },
    changeView(choice) {
      if (choice) {
        show.value = true;
      }else {
        show.value = false;
      }
    }
  },
  mounted() {
    Echo.private('Download.User.' + this.user_id.value)
        .listen('DownloadStatus', (e) => {
          console.log(e);
            filename.value = e.filename;
            filepath.value = e.path;
            showAlert();
        })
  }
}
</script>

<template>
    <div v-show="show" class="toast bg-dark" id="download-alert" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
      <div class="toast-header bg-success text-white">
        <strong class="me-auto">Download Is Complete</strong>
        <button type="button" class="btn-close" @click="changeView(false)" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <input type='hidden' :value="filepath" name='path' id='path'>
        <input type='hidden' :value="filename" name='name' id='name'>
        <button class="btn btn-light border" data-bs-dismiss="toast" @click="changeView(false)" type="submit">{{ filename }}</button>
      </div>
    </div>
</template>

  
<template>
    
    <div class="container" style="width:50%; display: inline-block; padding: 5px; overflow:scroll; height:200px;">
        <h1>Downloaded</h1>
        <div class="row justify-content-center">
            <div  v-for="(item, index) in files_added" class="card-body">
                * {{ item }} 
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                files_added: [],
                count: 0
            }
        },
        created() {    
            window.Echo.private('App.Models.User.' + this.user_id).
                listen('UploadStatus', (e) => {
                    this.files_added.push(e.file);
                })
        }
    }
</script>

<template>
    <div style="width:100%; display: inline-block;padding: 5px; overflow:scroll; height:200px;">
        <h1>Uploaded Progress</h1>  
            <div style="border: solid black 1px">
                <div class="progress-bar"></div>
            </div> 
            <ul>
                <li v-for="(item, index) in files_added" class="">
                    + {{ item }} 
                </li>
            </ul>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        data() {
            return {
                files_added: [],
                progress: 0
            }
        },
        created() {    
            window.Echo.private('App.Models.User.' + this.user_id).
                listen('UploadStatus', (e) => {
                    this.files_added.push(e.file);
                    this.progress = e.status;
                    console.log(this.progress);
                })

        }
    }
</script>
<style>
.progress-bar {
    height:24px;
    width: v-bind(progress + "%"); 
    background: black
}
</style>

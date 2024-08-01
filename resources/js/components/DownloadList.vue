<template>
    
    <div class="container" style="width:50%; display: inline-block; padding: 5px; overflow:scroll; height:200px;">
        <h1>Uploaded</h1>
        <div class="row justify-content-center">
            <div  v-for="(item, index) in files" class="card-body">
                - {{ item }} 
            </div>
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
                files: [],
                files_added: [],
                count: 0
            }
        },
        created() {    
            window.Echo.channel('upload').
                listen('UploadStatus', (e) => {
                    this.files_added.push(e.file);
                });
        }
    }
</script>

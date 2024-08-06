<template>
    <div style="width:100%; display: inline-block;padding: 5px; overflow:scroll; height:200px;">
        <h1>Uploaded</h1>  
            <ul>
                <li v-for="(item, index) in files_added" class="card-body">
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

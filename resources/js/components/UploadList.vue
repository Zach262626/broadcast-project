<template>
    <div style="width:100%; display: inline-block;padding: 5px; overflow:scroll; height:200px;">
        <h1>List of Complete upload</h1>  
            <ul>
                <li v-for="(item, index) in files" class="card-body">
                    {{ index  }} - {{ item }} 
                </li>
                <li v-for="(item, index) in files_added" class="card-body">
                    + {{ item }} 
                </li>
            </ul>
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
                })

        },
        methods: {
            
            updateFiles: function() {
                axios.post('/show/files')
                .then(function (response) {
                    this.files = response.data;
                }.bind(this))
            }
        },
        mounted() {
            this.updateFiles();
        },
    }
</script>

<template>
    <hr>
    <h1>List of Complete upload</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    
                    <div  v-for="(item, index) in files" class="card-body">
                        {{ index  }} - {{ item }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                files: [],
                count: 0
            }
        },
        created() {    
            window.Echo.channel('test').
                listen('FileStatus', (e) => {
                    this.files.push(e.file);
                });
        }
    }
</script>

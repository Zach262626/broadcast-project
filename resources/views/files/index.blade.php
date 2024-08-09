<x-layout>
    <div>
        <form action="/download-multiple" method="POST">
            <input type='hidden' value="{{ csrf_token() }}" name='_token' id='_token'>
            @csrf
            @foreach ($files as $file)
                <input type="checkbox" name="files[]" class="checkbox" value="{{ $file->id }}">{{ $file->name }}<br>
            @endforeach
            <button class="btn btn-light border" onClick="downloadFiles()" type="button">Download Selected</button>
        </form>
        <button onClick="checkAll()" class="btn btn-success border mt-1">Check All</button>
        <button onClick="uncheckAll()" class="btn btn-danger border mt-1">Uncheck</button>
        <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/">Home</a></div>
        <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/upload">upload</a></div>
    </div>

</x-layout>
<script>
    function uncheckAll() {
        document.getElementsByName('files[]').forEach(element => {
            element.checked = false;
        });;
    }

    function checkAll() {
        document.getElementsByName('files[]').forEach(element => {
            element.checked = true;
        });;
    }

    function downloadFiles() {
        let files = [];
        let _token = $('#_token').val();
        document.getElementsByName('files[]').forEach(element => {
            if (element.checked == true) {
                files.push(element);
            }
        });
        var postData = JSON.stringify({
            files: files,
            _token: _token
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('download-multiple') }}",
            data: postData,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(results) {
                console.log(results)
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    }
</script>

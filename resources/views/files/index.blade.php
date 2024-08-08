<x-layout>
    <div>
        <form action="/download-multiple" method="POST">
            @csrf
            @foreach ($files as $file)
                <input  type="checkbox" name="files[]" class="checkbox" value="{{ $file->id }}">{{ $file->name }}<br>
            @endforeach
            <button class="btn btn-light border" type="submit">Download Selected</button>
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
</script>
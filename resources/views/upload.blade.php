<x-layout>
    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple>
        <button type="submit">Upload</button>
        <h3><a href="/">Home</a><h3>
        <h3><a href="/download">download</a><h3>
    </form>
</x-layout>

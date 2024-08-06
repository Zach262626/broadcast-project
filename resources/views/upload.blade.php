<x-layout>
    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input  type="file" name="files[]" multiple>
        <button class="button"  type="submit">Upload</button>
    </form>
    <div class="mt-5"><a class="button" href="/">Home</a></div>
    <div class="mt-5"><a class="button" href="/download">download</a></div>
</x-layout>

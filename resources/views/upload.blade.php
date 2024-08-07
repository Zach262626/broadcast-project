<x-layout>
    <form action="/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="border p-2"  type="file" name="files[]" multiple>
        <button class="btn btn-dark border py-2"  type="submit">Upload</button>
    </form>
    <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/">Home</a></div>
    <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/download">download</a></div>
</x-layout>

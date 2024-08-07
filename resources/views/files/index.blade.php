<x-layout>
    <div>
        <form action="/download-multiple" method="POST">
            @csrf
            @foreach ($files as $file)
                <input  type="checkbox" name="files[]" value="{{ $file->id }}">{{ $file->name }}<br>
            @endforeach
            <button class="btn btn-light border" type="submit">Download Selected</button>
            <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/">Home</a></div>
            <div class="mt-2"><a type="button" class="btn btn-dark border mt-1" href="/upload">upload</a></div>
        </form>
    </div>
</x-layout>

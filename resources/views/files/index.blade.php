<x-layout>
    <div>
        <form action="/download-multiple" method="POST">
            @csrf
            @foreach ($files as $file)
                <input type="checkbox" name="files[]" value="{{ $file->id }}">{{ $file->name }}<br>
            @endforeach
            <button type="submit">Download Selected</button>
            <h3><a href="/">Home</a><h3>
            <h3><a href="/upload">upload</a><h3>
        </form>
    </div>
</x-layout>

<x-layout>
    <div>
        <form method="POST" action="/login">
            @csrf
            <input type="text" name="username" id="username">
            <button class="btn btn-dark border" type="submit">login</button>
        </form>
        <a type="button" class="btn btn-dark border mt-1" href="/">Home</a>
    </div>
</x-layout>
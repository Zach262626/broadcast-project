<x-layout>
    <div style="color: black;">
        <form method="POST" action="/login">
            @csrf
            <input type="text" name="username" id="username">
            <button type="submit">login</button>
        </form>
        <h3><a href="/">Home</a><h3>
    </div>
</x-layout>
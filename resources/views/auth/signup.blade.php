<x-layout>
    <div style="color: black;">
        <form method="POST" action="/signup">
            @csrf
            <input type="text" name="username" id="username">
            <button type="submit">signup</button>
        </form>
        <h3><a href="/">Home</a><h3>
    </div>
</x-layout> 
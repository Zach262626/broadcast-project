<x-layout>

    @auth
        <h3>Logged in: <strong>{{ auth()->user()->name }}</strong></h3>
        <section class="container">
            <div class="row mt-3">
                <div class="col-lg-4 col-md-6 my-1">
                    <a href="/logout" type="button" class="btn btn-light w-100">
                        <h2 class="">Logout</h2>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 my-1">
                    <a href="/upload" type="button" class="btn btn-light w-100">
                        <h2 class="">Upload Files</h2>
                    </a>
                </div>
                <div class="col-lg-4 my-1">
                    <a href="/download" type="button" class="btn btn-light w-100">
                        <h2 class="">Download Files</h2>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="my-1">
                    <a href="/files/export_page" type="button" class="btn btn-light w-100">
                        <h2 class="">Excel Export</h2>
                    </a>
                </div>
                {{-- <div class="col-md-6 my-1">
                    <a href="/files/export_page" type="button" class="btn btn-light w-100">
                        <h2 class="">Import</h2>
                    </a>
                </div>
                <div class="col-md-6 my-1">
                    <a href="/files/export_page" type="button" class="btn btn-light w-100">
                        <h2 class="">Export</h2>
                    </a>
                </div> --}}
            </div>

        @endauth
        @guest
            <div class="container">
                <div class="p-1">
                    <a href="/login" type="button" class="w-100 btn btn-light">
                        <h2 class="">Login</h2>
                    </a>
                </div>
                <div class="p-1">
                    <a href="/signup" type="button" class="w-100 btn btn-light">
                        <h2 class="">Create Account</h2>
                    </a>
                </div>
            </div>
        </section>
    @endguest

    {{-- <form action="/test" method="POST" style="color: black">
        @csrf
        <input type="text" name="text" value="text">
    </form> --}}
</x-layout>

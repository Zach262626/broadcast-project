<x-layout>

        @auth
        Logged in: {{ auth()->user()->name  }}
        <section class="container">
            <div class="row">
                <div class="col-4">
                    <a href="/logout" type="button" class="btn btn-light">
                        <h2 class="">Logout</h2></a>
                </div>
                <div class="col-4 ">
                    <a href="/upload" type="button" class="btn btn-light">
                        <h2 class="">Upload Files</h2>
                    </a>
                </div>
                <div class="col-4">
                    <a  href="/download" type="button" class="btn btn-light">
                        <h2 class="">Download Files</h2></a>
                </div>
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
                    <a  href="/signup" type="button" class="w-100 btn btn-light">
                        <h2 class="">Create Account</h2></a>
                </div>
            </div>
        </section>
        @endguest

    {{-- <form action="/test" method="POST" style="color: black">
        @csrf
        <input type="text" name="text" value="text">
    </form> --}}
</x-layout>
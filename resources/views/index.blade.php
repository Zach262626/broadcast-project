<x-layout>

        @auth
        <h3>Logged in: <strong>{{ auth()->user()->name  }}</strong></h3>
        <section class="container">
            <div class="row mt-3">
                <div class="col-lg-4 col-md-6 my-1">
                    <a href="/logout" type="button" class="btn btn-light w-100">
                        <h2 class="">Logout</h2></a>
                </div>
                <div class="col-lg-4 col-md-6 my-1">
                    <a href="/upload" type="button" class="btn btn-light w-100">
                        <h2 class="">Upload Files</h2>
                    </a>
                </div>
                <div class="col-lg-4 my-1">
                    <a  href="/download" type="button" class="btn btn-light w-100">
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
    @auth
    <div class="container mt-5" id="log"> 
        <div class="px-4 border border-3">
            <div class="d-flex align-items-center justify-content-center py-2 border-bottom border-white">Logs</div>
            <div style="height: 300px;" class="overflow-auto">
                <div class="h-100">
                    <log-body
                    user_id = "{{ auth()->user()->id }}"
                    _token = "{{ csrf_token() }}"
                    old_log_route = "{{ route('update-file-log') }}"
                    new_log_route = "{{ route('old-logs') }}"
                    ></log-body>
                </div>
            </div>
        <div>
    </div>
    @endauth
</x-layout>

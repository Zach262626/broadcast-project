<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/js/app.js'])
    {{-- Styles --}}
    @vite(['resources/css/style.css'])
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

</head>

<body class="bg-dark text-white">
    <div class="container" id="app">
        @auth
            <div class="toast-container top-0 end-0 position-absolute">
                <counter-alert user_id="{{ auth()->user()->id }}" _token = "{{ csrf_token() }}"
                    delete_counter = "{{ route('delete_counter') }}"
                    counter_status_route = "{{ route('counter_status_route') }}">
                </counter-alert>
                <upload-alert user_id="{{ auth()->user()->id }}"></upload-alert>
                <form action="{{ route('download') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <download-alert user_id="{{ auth()->user()->id }}"></download-alert>
                </form>
            </div>
        @endauth
        <main class="mt-5 p-4 border border-3">
            {{ $slot }}
        </main>
        @auth
            <div class="container mt-5" id="log">
                <div class="px-4 border border-3">
                    <div class="d-flex align-items-center justify-content-center py-2 border-bottom border-white">Logs</div>
                    <div style="height: 300px;" class="overflow-auto">
                        <div class="h-100">
                            <form action="{{ route('download') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <log-body user_id = "{{ auth()->user()->id }}" _token = "{{ csrf_token() }}"
                                    old_log_route = "{{ route('update-file-log') }}"
                                    new_log_route = "{{ route('old-logs') }}"></log-body>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @auth
            <section>
                <counter-component user_id="{{ auth()->user()->id }}" _token = "{{ csrf_token() }}"
                    counter_status_route = "{{ route('counter_status_route') }}"
                    start_counter = "{{ route('start_counter') }}">
                </counter-component>
            </section>
        @endauth
    <div>
</body>

</html>

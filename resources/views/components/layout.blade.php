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
    <style>
    </style>
</head>

<body class="bg-dark text-white">
    <a href="/test" class="btn btn-light border">Test Page</a>
    <div class="container" id="app">
        @auth
            <div class="toast-container">
                <counter-alert user_id="{{ auth()->user()->id }}" _token = "{{ csrf_token() }}"
                    delete_counter = "{{ route('delete_counter') }}"
                    counter_status_route = "{{ route('counter_status_route') }}">
                </counter-alert>
                <upload-alert user_id="{{ auth()->user()->id }}"></upload-alert>
                    <download-alert _token = "{{ csrf_token() }}"
                        download_zip_delete = "{{ route('download_zip_delete') }}"
                        download_status = "{{ route('download_status') }}" user_id="{{ auth()->user()->id }}"
                        download_route = "{{ route('download') }}">
                    </download-alert>
            </div>
        @endauth
        <main class="mt-5 p-4 border border-3">
            {{ $slot }}
        </main>
        @auth
            <log-body 
                user_id = "{{ auth()->user()->id }}"
                 _token = "{{ csrf_token() }}"
                old_log_route = "{{ route('update-file-log') }}"
                new_log_route = "{{ route('old-logs') }}">
            </log-body>
        @endauth
        @auth
            <section class="collapse">
                <counter-component 
                    user_id="{{ auth()->user()->id }}" 
                    _token = "{{ csrf_token() }}"
                    counter_status_route = "{{ route('counter_status_route') }}"
                    start_counter = "{{ route('start_counter') }}">
                </counter-component>
            </section>
        @endauth
        <div>
</body>

</html>

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
        <form action="{{ route('start-counter') }}" method="POST">
            @csrf
            <counter-component user_id="{{ auth()->user()->id }}"></counter-component>
        </form>
        @endauth
    </div>
</body>
</html>

@extends('components.layout')
@section('content')
    <div>
        <form method="POST" action="/signup">
            @csrf
            <input type="text" name="username" id="username">
            <button class="btn btn-dark border" type="submit">signup</button>
        </form>
        <a type="button" class="btn btn-dark border mt-1" href="/">Home</a>
    </div>
@endsection

@extends('components.layout')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-12">
        <a href="/" class="btn btn-dark border border-light  w-100">Home</a>
    </div>
    </div>
    <div class="row mt-2">
    <div class="col-6">
        <a onClick="exportJobFiles()" class="btn btn-light  w-100">Export files Using Job</a>
    </div>
    <div class="col-6">
        <a onClick="exportFiles()" class="btn btn-light  w-100">Export  files Using Export </a>
        <p class="text-center" style="font-size: 11px">Will only export the first 1000 files</p>
    </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function exportJobFiles() {
    $.ajax({
        url: "{{ route('export-files-job') }}",
        type: 'GET',
        success: function (results) {
            console.log(results)
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
}
function exportFiles() {
    $.ajax({
        url: "{{ route('export-files') }}",
        type: 'GET',
        success: function (results) {
            console.log(results)
        },
        error: function (error) {
            console.log(JSON.stringify(error));
        }
    });
}
</script>
@endpush


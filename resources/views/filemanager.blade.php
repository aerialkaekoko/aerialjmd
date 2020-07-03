@extends('layouts.admin')



@section('content')
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush
    <div class="container">
        <div style="height: 600px;">
          <div id="fm"></div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush
@endsection


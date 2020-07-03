@extends('layouts.admin')

@section('content')
@can('setting')

@include('app_settings::_settings')

@endcan


@endsection
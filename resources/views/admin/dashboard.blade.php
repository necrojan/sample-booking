@extends('layouts.admin')

@section('content')
    <dashboard-manager user-id="{{ auth()->id() }}"></dashboard-manager>
@endsection

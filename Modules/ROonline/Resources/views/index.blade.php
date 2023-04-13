@extends('roonline::layouts.default_layout')
@section('title', 'Dashboard')
@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('roonline.name') !!}
    </p>
@endsection
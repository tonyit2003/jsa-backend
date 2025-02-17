@extends('adminmodule::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('adminmodule.name') !!}</p>
@endsection

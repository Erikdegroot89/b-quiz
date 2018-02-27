
@extends('layouts.default')

@section('title', 'Page Title')

@section('top')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>
@endsection

@extends('layouts.quiz')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>{{ $quiz->name }}</h1>
@endsection

@section('content')
    {{ $quiz->outro }}

@endsection

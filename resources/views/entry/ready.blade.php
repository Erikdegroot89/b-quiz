
@extends('layouts.default')

@section('title', $quiz->name)

@section('top')
    @parent
    <h1>Welkom {{ $player->name }}</h1>
@endsection

@section('content')
    <div class="title m-b-md">Je speelt voor {{$team->name}}</div>
    <a class="nextButton" href="{{ route('quiz.start', $quiz) }}">Start &rarr;</a>

@endsection

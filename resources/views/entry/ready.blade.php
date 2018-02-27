
@extends('layouts.default')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>Welkom {{ $player->name }}</h1>
@endsection

@section('content')
    <div class="title m-b-md">Je speelt voor {{$team->name}}</div>
    <a href="{{ route('quiz.start', $team->quiz_id) }}">Start &rarr;</a>

@endsection

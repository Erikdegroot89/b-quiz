
@extends('layouts.default')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>Kies een Quiz</h1>
@endsection

@section('content')
    <div class="title m-b-md">Quizzes</div>
    @foreach($quizzes as $quiz)
        <div class="quiz">
            <a href="{{ route('entry.team', $quiz->id) }}"><h2>{{$quiz->name}}</h2></a>
            <section role="content">
            {{$quiz->body}}
            </section>
            @if($quiz->image_url)
            <section role="image">
                <img src="{{$quiz->image_url}}"/>
            </section>
            @endif
        </div>
    @endforeach
@endsection
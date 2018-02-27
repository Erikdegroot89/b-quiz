
@extends('layouts.quiz')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>{{ $quiz->name }}</h1>
@endsection

@section('content')
    <div>
        {!!   $quiz->intro !!}
    </div>
    <p>Er zijn {!! $questions->count() !!} Vragen.</p>
    @if($questions->count() > 0)
        Je team is bij vraag {{$activeQuestion->sort_order + 1}}
    <a href="{{ route('quiz.question', $activeQuestion->id) }}">Ga naar Vraag {{$activeQuestion->sort_order + 1}} &rarr;</a>
    @endif
@endsection

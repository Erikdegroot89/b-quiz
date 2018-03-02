@extends('layouts.quiz')

@section('title', 'Page Title')

@section('top')
    @parent


@endsection

@section('content')
    <div>
        {!!   $quiz->intro !!}
    </div>
    <p>Er zijn {!! $questions->count() !!} Vragen.</p>
    @if($questions->count() > 0)
        @if( $teamProgress->answered == $teamProgress->total)
            Je team is al klaar met de quiz!
        @else
            Je team is bij vraag {{$activeQuestion->sort_order + 1}}
        @endif



        <a class="nextButton" href="{{ route('quiz.question', $activeQuestion->id) }}">Ga naar Vraag
            {{$activeQuestion->sort_order + 1}} &rarr;</a>
    @endif
@endsection

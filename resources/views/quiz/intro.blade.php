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
    <p>
    @if($questions->count() > 0)
        @if( $teamProgress->answered == $teamProgress->total)
            Je team is al klaar met de quiz!
        @else
            Je team is bij vraag {{$activeQuestion->sort_order + 1}}
        @endif
    </p>
        <a class=" btn btn-primary btn-raised" href="{{ route('quiz.question', $activeQuestion) }}">
            <i class="material-icons">arrow_forward</i>
        </a>
    @endif
@endsection

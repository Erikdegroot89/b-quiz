
@extends('layouts.quiz')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>{{ $quiz->name }} vraag {{ $question->sort_order + 1 }}</h1>
    <div>
        <h3>{{ $question->body }}</h3>
    </div>
@endsection

@section('content')

    <div>
        @if($hinted)
            <div>
                {{ $question->hint }}
            </div>
        @else
        <form method="get" action="{{ route('quiz.question', $question->id) }}">
            <input type="hidden" name="hint" value="1">
            <input type="submit" value="Hint"/>
        </form>
        @endif
        <form method="post" action="{{ route('quiz.postAnswer', $question->id) }}">
            {{ csrf_field() }}
            <input name="answer"  required/>
            <input type="submit" value="Antwoord insturen"/>
        </form>

    </div>
    @if($answer)
    <div>
        @if($validAnswer)
            <span class="right-answer">{{ $answer }} is het Goede antwoord!</span>
        @else
            <span class="wrong-answer">{{ $answer }} is niet het goede antwoord!</span>
        @endif
    </div>
    @endif
    @if($validAnswer)
        @if($next)
            <a href="{{ route('quiz.question', $next->id) }}">next &rarr;</a>
        @else
            <a href="{{ route('quiz.end', $quiz->id) }}">next &rarr;</a>
        @endif
    @endif
@endsection
@push('script_vars')

@endpush

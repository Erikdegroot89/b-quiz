
@extends('layouts.quiz')

@section('title', 'Page Title')

@section('top')
    @parent
    <h2>vraag {{ $question->sort_order + 1 }}</h2>
    <div>
        <h3>{{ $question->body }}</h3>
    </div>
@endsection

@section('content')

    <div>
        @if($question->hint )
            <div class="hintBox">
            @if($hinted)
                <div>
                    <h4>Hint:</h4>
                </div>
                <div>
                    {{ $question->hint }}
                </div>
            @else
            <form method="get" action="{{ route('quiz.question', $question) }}">
                <input type="hidden" name="hint" value="1">
                <input type="submit" value="Geef me een hint!"/>
            </form>
            @endif
            </div>
        @endif
        <form method="post" action="{{ route('quiz.postAnswer', $question) }}">
            {{ csrf_field() }}
            <input name="answer"  required/>
            <input class="btn btn-primary" type="submit" value="Antwoord insturen"/>
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
            <a class="btn btn-primary btn-raised" href="{{ route('quiz.question', $next) }}">volg &rarr;</a>
        @else
            <a class="btn btn-primary btn-raised" href="{{ route('quiz.end', $quiz) }}">next &rarr;</a>
        @endif
    @endif
@endsection
@push('script_vars')

@endpush

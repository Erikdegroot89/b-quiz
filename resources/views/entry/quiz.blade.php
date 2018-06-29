@extends('layouts.default')

@section('title', !empty($quiz) ? $quiz->name : '')

@section('top')
    @parent
    <h1>Kies een Quiz</h1>
@endsection

@section('content')
    <div class="title m-b-md">Quizzes</div>
    <div class="list-group">
        <a href="{{ route('quiz.create') }}" class="btn"><i class="material-icons">add</i><span>Quiz aanmaken</span></a>
        @foreach($quizzes as $quiz )
            <div class="quiz list-group-item" @if($quiz->image_url) data-bg-image={{$quiz->image_url}} @endif>
                <div class="bmd-list-group-col">
                    <p class="list-group-item-heading" href="{{ route('entry.team', $quiz) }}">{{$quiz->name}}</p>
                    <p class="list-group-item-text">
                        {!! $quiz->description !!}
                    </p>
                </div>
                <a title="Naar quiz" class="btn btn-secondary pull-xs-right" href="{{ route('entry.team', $quiz) }}">
                    <i class="material-icons">arrow_forward</i>
                </a>

            </div>
        @endforeach
    </div>
@endsection
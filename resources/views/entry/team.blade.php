@extends('layouts.default')

@section('title', $quiz->name)

@section('top')
    @parent
    <h1>Kies een Team</h1>
@endsection

@section('content')
    <div class="title m-b-md">Teams</div>
    <ol class="list-group">
        @foreach($teams as $team)
            <li class="list-group-item team" @if($team->image_url) data-bg-image="{{$team->image_url}} @endif">
                <div class="bmd-list-group-col">
                    <p class="list-group-item-heading">{{$team->name}}</p>
                    <p class="list-group-item-text">
                        {{$team->description}}
                    </p>
                </div>
                <a href="{{ route('entry.player', $team) }}" title="Kies dit Team" class="btn pull-xs-right">
                    <i class="material-icons">arrow_forward</i>
                </a>

            </li>
        @endforeach
    </ol>
@endsection

@extends('layouts.default')

@section('title', $quiz->name)

@section('top')
    @parent
@endsection

@section('content')

    <h2>Team "{{ $team->name }}"</h2>
    <div class="players">
        <h3>Kies een van de spelers...</h3>
        <ul class="list-group">
            @foreach($players as $player)
                <li class="list-group-item">
                    {{ $player->name }}
                    <a title="Naar quiz" class="btn btn-secondary pull-xs-right"
                       href="{{ route('entry.ready', $player) }}">
                        <i class="material-icons">arrow_forward</i>
                    </a>
                </li>
            @endforeach

            <li class="list-group-item">
                <form method="post" action="{{ route('player.create'), $team->id }}">
                    <div class="bmd-list-group-col">
                        <p class="list-group-item-heading" >Of, maak een nieuwe speler aan:</p>
                        {{ csrf_field() }}
                        <input type="hidden" name="team_id" value="{{ $team->id }}"/>
                        <label>naam <input name="name" type="text"></label>
                    </div>
                    <input class="btn btn-raised btn-primary pull-xs-right" type="submit" value="aanmaken">
                </form>
            </li>
        </ul>
    </div>
@endsection
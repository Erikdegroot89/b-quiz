
@extends('layouts.default')

@section('title', 'Page Title')

@section('top')
    @parent
@endsection

@section('content')

    <h2>Team {{ $team->name }}</h2>
    <div class="players">
        <ul>
    @foreach($players as $player)
        <li>
            <a href="{{ route('entry.ready', $player->id) }} ">
                {{ $player->name }}
            </a>
        </li>
    @endforeach

            <li>
                <form method="post" action="{{ route('player.create'), $team->id }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="team_id" value="{{ $team->id }}"/>
                    <label>naam <input name="name" type="text"></label>
                    <input type="submit" value="aanmaken">
                </form>
            </li>
        </ul>
    </div>
@endsection
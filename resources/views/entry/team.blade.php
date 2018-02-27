
@extends('layouts.default')

@section('title', 'Page Title')

@section('top')
    @parent
    <h1>Kies een Team</h1>
@endsection

@section('content')
    <div class="title m-b-md">Teams</div>
    @foreach($teams as $team)
        <div class="team">
        <a href="{{ route('entry.player', $team->id) }}"><h2>{{$team->name}}</h2></a>
        <section role="content">
            {{$team->body}}
        </section>
        @if($team->image_url)
            <section role="image">
                <img src="{{$team->image_url}}"/>
            </section>
        @endif
        </div>
    @endforeach
@endsection

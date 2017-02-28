@extends('master.master')

@section('content')
    <div class="ui card" style="margin:auto;">

        <div class="content">

            <img class="right floated tiny ui image" src="{{ $user->avatar }}">
            <div class="header" style="margin-top:10px;">
                {{$user->name}}
            </div>
            <div class="meta">
                {{$user->nickname}}
            </div>
            <div class="meta">
                Follwing cost: @plan($user->plan)
            </div>
        </div>

        <a href="https://instagram.com/{{$user->nickname}}" class="ui bottom attached button">Go to profile</a>
    </div>
    <div style="margin-top:60px;text-align:center;">
        <a href="/" style="color:grey">Monetize your own account...</a>
    </div>
@endsection

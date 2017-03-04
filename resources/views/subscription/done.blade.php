@extends('master.master')

@section('content')
    <div class="ui segments">
        <div class="ui segment">
            <h2>{{count($pending)}} pending subscriptions</h2>
        </div>
        @foreach ($pending as $key => $value)
            <div class="ui stacked segment">
              <p>{{ $value->user->username }} - Approving your follow request.<button class="ui basic loading button" style="box-shadow: none;"></button></p>
              <p><a href="https://www.instagram.com/{{$value->user->username}}">Go to {{$value->user->username}} profile</a></p>
            </div>
        @endforeach
    </div>
    <div style="margin-top:60px;text-align:center;">
        <a href="/" style="color:grey">Monetize your own account...</a>
    </div>
@endsection

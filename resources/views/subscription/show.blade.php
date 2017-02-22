@extends('master.master')

@section('content')
  <div class="ui card" style="margin:auto">
    <div class="image">
      <img src="{{ $user->avatar }}">
    </div>
    <div class="content">
      <a class="header">{{$user->nickname}}</a>
      <div class="meta">
        <span class="date">{{$user->name}}</span>
      </div>
    </div>
    <div class="extra content">
      @if($user->plan && $user->account_id)
        <a class="ui button primary" href="{{ route('subscriptions.create', $user->nickname)}}">@include('subscription.follow')</a>
      @else
        <div>Following {{ $user->nickname }} is not available</div>
      @endif
    </div>
  </div>
@endsection

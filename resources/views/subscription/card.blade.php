@extends('master.master')

@section('content')
  <div style="padding-top:20px">


    <div class="ui card" style="margin:auto;">
      <div class="image">
        @if($following)
          <div class="ui green ribbon label">
            <i class="check icon"></i> Already following
          </div>
        @elseif($public)
          <div class="ui green ribbon label">
            <i class="check icon"></i> Profile is public
          </div>
        @endif
        <img src="{{ $user->avatar }}">
      </div>
      <div class="content">
        @if($public)
          <a href="https://instagram.com/{{$user->nickname}}" class="header">{{$user->nickname}}</a>
        @else
          <div class="header">{{$user->nickname}}</div>
        @endif
        <div class="meta">
          <span class="date">{{$user->name}}</span>
        </div>
      </div>
      @if (!$following && !$public)
        @if($user->plan && $user->account_id)
          @if(Auth::check())
            @if(Auth::user()->customer_id)
              <form action="{{ route('subscriptions.store', $user->nickname)}}" method="POST" class="ui bottom attached button primary">
                {{ csrf_field() }}
                <button type="submit" class="ui button primary onloading">@include('subscription.follow')</button>
              </form>
            @else
              <div class="extra content">
                  <form action="{{ route('subscriptions.store', $user->nickname)}}" method="POST" class="">
                    {{ csrf_field() }}
                <a href="https://twitter.com/intent/tweet?button_hashtag=estelastreaming" class="twitter-hashtag-button" data-related="eStelaStreaming">Tweet #estelastreaming</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                <input type="submit" name="" value="">
                </form>
              </div>
            @endif
          @else
            <a class="ui bottom attached button primary"
              href="{{ route('subscriptions.create', $user->nickname)}}">Accept the challenge to get access</a>
          @endif
        @else
          <div class="extra content">
            <div>Following {{ $user->nickname }} is not available</div>
          </div>
        @endif
      @else
        <a href="https://instagram.com/{{$user->nickname}}" class="ui bottom attached button">Go to profile</a>
      @endif
    </div>
  </div>
@endsection

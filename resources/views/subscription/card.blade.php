@extends('master.master')

@section('content')
    <div class="ui card" style="margin:auto">
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
                            <form action="{{ route('subscriptions.store', $user->nickname)}}" method="POST">
                                {{ csrf_field() }}
                                <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ config('services.stripe.key') }}"
                                data-amount="{{config('plans.' . $user->plan)}}"
                                data-name="Follow {{ $user->nickname }}"
                                data-description="Monthly subscription"
                                data-email="{{ $user->email }}"
                                data-image="{{ $user->avatar }}"
                                data-locale="auto"
                                data-zip-code="false"
                                data-label="@include('subscription.follow')"
                                data-allow-remember-me="false">
                                </script>
                            </form>
                        </div>
                    @endif
                @else
                    <a class="ui bottom attached button primary" href="{{ route('subscriptions.create', $user->nickname)}}">@include('subscription.follow')</a>
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
@endsection

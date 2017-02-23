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
        <div class="extra content">
            @if(!$following && !$public)
                @if($user->plan)
                    @if(Auth::user()->customer_id)
                        <form action="{{ route('subscriptions.store', $user->nickname)}}" method="POST">
                            {{ csrf_field() }}
                            <input type="submit" name="" value="@include('subscription.follow')" class="ui button primary">
                        </form>
                    @else
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
                    @endif
                @else
                    <div>Following {{ $user->nickname }} is not available</div>
                @endif
            @else
                <a href="https://instagram.com/{{$user->nickname}}" class="ui button primary">Go to profile</a>
            @endif
        </div>
    </div>
@endsection

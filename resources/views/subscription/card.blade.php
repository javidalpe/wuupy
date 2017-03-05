@extends('master.master')

@section('content')
    <div class="ui card" style="margin:auto;">

        <div class="content">
            @if($following)
                <div class="ui green ribbon label">
                    <i class="check icon"></i> Following accepted
                </div>
            @elseif($public)
                <div class="ui orange ribbon label">
                    <i class="exclamation icon"></i> Profile is public
                </div>
            @endif

            <div class="header" style="margin-top:10px;">
                {{$user->username}}
            </div>
            @if(!$public)
                <div class="meta">
                    Follwing cost: @plan($user->plan)
                </div>
            @endif
        </div>

        @if (!$following && !$public)
            @if($user->plan && $user->account_id)
                <div class="extra content">
                    <form class="ui form" action="{{ route('subscriptions.store', $user->username)}}" method="POST">
                        {{ csrf_field() }}

                        <input type="hidden" name="stripeToken" value="" id="token">
                        <input type="hidden" name="stripeEmail" value="" id="email">

                        @if(Auth::guest())
                            <div class="field">
                                <label>Your Instagram username</label>
                                <input type="text" name="username" placeholder="username" required autocorrect="off" autocapitalize="none">
                            </div>
                        @endif
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" tabindex="0" required>
                                <label>I agree to the <a href="/terms">Terms and Conditions</a></label>
                            </div>
                        </div>

                        <script src="https://checkout.stripe.com/checkout.js"></script>

                        <button id="customButton" class="ui button primary" type="submit">Subscribe</button>


                        <script>
                        var handler = StripeCheckout.configure({
                            key: '{{ config('services.stripe.key') }}',
                            image: '{{ $user->avatar }}',
                            locale: 'auto',
                            token: function(token) {
                                $('#customButton').addClass("loading");
                                $('#token').val(token.id);
                                $('#email').val(token.email);
                                $('form')[0].submit();
                            }
                        });

                        document.getElementById('customButton').addEventListener('click', function(e) {
                            $('#customButton').addClass("loading");
                            // Open Checkout with further options:
                            handler.open({
                                name: 'Follow {{ $user->username }}',
                                description: 'Monthly subscription',
                                zipCode: false,
                                dataImage: '\img\premy.jpg',
                                amount: {{config('plans.' . $user->plan)}}
                            });
                            e.preventDefault();
                        });

                        // Close Checkout on page navigation:
                        window.addEventListener('popstate', function() {
                            handler.close();
                        });
                        </script>

                    </form>
                </div>
            @else
                <div class="extra content">
                    <div>Following {{ $user->username }} is not available</div>
                </div>
            @endif
        @else
            <a href="https://instagram.com/{{$user->username}}" class="ui bottom attached button">Go to profile</a>
        @endif
    </div>
    <div style="margin-top:60px;text-align:center;">
        <a href="/" style="color:grey">Monetize your own account...</a>
    </div>
@endsection

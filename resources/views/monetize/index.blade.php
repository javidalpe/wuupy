@extends('master.master')

@section('content')

    <strong id="1">1. Select your monthly following cost</strong>
    <small>Users will pay this monthly subscription in order to follow you. You can change it at any time.</small>
    @if($user->plan)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.plan')
    </div>

    <strong id="2">2. Setup your bank account</strong>
    <small>Where you will recieve funds</small>
    @if($account && $account['transfers_enabled'])
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.account')
    </div>

    <strong id="3">3. Go to Instagram and set your account private</strong>
    <small>This prevents from free followers.</small>
    @if($user->private_checked)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.private')
    </div>

    <strong id="4">4. Share your subscriber link</strong>
    <small>This link allow people to pay and follow you.</small>
    <div class="ui segment">
        @include('monetize.copy')
    </div>

    <strong id="5">5. That's all!</strong>
    <small>Sit and relax.</small>
    <div class="ui segment">
        We will manage your followers for you.
    </div>


    <strong>Current followers</strong>

    <div class="ui segments">
        @include('monetize.followers')
    </div>


@endsection

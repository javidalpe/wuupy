@extends('master.master')

@section('content')

    <strong>1. Select your monthly following cost</strong>
    <small>Users will pay this monthly subscription in order to follow you.</small>
    @if($user->plan)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.plan')
    </div>

    <strong>2. Setup your bank account</strong>
    <small>Where you will recieve funds</small>
    @if($account && $account['transfers_enabled'])
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.account')
    </div>

    <strong>3. Set your Instagram account private</strong>
    <small>This prevents from free followers.</small>
    @if($user->private_checked)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.private')
    </div>

    <strong>4. Share your subscriber link</strong>
    <small>This link allow people to pay and follow you.</small>
    <div class="ui segment">
        @include('monetize.copy')
    </div>

    <strong>5. That's all!</strong>
    <small>Sit and relax.</small>
    <div class="ui segment">
        We will manage your followers for you.
    </div>


    <strong>Current followers</strong>

    <div class="ui segments">
        @include('monetize.followers')
    </div>
@endsection

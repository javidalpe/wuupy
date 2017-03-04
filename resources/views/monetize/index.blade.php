@extends('master.master')

@section('content')

    <strong>1. Connect your Instagram account</strong>
    <small>Users will pay this monthly subscription in order to follow you. You can change it at any time.</small>
    @if($user->username)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.connect')
    </div>

    <strong>2. Select your monthly following cost</strong>
    <small>Users will pay this monthly subscription in order to follow you. You can change it at any time.</small>
    @if($user->plan)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.plan')
    </div>

    <strong>3. Setup your bank account</strong>
    <small>Where you will recieve funds</small>
    @if($account && $account['transfers_enabled'])
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.account')
    </div>

    <strong>4. Go to Instagram and set your account private</strong>
    <small>This prevents from free followers.</small>
    @if($user->private_checked)
        @include('master.components.done')
    @endif
    <div class="ui segment {{ $user->username?'':'disabled'}}">
        @include('monetize.private')
    </div>

    <strong>5. That's all! Share your subscriber link</strong>
    <small>This link allows people pay to follow you. We will manage your followers for you.</small>
    <div class="ui segment {{ $user->username?'':'disabled'}}">
        @include('monetize.copy')
    </div>

    <strong>Current followers</strong>

    <div class="ui segments">
        @include('monetize.followers')
    </div>


@endsection

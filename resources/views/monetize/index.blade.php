@extends('master.master')

@section('content')

    <strong id="1">1. Set the follower challenge</strong>
    <small>Users must overcome this challenge in order to follow you.</small>
    @if($user->plan)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.plan')
    </div>

    <strong id="3">2. Go to Instagram and set your account private</strong>
    <small>This prevents from free followers.</small>
    @if($user->private_checked)
        @include('master.components.done')
    @endif
    <div class="ui segment">
        @include('monetize.private')
    </div>

    <strong id="4">3. Share your challenger link</strong>
    <small>This link allow people to accept the challenge.</small>
    <div class="ui segment">
        @include('monetize.copy')
    </div>

    <strong id="5">4. That's all!</strong>
    <small>Sit and relax.</small>
    <div class="ui segment">
        We will manage your followers for you.
    </div>


    <strong>Current followers</strong>

    <div class="ui segments">
        @include('monetize.followers')
    </div>


@endsection

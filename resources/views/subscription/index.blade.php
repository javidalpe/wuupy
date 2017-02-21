@extends('master.master')

@section('content')
    @foreach ($subscriptions as $subscription)
        <div class="ui segment">
            {{$subscription->id}}
        </div>
    @endforeach
@endsection

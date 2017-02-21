@extends('master.master')

@section('content')

  <strong>1. Select your premium account monthly subscription pricing</strong>
  <small>Users must pay this monthly subscription in order to follow you.</small>
  <div class="ui segment">
    @include('monetize.plan')
  </div>

  <strong>2. Setup your bank account</strong>
  <small>Where you will recieve funds</small>
  <div class="ui segment">
    @include('monetize.account')
  </div>

  <strong>3. Set your Instagram account private</strong>
  <small>This prevent from free followers.</small>
  <div class="ui segment">
    <img src="/img/private.jpg" alt="" style="max-height:60px">
  </div>

  <strong>4. Share your subscriber link</strong>
  <small>This link allow people to pay and follow you.</small>
  <div class="ui segment">
    <div class="field">

      <div class="ui action input">
        <input type="text" value="{{ config('app.url') }}/{{ Auth::user()->nickname }}">
        <button class="ui teal right labeled icon button">
          <i class="copy icon"></i>
          Copy
        </button>
      </div>

    </div>
  </div>

  <strong>5. That's all!</strong>
  <small>Sit and relax.</small>
  <div class="ui segment">
    We will manage your followers for you.
  </div>


  <strong>Current subscribers</strong>
  <div class="ui segment">
    0 subscribers
  </div>
@endsection

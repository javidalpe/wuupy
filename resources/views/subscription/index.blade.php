@extends('master.master')

@section('content')
  @if($user->following()->count() <= 0)
    <h2 class="ui center aligned icon header">
      <i class="circular users icon"></i>
      You are not following anyone
    </h2>
  @else
    <strong>You are currently following</strong>

    <table class="ui table unstackable">
      <thead>
        <tr><th>Account</th>
        <th>Following cost</th>
        <th>Since</th>
        <th>Actions</th>
      </tr></thead>
      <tbody>
        @foreach ($user->following()->get() as $celebrity)
        <tr>
          <td>
            <h4 class="ui image header">
              <img src="{{$celebrity->avatar}}" class="ui mini rounded image">
              <div class="content">
                <a href="https://instagram.com/{{$celebrity->username}}">{{$celebrity->username}}</a>
                <div class="sub header">
                  {{$celebrity->name}}
              </div>
            </div>
          </h4></td>
          <td>
              ${{ config('plans.'. $celebrity->pivot->plan)/100 }}/month
          </td>
          <td>
              {{ $celebrity->pivot->created_at }}
          </td>
          <td>
              <form class="" action="{{route('subscriptions.destroy', $celebrity->pivot->id)}}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="submit" name="" value="Unfollow" class="ui button tiny">
              </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  @endif
@endsection

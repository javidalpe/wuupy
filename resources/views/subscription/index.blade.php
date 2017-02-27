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
        <th>Challenge accepted</th>
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
                <a href="https://instagram.com/{{$celebrity->nickname}}">{{$celebrity->nickname}}</a>
                <div class="sub header">
                  {{$celebrity->name}}
              </div>
            </div>
          </h4></td>
          <td>
              Tweet about <a class="ui label">#estelasailing</a></label>
          </td>
          <td>
              {{ $celebrity->pivot->created_at }}
          </td>
          <td>

          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  @endif
@endsection

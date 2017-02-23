@if ($user->followers()->count() > 0)
<table class="ui table unstackable">
  <thead>
    <tr><th>Account</th>
    <th>Following cost</th>
    <th>Since</th>
    <th>Actions</th>
  </tr></thead>
  <tbody>
    @foreach ($user->followers()->get() as $follower)
    <tr>
      <td>
        <h4 class="ui image header">
          <img src="{{$follower->avatar}}" class="ui mini rounded image">
          <div class="content">
            <a href="https://instagram.com/{{$follower->nickname}}">{{$follower->nickname}}</a>
            <div class="sub header">
              {{$follower->name}}
          </div>
        </div>
      </h4></td>
      <td>
          ${{ config('plans.'. $follower->pivot->plan)/100 }}/month
      </td>
      <td>
          {{ $follower->pivot->created_at }}
      </td>
      <td>
          <form class="" action="{{route('subscriptions.destroy', $follower->pivot->id)}}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <input type="submit" name="" value="Block" class="ui button tiny">
          </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@else
    <div class="ui segment">
        0 followers
    </div>
@endif

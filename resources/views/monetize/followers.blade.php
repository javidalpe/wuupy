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
          Tweet about <a class="ui label">#estelasailing</a></label>
      </td>
      <td>
          {{ $follower->pivot->created_at }}
      </td>
      <td>
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

@if ($user->followers()->count() > 0)
<table class="ui table unstackable">
  <thead>
    <tr><th>Account</th>
    <th>Following cost</th>
    <th>Since</th>
    <th>Status</th>
  </tr></thead>
  <tbody>
    @foreach ($user->followers()->get() as $follower)
    <tr>
      <td>
        <h4 class="ui image header">
          <div class="content">
            <a href="https://instagram.com/{{$follower->follower_username }}">{{$follower->follower_username }}</a>
        </div>
      </h4></td>
      <td>
          @plan($follower->plan)
      </td>
      <td>
          {{ $follower->created_at }}
      </td>
      <td>
          @include('master.components.status', ['status' => $follower->status ])
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

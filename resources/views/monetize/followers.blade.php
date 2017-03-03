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
          <div class="content">
            <a href="https://instagram.com/{{$follower->username}}">{{$follower->username}}</a>
            <div class="sub header">
              {{$follower->username}}
          </div>
        </div>
      </h4></td>
      <td>
          @plan($follower->plan)
      </td>
      <td>
          {{ $follower->created_at }}
      </td>
      <td>
          <form class="" action="{{route('subscriptions.destroy', $follower->id)}}" method="post">
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

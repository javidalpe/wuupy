@if (Auth::check())
  <div class="ui stackable menu">
    <div class="ui container">
    <div class="item">
      <img src="{{ Auth::user()->avatar }}">
    </div>
      <a  href="/home" class="item">{{ Auth::user()->name }}</a>
      <a  href="/follow" class="item">Following</a>
    </div>
  </div>
@endif

@if (Auth::check())
  <div class="ui stackable menu">
    <div class="ui container">
    <div class="item">
      <img src="{{ Auth::user()->avatar }}">
    </div>
      <a  href="/home" class="item">{{ Auth::user()->name }}</a>
      <a class="item">Subscriptions</a>
    </div>
  </div>
@endif

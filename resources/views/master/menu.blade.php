<div class="ui container">
    <div class="ui large secondary menu">
        <a class="item logo">Premy</a>
        <div class="right item">
            @if (Auth::check())
              <a href="/home" class="ui inverted button">Home</a>
            @else
              <a href="/login" class="ui inverted button">Log in</a>
            @endif
        </div>
    </div>
</div>

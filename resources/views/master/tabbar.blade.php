@if (Auth::check())
    <div class="ui top menu">
        <div class="ui container">
            <div class="item">
                <img class="ui mini circular image" src="{{ Auth::user()->avatar }}">
            </div>
            <a  href="/home" class="item">{{ Auth::user()->nickname }}</a>
            @if (Auth::user()->following()->count() > 0)
              <a  href="/follow" class="item">Following</a>
            @endif
            <div class="right menu">
                <div class="item">
                    <form action="/logout" class="ui form" method="post">
                        {{ csrf_field() }}
                        <button type="submit" class="ui button tiny">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

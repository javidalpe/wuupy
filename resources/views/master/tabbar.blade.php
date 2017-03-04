@if (Auth::check())
    <div class="ui top menu">
        <div class="ui container">

            @if (Auth::user()->username )
                <a  href="/home" class="item">{{ Auth::user()->username }}</a>
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
@else
    <div style="padding-top:20px;"></div>
@endif

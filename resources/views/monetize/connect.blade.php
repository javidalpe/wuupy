@if($user->username)
    Connected as: {{$user->username}}
    <form class="ui form" action="{{ route('instagram.disconnect') }}" method="post">
        {{ csrf_field() }}
        @include('master.components.submit',['class' => '', 'label' => 'Unlink'])
    </form>

@else
    <a href="javascript:$('.ui.modal').modal('show');" class="ui button primary"><i class="linkify icon"></i> Log in with Instagram</a>


    <div class="ui modal">
        <i class="close icon"></i>

        <div class="content">
            <div class="description">
                <div class="logo"></div>
                <form class="ui form" action="{{ route('instagram.connect') }}" method="post">
                    {{ csrf_field() }}
                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="pass" placeholder="Password">
                    </div>
                        @include('master.components.submit',['class' => 'primary', 'label' => 'Log in'])
                </form>
            </div>
        </div>
    </div>
@endif


@section('styles')
<style>
.logo {
    background-image: url(/img/instagram.png);
    background-repeat: no-repeat;
    background-position: 0 0;
    height: 51px;
    width: 175px;
}
</style>
@endsection

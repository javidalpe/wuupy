@if($user->username)
    Connected as: {{$user->username}}
@else
    <a href="javascript:$('.ui.modal').modal('show');" class="ui button primary">Connect Instagram Account</a>


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
                        @include('master.components.submit',['class' => 'primary', 'label' => 'Connect'])
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

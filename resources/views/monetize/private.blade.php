<div data-tooltip="Find it at Profile -> Options -> Account">

    <form class="ui form" action={{ route('instagram.check')}} method="post" style="overflow:hidden">
        {{ csrf_field() }}
        <div class="field">
            @if ($user->private_checked)
                @include('master.components.submit',['class' => 'tiny', 'label' => 'Check again'])
            @else
                <img src="/img/private.jpg" alt="" style="max-height:60px">
                <div class="field">
                    @include('master.components.submit',['class' => 'blue small', 'label' => 'Check my privacy settings'])
                </div>
            @endif
        </div>
    </form>
</div>

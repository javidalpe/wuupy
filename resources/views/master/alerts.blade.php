@if (session('error'))
    @include('master.alerts.error', ['msg' => session('error') ])
@endif

@if (session('positive'))
    <div class="ui positive message">
        <div class="header">Done!</div>
        <p>{{ session('positive') }}</p>
    </div>
@endif

@if (session('info'))
    <div class="ui info message">
        <p>{{ session('info') }}</p>
    </div>
@endif

@if (session('warning'))
    @include('master.alerts.error', ['msg' => session('warning') ])
@endif

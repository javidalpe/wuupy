@if (session('error'))
  <div class="ui container">
    <div class="ui negative message">
      <div class="header">Error</div>
      <p>{{ session('error') }}</p>
    </div>
  </div>
@endif

@if (session('positive'))
  <div class="ui container">
    <div class="ui positive message">
      <div class="header">¡Hecho!</div>
      <p>{{ session('positive') }}</p>
    </div>
  </div>
@endif

@if (session('info'))
  <div class="ui container">
    <div class="ui info message">
      <p>{{ session('info') }}</p>
    </div>
  </div>
@endif

@if (session('warning'))
  <div class="ui container">
    <div class="ui warning message">
      <div class="header">Atención:</div>
      <p>{{ session('warning') }}</p>
    </div>
  </div>
@endif

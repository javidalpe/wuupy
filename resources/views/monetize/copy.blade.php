<div class="field">

    <div class="ui action input">
        <input id="foo" type="text" value="{{route('subscriptions.show', $user->username) }}" {{ $user->username?'':'disabled'}}>
        <button class="ui blue right labeled icon button copy-button" data-clipboard-target="#foo" {{ $user->username?'':'disabled'}}>
            <i class="copy icon" data-content="Copied!"></i>
            Copy
        </button>
    </div>

</div>

@push('scripts')
  <script src="/js/clipboard.min.js" charset="utf-8"></script>
  <script type="text/javascript">
  var clipboard = new Clipboard('.copy-button');

  clipboard.on('success', function(e) {
    $('.copy.icon').popup('show');
  });
  </script>
@endpush

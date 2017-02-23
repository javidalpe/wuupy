<div class="field">

    <div class="ui action input">
        <input id="foo" type="text" value="{{route('subscriptions.show', $user->nickname) }}">
        <button class="ui blue right labeled icon button" data-clipboard-target="#foo">
            <i class="copy icon"></i>
            Copy
        </button>
    </div>

</div>

<script src="/js/clipboard.min.js" charset="utf-8"></script>

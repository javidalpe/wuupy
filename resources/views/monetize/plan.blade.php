<form class="ui form" action={{ route('plan.store')}} method="post">
  {{ csrf_field() }}
  <div class="grouped fields">
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="plan" value="one" {{ Auth::user()->plan == "one" ? 'checked' : 'Default' }}>
        <label>$0,99/month</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="plan" value="five" {{ Auth::user()->plan == "five" ? 'checked' : '' }}>
        <label>$4,99/month</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="plan" value="ten" {{ Auth::user()->plan == "ten" ? 'checked' : '' }}>
        <label>$9,99/month</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="plan" value="twenty" {{ Auth::user()->plan == "twenty" ? 'checked' : '' }}>
        <label>$19,99/month</label>
      </div>
    </div>
    <div class="field">
      @if (isset(Auth::user()->plan))
        <input type="submit" name="" value="Update" class="ui button tiny">
      @else
        <input type="submit" name="" value="Set" class="ui button teal small">
      @endif
    </div>
  </div>
</form>

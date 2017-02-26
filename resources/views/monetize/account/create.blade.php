
<form class="ui form" action={{ route('account.store')}} method="post">
  {{ csrf_field() }}

  <div class="fields">
    <div class="five wide field required">
      <label>Your account type</label>
      <div class="grouped fields">
        <div class="field">
          <div class="ui radio checkbox">
            <input type="radio" name="type" value="individual" required>
            <label>Individual/Sole proprietorship</label>
          </div>
        </div>
        <div class="field">
          <div class="ui radio checkbox">
            <input type="radio" name="type" value="company">
            <label>Corporation</label>
          </div>
        </div>
      </div>
    </div>

    <div class="seven wide field required">
      <label>Where are you based?</label>
      <small>Where the account representative lives or the business is legally established.</small>
      <select name="country" class="ui search dropdown">
        <option value="US">United States</option>
        <option value="AU">Australia</option>
        <option value="CA">Canada</option>
        <option value="DK">Denmark</option>
        <option value="FI">Finland</option>
        <option value="FR">France</option>
        <option value="IE">Ireland</option>
        <option value="JP">Japan</option>
        <option value="NO">Norway</option>
        <option value="SG">Singapore</option>
        <option value="ES">Spain</option>
        <option value="SE">Sweden</option>
        <option value="UK">United Kingdom</option>
      </select>
    </div>
  </div>

  <h5>Legal name and Date of birth</h5>
  <div class="fields">
    <div class="four wide field required ">
      <label>First name</label>
      <input type="text" name="first_name" required placeholder='First'>
    </div>
    <div class="four wide field required">
      <label>Last name</label>
      <input type="text" name="last_name"  required placeholder='Last'>
    </div>
    <div class="two wide field required">
      <label>Day</label>
      <input type="text" name="day" required placeholder='DD'>
    </div>
    <div class="two wide field required">
      <label>Month</label>
      <input type="text" name="month"  required placeholder='MM'>
    </div>
    <div class="two wide field required">
      <label>Year</label>
      <input type="text" name="year"  required placeholder='YYYY'>
    </div>
  </div>

  <div class="ui field">
    <small for="">By registering your account, you agree to our <a target="_blank" href="/terms">Services Agreement</a> and the <a target="_blank" href="https://stripe.com/connect-account/legal">Stripe Connected Account Agreement</a>.</small>
  </div>
  <div class="ui field">
    @include('master.components.submit',['class' => 'blue small', 'label' => 'Activate account'])
  </div>

</form>

@push('scripts')
  <script type="text/javascript">
  $('.ui.accordion').accordion();
  </script>
@endpush

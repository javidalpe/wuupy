
<form class="ui form" action={{ route('account.store')}} method="post">
  {{ csrf_field() }}

  <div class="grouped fields">
    <label>Account type</label>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="type" value="individual">
        <label>Individual</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="type" value="company">
        <label>Company</label>
      </div>
    </div>
  </div>

  <div class="ui form">
    <div class="field">
      <label>Country</label>
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

    <div class="ui field">
      <div class="ui accordion">
        <div class="title">
          <label>By clicking set you accept the <a href="#">Terms of Service</a></label>
        </div>
        <div class="content">
          <p>Payment processing services for [account holder term, e.g. drivers or sellers] on [platform name] are provided by Stripe and are subject to the <a href="https://stripe.com/connect-account/legal">Stripe Connected Account Agreement</a>, which includes the <a href="https://stripe.com/legal">Stripe Terms of Service</a> (collectively, the “Stripe Services Agreement”). By agreeing to [this agreement / these terms / etc.] or continuing to operate as a [account holder term] on [platform name], you agree to be bound by the Stripe Services Agreement, as the same may be modified by Stripe from time to time. As a condition of [platform name] enabling payment processing services through Stripe, you agree to provide [platform name] accurate and complete information about you and your business, and you authorize [platform name] to share it and transaction information related to your use of the payment processing services provided by Stripe.</p>
        </div>
      </div>
    </div>

    <div class="ui field">
      <input type="submit" name="" value="Set" class="ui button teal small">
    </div>
  </div>

</form>

@section('scripts')
  <script type="text/javascript">
    $('.ui.accordion').accordion();
  </script>
@endsection

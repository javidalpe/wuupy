@extends('master.master')

@section('content')
  <div class="ui segment">

    <h3>Your bank account</h3>
    <p>Your bank account must be a checking account.</p>
    <div class="bank-account-form">
      <form id="payment-form" action="{{ route('banks.store') }}" class="ui form" method="post">
        {{ csrf_field() }}

        <div class="ui error message">
          <div class="header">Error</div>
          <p class="message"></p>
        </div>

        <div class="two fields">

          <div class="dropdown-field-view field form-row required">
            <label for="currency" class="default-label">Currency:</label>
            <div class="dropdown-widget-view">
              <select name="currency" class="field currency">
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="CAD">CAD</option>
                <option value="AUD">AUD</option>
                <option value="CHF">CHF</option>
                <option value="DKK">DKK</option>
                <option value="GBP">GBP</option>
                <option value="NOK">NOK</option>
                <option value="SEK">SEK</option>
                <option value="BRL">BRL</option>
                <option value="MXN">MXN</option>
                <option value="NZD">NZD</option>
                <option value="JPY">JPY</option>
                <option value="SGD">SGD</option>
                <option value="HKD">HKD</option>      </select>
              </div>
              <span class="tooltip_placeholder"></span>
              <span id="currency_error" class="field_error "></span>
              <span id="currency_success" class="field_success"></span>
            </div>
            <div class="dropdown-field-view field form-row bank_country required">
              <label for="bank_country" class="default-label">Bank country:</label>
              <div class="dropdown-widget-view bank_country">
                <select class="country" name="bank_country" class="field">
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
              <span class="tooltip_placeholder"></span>
              <span id="bank_country_error" class="field_error bank-errors"></span>
              <span id="bank_country_success" class="field_success"></span>
            </div>


          </div>

          <div class="routing-number-field-view field form-row routing_number required">
            <div class="routing-number-widget-view routing_number">
              <label for="routing_number" class="default-label">Routing number:</label>

              <input data-number-type="routing" class="routing field" type="text" name="routing_number" placeholder="111000000">


              <div class="icon"></div>


            </div>
            <span class="tooltip_placeholder"></span>
            <span id="routing_number_error" class="field_error "></span>
            <span id="routing_number_success" class="field_success"></span>
          </div>
          <div class="account-number-field-view field form-row account_number required">
            <label for="account_number" class="default-label">Account number:</label>
            <div class="account-number-widget-view account_number">
              <input class="field account-number" type="text" name="account_number" autocomplete="off" placeholder="" maxlength="34">

              <div class="icon"></div>

            </div>
            <span class="tooltip_placeholder"></span>
            <span id="account_number_error" class="field_error "></span>
            <span id="account_number_success" class="field_success"></span>
          </div>
          <div class="account-number-validate-field-view field form-row account_number_validate required">
            <label for="account_number_validate" class="default-label">Confirm account number:</label>
            <div class="account-number-validate-widget-view account_number_validate">
              <input class="field" type="text" name="account_number_validate" autocomplete="off" placeholder="" maxlength="34">
              <div class="icon default"></div>
            </div>
            <span class="tooltip_placeholder"></span>
            <span id="account_number_validate_error" class="field_error "></span>
            <span id="account_number_validate_success" class="field_success"></span>
          </div>

          <div class="advanced-fields-container" style="display: none">
            <hr>
            <div class="show-advanced-fields-control"></div>
            <div class="ui fields advanced" style="display:none"></div>
          </div>
          <div class="field">
            <label for="account_holder_name" class="default-label">Account Holder Name:</label>
            <input type="text" name="account_holder_name" value="" class="name account_holder_name">
          </div>
          <div class="field">
            <button onClick='submitBankAccount()' class="ui button primary">Add bank account</button>
            <a href="/home">Cancel</a>
          </div>
        </form>


      </div>

    </div>
  @endsection

  @section('scripts')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">

    Stripe.setPublishableKey("{{ config('services.stripe.key')}}");

    function submitBankAccount() {

      var $form = $('#payment-form');
      $form.find('button').prop('disabled', true);

      Stripe.bankAccount.createToken({
        country: $('.country').val(),
        currency: $('.currency').val(),
        routing_number: $('.routing').val(),
        account_number: $('.account-number').val(),
        account_holder_name: $('.name').val(),
        account_holder_type: "{{ $account['legal_entity']['type'] }}"
      }, stripeResponseHandler);
    }

    function stripeResponseHandler(status, response) {

      // Grab the form:
      var $form = $('#payment-form');

      if (response.error) { // Problem!

        // Show the errors on the form:
        $form.addClass("error")
        $form.find('.message').text(response.error.message);
        $form.find('button').prop('disabled', false); // Re-enable submission

      } else { // Token created!

        // Get the token ID:
        var token = response.id;

        // Insert the token into the form so it gets submitted to the server:
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));

        // Submit the form:
        $form.get(0).submit();

      }
    }
    </script>

  @endsection

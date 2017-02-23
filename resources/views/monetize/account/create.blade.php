
<form class="ui form" action={{ route('account.store')}} method="post">
    {{ csrf_field() }}

    <div class="two fields">
        <div class="grouped fields">
            <label>Account type</label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="type" value="individual" required>
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
    </div>

    <h5>Name and birthday</h5>
    <div class="fields">
        <div class="four wide field">
            <label>First name</label>
            <input type="text" name="first_name" required placeholder='Justin'>
        </div>
        <div class="four wide field">
            <label>Last name</label>
            <input type="text" name="last_name"  required placeholder='Biber'>
        </div>
        <div class="one wide field">
            <label>Day</label>
            <input type="text" name="day" required placeholder='01'>
        </div>
        <div class="one wide field">
            <label>Month</label>
            <input type="text" name="month"  required placeholder='03'>
        </div>
        <div class="two wide field">
            <label>Year</label>
            <input type="text" name="year"  required placeholder='1994'>
        </div>
    </div>

    <div class="ui field">
        <div class="ui accordion">
            <div class="title">
                <label>By clicking set you accept the <a href="#">Terms of Service</a></label>
            </div>
            <div class="content">
                <p>Payment processing services for premium accounts on {{ config('app.name') }} are provided by Stripe and are
                    subject to the <a href="https://stripe.com/connect-account/legal">
                        Stripe Connected Account Agreement</a>, which includes the
                        <a href="https://stripe.com/legal">Stripe Terms of Service</a>
                        (collectively, the “Stripe Services Agreement”). By agreeing to
                        these terms or continuing to operate as
                        a {{ $user->nickname }} on {{ config('app.name') }}, you agree to be bound
                        by the Stripe Services Agreement, as the same may be modified by
                        Stripe from time to time. As a condition of {{ config('app.name') }}
                        enabling payment processing services through Stripe, you agree to
                        provide {{ config('app.name') }} accurate and complete information about
                        you and your business, and you authorize {{ config('app.name') }} to share
                        it and transaction information related to your use of the payment
                        processing services provided by Stripe.</p>
                    </div>
                </div>
            </div>

            <div class="ui field">
                @include('master.components.submit',['class' => 'blue small', 'label' => 'Next'])
            </div>

        </form>

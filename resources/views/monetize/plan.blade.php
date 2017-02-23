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
                @include('master.components.submit',['class' => 'tiny', 'label' => 'Update'])
            @else
                @include('master.components.submit',['class' => 'blue small', 'label' => 'Set'])
            @endif
            <small id="explanation"></small>
        </div>
    </div>
</form>

<script type="text/javascript">

var amounts = {
    'one': [0.99, 0.51, 0.15, 0.33],
    'five': [4.99, 3.80, 0.75, 0.44],
    'ten': [9.99, 7.90, 1.50, 0.59],
    'twenty': [19.99, 16.11, 3.00, 0.88]
};

$(document).ready(function() {
    $('input[type=radio][name=plan]').change(function() {
        var pri = amounts[this.value];
        $('#explanation').text("You will recieve $" + pri[1] + " ($" + (pri[2]+pri[3]) + " fee) for each follower");
    });
});

</script>

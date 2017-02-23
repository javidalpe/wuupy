@if (!isset(Auth::user()->account_id))
    @include('monetize.account.create')
@else
    @if ($account['external_accounts']['total_count'] <= 0)
        @include('monetize.banks.create')
    @else
        @if (!$account['transfers_enabled'])
            @include('monetize.account.transfers-disabled')
        @endif

        @foreach($account['external_accounts']['data'] as $bank)
            <div class="ui horizontal segments">
                <div class="ui segment">
                    <p>{{ strtoupper($bank['currency']) }}</p>
                </div>
                <div class="ui segment">
                    <p><i class="university icon"></i> {{ $bank['bank_name']}} ({{$bank['country']}})</p>
                </div>
                <div class="ui segment">
                    <p>**** {{ $bank['last4']}}</p>
                </div>
            </div>
        @endforeach

        @if(count($account['verification']['fields_needed']) > 0)
            <div class="ui warning message">
                <p>We weren't able to verify this account using the information
                    already provided. If this account continues to process more volume, we may need to collect more information.</p>
                <a href="{{route('account.edit')}}" class="button tiny blue">Provide more information</a>
            </div>
        @endif
    @endif
@endif

@if (!isset(Auth::user()->account_id))
    @include('monetize.account.create')
@else
    @if ($account['external_accounts']['total_count'] <= 0)
        @include('monetize.banks.create')
    @else
        @if (!$account['transfers_enabled'])
            @include('monetize.account.transfers-disabled')
        @endif

        @if(count($account['verification']['fields_needed']) > 0)
            @include('monetize.account.verification-needed')
        @endif

        @include('monetize.banks.index')

        @if(count($balance) > 0)
          @include('monetize.balance.table')
          @if(count($balance) == 3)
            <a href="{{ route('balance.index')}}">Show more</a>
          @endif
        @endif
        
    @endif
@endif

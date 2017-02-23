@if (!isset(Auth::user()->account_id))
  @include('monetize.account.create')
@else
  @if ($account['external_accounts']['total_count'] <= 0)
    <a href="{{ route('banks.create')}}">Add bank account</a>
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
          <p>{{ $bank['bank_name']}} ({{$bank['country']}})</p>
        </div>
        <div class="ui segment">
          <p>**** {{ $bank['last4']}}</p>
        </div>
      </div>
    @endforeach
  @endif
@endif

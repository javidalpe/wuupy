<strong>Bank</strong>
<table class="ui table celled">
  <tbody>
    @foreach($account['external_accounts']['data'] as $bank)
      <tr>
        <td>{{ strtoupper($bank['currency']) }}</td>
        <td><i class="university icon"></i> {{ $bank['bank_name']}} ({{$bank['country']}})</td>
        <td>**** {{ $bank['last4']}}</td>
      </tr>
    @endforeach
  </tbody>
</table>

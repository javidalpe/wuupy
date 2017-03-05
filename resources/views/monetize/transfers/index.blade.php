<table class="ui table compact celled unstackable">
    <thead>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Arrive at</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transfers as $transfer)
            <tr>
                <td>{{ $transfer->created}}</td>
                <td>{{ $transfer->currency}}{{ $transfer->amount/100}}</td>
                <td>{{ $transfer->status}}</td>
                <td>{{ $transfer->date}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

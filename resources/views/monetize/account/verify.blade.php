@extends('master.master')

@section('content')
    <div class="ui warning message">
        <div class="header">Warning:</div>
        <p>We weren't able to verify this account using the information
            already provided. If this account continues to process more volume, we may need to collect the following information:</p>
            <form class="ui form" action="{{ route('account.update') }}" method="post" files="true" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                @foreach ($account['verification']['fields_needed'] as $verification)

                    @if($verification == 'legal_entity.personal_id_number')
                        @include('monetize.account.personal_id_number')
                    @elseif($verification == 'legal_entity.ssn_last_4')
                        @include('monetize.account.ssn_last_4')

                    @elseif($verification == 'legal_entity.address.city')
                        @include('monetize.account.address.city')
                    @elseif($verification == 'legal_entity.address.line1')
                        @include('monetize.account.address.line1')
                    @elseif($verification == 'legal_entity.address.postal_code')
                        @include('monetize.account.address.postal_code')
                    @elseif($verification == 'legal_entity.address.state')
                        @include('monetize.account.address.state')

                    @elseif($verification == 'legal_entity.business_name')
                        @include('monetize.account.business_name')
                    @elseif($verification == 'legal_entity.business_tax_id')
                        @include('monetize.account.business_tax_id')

                    @elseif($verification == 'legal_entity.personal_address.city')
                        @include('monetize.account.personal_address.city')
                    @elseif($verification == 'legal_entity.personal_address.line1')
                        @include('monetize.account.personal_address.line1')
                    @elseif($verification == 'legal_entity.personal_address.postal_code')
                        @include('monetize.account.personal_address.postal_code')
                    @elseif($verification == 'legal_entity.personal_address.state')
                        @include('monetize.account.personal_address.state')
                    @elseif($verification == 'legal_entity.verification.document')
                        @include('monetize.account.document')
                    @else
                        @include('master.alerts.error', ['msg' => 'Unkown information required. Please contact us.'])
                    @endif
                @endforeach
                @include('master.components.submit',['class' => 'blue small', 'label' => 'Update'])
                <a href="/home">I will do it later</a>
            </form>
        </div>
    @endsection

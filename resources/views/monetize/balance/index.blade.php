@extends('master.master')

@section('content')
  <strong>Account balance</strong>
  @include('monetize.balance.table')
@endsection

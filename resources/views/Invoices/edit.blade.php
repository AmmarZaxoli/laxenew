@extends('layouts.index')

@section('content')
    <livewire:add-invoices.edit :invoiceId="$invoice->id" />

@endsection

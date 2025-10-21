@extends('layouts.index')

@section('content')
@section('title', 'لوحة الحسابات')
    <div class="card body formtype">
        <livewire:userpayment.show/>
    </div>
@endsection

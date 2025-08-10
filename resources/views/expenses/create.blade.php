@extends('layouts.index')

@section('content')

  <div class="card body formtype">
    <div class="header d-flex justify-content-between align-items-center mb-1">
    <a data-bs-toggle="modal" data-bs-target="#insertModal" class="btn btn-outline-success">إضافة مصروف</a>
    </div>
    <livewire:expenses.show />
  </div>



  <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="insertModalLabel">إضافة مصروف</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="غلاق"></button>
      </div>
      <div class="modal-body">

      <livewire:expenses.insert />
      </div>
    </div>

    </div>
  </div>
  </div>
@endsection
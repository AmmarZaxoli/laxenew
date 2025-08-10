@extends('layouts.index')

@section('content')
    <div class="card body formtype">
        <div class="header d-flex justify-content-between align-items-center mb-1">

            <a data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-outline-success">إضافة النوع</a>
        </div>
        <livewire:types.show>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="padding: 10px">
                    <div class="modal-header">
                        <h4 class="modal-title" id="staticBackdropLabel">إنشاء النوع جديد</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <livewire:types.insert>

                </div>
            </div>
        </div>
    </div>

    
@endsection

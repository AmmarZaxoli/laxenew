<div  >
    <div >
      
        <div class="card-body p-4">
            <form wire:submit.prevent="store">
                @csrf
                <div class="row g-4"> 
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">اسم</label>
                            <input type="text" class="form-control shadow-sm" id="nameInput" wire:model='name' autocomplete="off">
                            @error('name')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال الاسم" }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="priceInput" class="form-label">ثمن مصروف</label>
                            <input type="number"  style="text-align: right;" class="form-control shadow-sm" id="priceInput" wire:model='price' autocomplete="off">
                            @error('price')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال ثمن المصروف" }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 h-100">
                            <label for="namethingInput" class="form-label">تعريف مصروف</label>
                            <textarea class="form-control shadow-sm" id="namethingInput" style="resize: none" wire:model='namething' rows="5"></textarea>
                            @error('namething')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال اسم المصروف" }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">

                     <button type="submit" class="btn btn-outline-primary px-4">
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                        إضافة
                    </button>

                    <button type="button" class="btn btn-outline-secondary px-4" 
                            wire:click="resetForm" 
                            data-bs-dismiss="modal">
                        إغلاق
                    </button>
                   
                </div>
            </form>
        </div>
    </div>
    <style>
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
        }
        label.form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
    </style>
</div>

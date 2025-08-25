<div class="container card shadow-sm border-3 card-body p-4 borde">
 

        <div class="form-group mb-4">
            <label class="form-label">اسم</label>
            <input type="text" wire:model.defer="name" class="form-control">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">السعر</label>
            <input type="number" step="0.01" wire:model.defer="price" class="form-control">
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">الوصف</label>
            <input type="text" wire:model.defer="namething" class="form-control">
            @error('namething')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="dateBuy" class="form-label">التاريخ والوقت</label>
            <input type="datetime-local" id="dateBuy" class="form-control" wire:model.defer="created_at">
            @error('created_at')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <button wire:click="update" class="btn btn-primary">تحديث</button>
        </div>
    
</div>

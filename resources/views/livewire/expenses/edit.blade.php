<div class="container card shadow-sm border-3 card-body p-4 borde">
        <form wire:submit.prevent="update">



            <div class="form-group mb-4">
                <label class="form-label">اسم</label>
                <input type="text" wire:model.defer="name" class="form-control">
               @error('name')
                   <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label">السعر</label>
                <input type="text" wire:model.defer="price" class="form-control ">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label">الوصف</label>
                <input type="text" wire:model.defer="namething" class="form-control ">
                @error('namething') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="d-flex justify-content-between">
               <button type="button" class="btn btn-primary" wire:click="update">تحديث</button>

            </div>
        </form>
    </div>


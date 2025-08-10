<div>
    <form wire:submit.prevent="update">
        <div class="form-group mb-3">
            <label class="form-label">اسم</label>
            <input type="text" wire:model.defer="typename" class="form-control type-input" autofocus>
            @error('typename')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">
            <button type="submit" class="btn btn-outline-primary">تحديث</button>
            <button type="button" class="btn btn-outline-secondary px-4 rounded-2" data-bs-dismiss="modal">
            إغلاق
        </button>
        </div>
    </form>
</div>

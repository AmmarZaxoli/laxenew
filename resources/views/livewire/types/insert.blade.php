<div>
    <form wire:submit.prevent='store'>
        <div class="form-group mb-3">
            <label for="typename" class="form-label">اسم النوع</label>
            <input type="text" class="form-control" wire:model='typename'>
            @error('typename')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-4 gap-2 border-top pt-3">
            <button type="submit" class="btn btn-outline-primary">إنشاء</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </form>
</div>

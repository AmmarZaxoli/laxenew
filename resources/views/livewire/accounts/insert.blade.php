<div class="container">
    <div class="card shadow-sm border-3">
        <div class="card-header  text-black py-3" style="background-color: rgb(231, 231, 231)">
            <h5 class="mb-0">إضافة حساب الجديد </h5>
        </div>
        <div class="card-body p-4 borde">
            <form wire:submit.prevent="store">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">اسم</label>
                            <input type="text" class="form-control" id="nameInput" wire:model='name' autofocus>
                            @error('name')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال الاسم" }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="priceInput" class="form-label">رقم السر </label>
                            <input type="text" class="form-control" id="priceInput" wire:model='password'>
                            @error('password')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال رقم السر" }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="roleSelect" class="form-label">رول</label>
                            <select class="form-select" id="roleSelect" wire:model="role">
                                <option value="">اختر رول...</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            @error('role')
                                <div class="text-danger small mt-1">{{ "يرجى إدخال رول" }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" wire:click="resetForm"
                        data-bs-dismiss="modal">
                        إغلاق
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                        إضافة
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
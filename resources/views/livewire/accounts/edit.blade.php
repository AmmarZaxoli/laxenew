<div class="container">
    <div class="card shadow-sm border-3">
        
        <div class="card-body p-4 borde">
            <form wire:submit.prevent="update">



                <div class="form-group mb-4">
                    <label class="form-label">اسم</label>
                    <input type="text" wire:model.defer="name" class="form-control">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">رقم السر</label>
                    <input type="text" wire:model.defer="password" class="form-control ">
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
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
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" wire:click="update">تحديث</button>

                </div>
        </div>
    </div>
    </form>
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
<div>
    <div class="row">
        <!-- Driver Select -->
        <div class="col-md-3 mb-3">
            <label for="username" class="form-label">اسم السائق</label>
            <select id="username" class="form-control" wire:model="username">
                <option value="">اختر السائق</option>
                @foreach ($usernames as $username)
                    <option value="{{ $username->name }}">{{ $username->name }}</option>
                @endforeach
            </select>
            @error('username')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Payment -->
        <div class="col-md-3 mb-3">
            <label for="payment" class="form-label">المبلغ</label>
            <input type="number" id="payment" class="form-control" wire:model="payment">
            @error('payment')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Date -->
        <div class="col-md-3 mb-3">
            <label for="date" class="form-label">التاريخ والوقت</label>
            <input type="datetime-local" id="date" class="form-control" wire:model="date">
            @error('date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="col-md-3 d-flex align-items-end mb-3" style="margin-top: 47px">
            <button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"
                wire:click="save" wire:loading.attr="disabled" type="button">

                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status"
                    aria-hidden="true"></span>


                <i class="fas fa-plus-circle me-2"></i> دفع
            </button>
        </div>

    </div>

    <style>
        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            border: none;
        }
    </style>

    <div class="row">
        <!-- From Date -->
        <div class="col-md-3 mb-3">
            <label for="date_from" class="form-label">من تاريخ</label>
            <input type="date" id="date_from" class="form-control" wire:model="date_from">
            @error('date_from')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- To Date -->
        <div class="col-md-3 mb-3">
            <label for="date_to" class="form-label">إلى تاريخ</label>
            <input type="date" id="date_to" class="form-control" wire:model="date_to">
            @error('date_to')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Filter Button -->
        <div class="col-md-3 d-flex align-items-end mb-3" style="margin-top: 47px">
            <button class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center"
                wire:click="filterPayments" wire:loading.attr="disabled" type="button">


                <span wire:loading wire:target="filterPayments" class="spinner-border spinner-border-sm me-2"
                    role="status" aria-hidden="true"></span>


                <i class="fas fa-search me-2"></i> عرض
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th width="40" class="text-center">#</th>
                    <th class="text-center">اسم المستخدم</th>
                    <th class="text-center" width="100">المبلغ</th>
                    <th class="text-center" width="180">التاريخ</th>
                    <th class="text-center">المسؤول</th>
                    <th width="250" class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userpayment as $payment)
                    <tr class="align-middle">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="fw-medium text-center">{{ $payment->nameuser }}</td>
                        <td class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success fs-6">
                                {{ number_format($payment->payment) }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($payment->date)->format('Y-m-d') }}
                        </td>


                        <td class="text-center">{{ $payment->admin }}</td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Delete Button -->
                                <button wire:click="$dispatch('confirmDelete', { id: {{ $payment->id }} })"
                                    class="btn btn-sm btn-icon btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                <span class="text-muted">لا توجد بيانات دفع متاحة</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        {{-- {{ $userpayment->links() }} --}}
    </div>
    @script
        <script>
            $wire.on('confirmDelete', (event) => {
                Swal.fire({
                    title: "تأكيد الحذف",
                    text: "هل أنت متأكد من رغبتك في حذف هذا العنصر ؟ ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "نعم",
                    cancelButtonText: "إلغاء",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.delete(event.id);
                    }
                });
            });
        </script>
    @endscript
</div>

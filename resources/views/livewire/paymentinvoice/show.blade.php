<div>



    {{-- Payments Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">التاريخ</th>
                <th class="text-center">المبلغ</th>
                <th class="text-center">حذف</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($payment['date_payment'])->format('Y-m-d') }}
                    </td>

                    <td class="text-center">{{ number_format($payment->cashpayment) }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button wire:click.prevent="$dispatch('confirmpayment', { id: {{ $payment->id }} })"
                                class="btn btn-outline-danger d-flex align-items-center py-1">
                                <i class="fas fa-trash-alt mr-1"></i> حذف
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">لا توجد مدفوعات بعد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Add Payment Form --}}

    <div class="row g-2">
        <div class="col-md-4">
            <input type="number" class="form-control" wire:model="cashpayment" placeholder="إدخال مبلغ ">
            @error('cashpayment')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <input type="date" class="form-control" wire:model="date_payment">
            @error('date_payment')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-4">
            <button wire:click='submitPayment' class="btn btn-outline-primary w-100" type="submit">الدفع</button>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @script
        <script>
            $wire.on("confirmpayment", (event) => {

                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "نعم، احذفه!",
                    cancelButtonText: "إلغاء",
                    reverseButtons: true

                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.dispatch("deletepayment", {
                            id: event.id
                        });
                    }
                });

            });
        </script>
    @endscript

</div>

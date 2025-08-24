<div>
    <style>
        /* Modern Card Design */
        .card-modern {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 12px 30px -5px rgba(0, 0, 0, 0.2);
        }

        .table-modern {
            border: none;
        }

        .table-modern thead th {
            background-color: #6366f1;
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.8rem;
            text-align: center;
        }

        .table-modern tbody td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-modern {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-modern i {
            margin-right: 0.3rem;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Inputs */
        .form-control-modern {
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control-modern:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            border-color: #6366f1;
        }
    </style>

    <div class="card-modern">
        {{-- Payments Table --}}
        <table class="table table-modern table-striped">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>المبلغ</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td class="text-center">{{ \Carbon\Carbon::parse($payment['date_payment'])->format('Y-m-d') }}
                        </td>
                        <td class="text-center">{{ number_format($payment->cashpayment) }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button wire:click.prevent="$dispatch('confirmpayment', { id: {{ $payment->id }} })"
                                    class="btn btn-modern btn-outline-danger d-flex align-items-center justify-content-center">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-secondary py-3">لا توجد مدفوعات بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Add Payment Form --}}
        <div class="row g-3 mt-4">
            <div class="col-md-4">
                <input type="number" class="form-control form-control-modern" wire:model="cashpayment"
                    placeholder="إدخال مبلغ">
                @error('cashpayment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <input type="date" class="form-control form-control-modern" wire:model="date_payment">
                @error('date_payment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-4">
                <button wire:click='submitPayment' class="btn btn-modern btn-outline-primary w-100"
                    type="submit">الدفع</button>
            </div>
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

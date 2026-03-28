<div>

    <div class="content-container">

        <div class="row mb-3 g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label">من تاريخ</label>
                <input type="date" wire:model="date_from" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" wire:model="date_to" class="form-control">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100" wire:click="filterByDate">
                    بحث
                </button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="location.reload()">
                    تحديث
                </button>
            </div>

            <button class="btn btn-success" wire:click="exportExcel">

                <i class="fas fa-file-excel"></i>
                تصدير Excel

            </button>

        </div>


        <div class="table-responsive">

            <div class="mb-3">

                عدد الفواتير:
                <span class="badge bg-primary">
                    {{ $invoices->total() }}
                </span>

            </div>
            <table class="table table-hover">

                <thead class="table-light">

                    <tr>

                        <th width="40">
                            <input type="checkbox" wire:model.live="selectAll" class="form-check-input">
                        </th>

                        <th>#</th>
                        <th class="text-center">الفاتورة</th>
                        <th class="text-center">السائق</th>
                        <th class="text-center">العنوان</th>
                        <th class="text-center">الجوال</th>
                        <th class="text-center">التوصيل</th>
                        <th class="text-center">الإجمالي</th>
                        <th class="text-center">التاريخ</th>
                        <th class="text-center">الدفع</th>
                        <th class="text-center">طلب من</th>
                        <th class="text-center">بائع</th>
                        <th class="text-center">خيارات</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($invoices as $invoice)
                        <tr>

                            <td>
                                <input type="checkbox" class="form-check-input" wire:model.live="selectedInvoices"
                                    value="{{ $invoice->num_invoice_sell }}">
                            </td>

                            <td>{{ $loop->iteration }}</td>

                            <td class="text-center">
                                <span class="badge bg-success">
                                    {{ $invoice->num_invoice_sell }}
                                </span>
                            </td>

                            <td class="text-center">
                                {{ $invoice->customer?->driver?->nameDriver ?? '—' }}
                            </td>

                            <td class="text-center">
                                {{ $invoice->customer?->address ?? '—' }}
                            </td>

                            <td class="text-center">
                                {{ $invoice->customer?->mobile ?? '—' }}
                            </td>

                            <td class="text-center">
                                {{ number_format($invoice->sell?->taxi_price ?? 0) }}
                            </td>

                            <td class="text-center fw-bold">
                                {{ number_format($invoice->sell?->total_price_afterDiscount_invoice ?? 0) }}
                            </td>

                            <td class="text-center">
                                {{ $invoice->date_sell }}
                            </td>

                            <td class="text-center">

                                @if ($invoice->customer?->waypayment)
                                    <span class="badge bg-success">
                                        {{ $invoice->customer->waypayment }}
                                    </span>
                                @endif

                            </td>

                            <td class="text-center">

                                @if ($invoice->customer?->buywith)
                                    <span class="badge bg-primary">
                                        {{ $invoice->customer->buywith }}
                                    </span>
                                @endif

                            </td>

                            <td class="text-center">
                                {{ $invoice->sell?->user }}
                            </td>

                            <td class="text-center">

                                <div class="dropstart">

                                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>
                                            <button class="dropdown-item" onclick="printInvoice({{ $invoice->id }})">
                                                طباعة
                                            </button>
                                        </li>

                                        <li>
                                            <button class="dropdown-item" wire:click="payment({{ $invoice->id }})">
                                                دفع
                                            </button>
                                        </li>

                                        <li>
                                            <button class="dropdown-item text-danger"
                                                wire:click.prevent="$dispatch('confirmDelete',{id: {{ $invoice->id }}})">
                                                حذف
                                            </button>
                                        </li>

                                    </ul>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="13" class="text-center p-5">

                                لا توجد فواتير

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>
            @if ($showResults)
                <!-- table here -->

                <div class="mt-3 d-flex justify-content-center">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>

    </div>

</div>

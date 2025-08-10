<div>
    <div class="card">
        <div class="container-fluid p-0">
            <div class="card-body">
                <!-- Search and Filter Section -->
                <div class="row g-3 mb-4 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label small text-muted mb-1">بحث</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input type="text" wire:model.live="search" class="form-control" id="search"
                                placeholder="ابحث بالاسم أو الكود..." autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="selected_company" class="form-label small text-muted mb-1">تصفية حسب الشركة</label>
                        <select class="form-select" wire:model.live="selected_company" id="selected_company">
                            <option value="">جميع الشركات</option>
                            @foreach ($companys as $company)
                                <option value="{{ $company->companyname }}">{{ $company->companyname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="40" class="text-center">#</th>
                                <th class="text-center">رقم الفاتورة</th>
                                <th class="text-center">اسم زبون</th>
                                <th class="text-center">التاريخ إنشاء</th>
                                <th class="text-center">سعر القائيمة</th>
                                <th class="text-center">تخفيض القائمة</th>
                                <th class="text-center">سعر بعد تخفيض</th>
                                <th class="text-center">دفع النقد</th>
                                <th class="text-center">الحساب المتبقي</th>
                                <th class="text-center">الملاحظة</th>
                                <th width="150" class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr class="align-middle" style="cursor: pointer;"
                                    wire:key="invoice-{{ $invoice->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $invoice->num_invoice }}</td>
                                    <td class="text-center">{{ $invoice->name_invoice }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($invoice->datecreate)->format('Y-m-d') }}</td>
                                    <td class="text-center">{{ number_format($invoice->total_price) }}</td>
                                    <td class="text-center">{{ number_format($invoice->discount) }}%</td>
                                    <td class="text-center">{{ number_format($invoice->afterDiscountTotalPrice) }}</td>
                                    <td class="text-center">{{ number_format($invoice->cash) }}</td>
                                    <td class="text-center">{{ number_format($invoice->residual) }}</td>
                                    <td class="text-center">{{ $invoice->note }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button wire:click="editInvoice({{ $invoice->id }})"
                                                class="btn btn-sm btn-icon btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                                            <span class="text-muted">لا توجد فواتير متاحة</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    {{ $invoices->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>


   @if ($editModal)
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الفاتورة</h5>
                    <button type="button" wire:click="closeModal" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <livewire:add-invoices.edit :invoiceId="$editingInvoiceId" :key="'edit-' . $editingInvoiceId" />
                </div>
            </div>
        </div>
    </div>
@endif




</div>

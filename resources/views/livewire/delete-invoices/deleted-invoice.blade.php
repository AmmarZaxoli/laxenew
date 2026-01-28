<div class="container-fluid py-3">
    <!-- Header -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="bg-light rounded-circle p-2 me-3">
                    <i class="bi bi-trash text-danger fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-1 text-dark fw-semibold">الفواتير المحذوفة</h5>
                    <p class="text-muted small mb-0">عرض وإدارة الفواتير المحذوفة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card shadow-sm mb-4 border">
        <div class="card-body p-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0"
                            placeholder="ابحث برقم الفاتورة، الهاتف، أو المستخدم..."
                            wire:model.live.debounce.300ms="search">
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted small">
                        {{ $invoices->total() }} فاتورة
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card shadow-sm border">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr style="cursor: pointer">
                        <th width="60" class="text-center">#</th>
                       
                        <th wire:click="sortBy('customermobile')" class="cursor-pointer">
                            الهاتف
                            @if ($sortField == 'customermobile')
                                <i class="bi bi-arrow-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @endif
                        </th>
                        <th>المستخدم</th>
                        <th wire:click="sortBy('totalprice')" class="cursor-pointer">
                            الإجمالي
                            @if ($sortField == 'totalprice')
                                <i class="bi bi-arrow-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')" class="cursor-pointer">
                            التاريخ
                            @if ($sortField == 'created_at')
                                <i class="bi bi-arrow-{{ $sortDirection == 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @endif
                        </th>
                        <th width="120">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $index => $invoice)
                        <tr class="border-bottom" >
                            <td class="text-center text-muted fw-semibold">
                                {{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}
                            </td>
                           
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-phone text-muted me-2"></i>
                                    {{ $invoice->customermobile }}
                                </div>
                            </td>
                            <td>{{ $invoice->user }}</td>
                            <td class="fw-semibold text-danger">
                                {{ number_format($invoice->totalprice) }}
                            </td>
                            <td class="text-muted small">
                                {{ $invoice->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                    wire:click="viewInvoice({{ $invoice->id }})">
                                    <i class="bi bi-eye me-1"></i> عرض
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-receipt text-muted fs-1"></i>
                                    </div>
                                    <h6 class="text-muted">لا توجد فواتير محذوفة</h6>
                                    <p class="text-muted small">لم يتم العثور على فواتير مطابقة للبحث</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($invoices->hasPages())
        <div class="mt-4">
            {{ $invoices->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <!-- Invoice Details Modal -->
    @if ($showModal && $invoiceDetails)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);"
            wire:click.self="closeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow">
                    <!-- Modal Header -->
                    <div class="modal-header border-bottom bg-light">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-trash text-danger"></i>
                            </div>
                            <div>
                                <h6 class="modal-title mb-0">فاتورة محذوفة</h6>
                                <p class="text-muted small mb-0">رقم: {{ $invoiceDetails->num_invoice_sell }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body py-4">
                        <!-- Invoice Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-telephone text-muted me-2"></i>
                                        <span class="small text-muted">الهاتف</span>
                                    </div>
                                    <p class="mb-0 fw-semibold">{{ $invoiceDetails->customermobile }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person text-muted me-2"></i>
                                        <span class="small text-muted">المستخدم</span>
                                    </div>
                                    <p class="mb-0 fw-semibold">{{ $invoiceDetails->user }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Address and Discount in same row -->
                        @if ($invoiceDetails->address || $invoiceDetails->discount)
                            <div class="row g-3 mb-4">
                                @if ($invoiceDetails->address)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 bg-light">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-geo-alt text-muted me-2"></i>
                                                <span class="small text-muted">العنوان</span>
                                            </div>
                                            <p class="mb-0">{{ $invoiceDetails->address }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($invoiceDetails->discount)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 bg-light">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-percent text-muted me-2"></i>
                                                <span class="small text-muted">الخصم</span>
                                            </div>
                                            <p class="mb-0 fw-semibold">{{ number_format($invoiceDetails->discount) }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Items Table -->
                        <div class="border rounded overflow-hidden mb-4">
                            <table class="table table-sm mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>المنتج</th>
                                        <th width="100" class="text-center">الكمية</th>
                                        <th width="120" class="text-end">السعر</th>
                                        <th width="120" class="text-end">الإجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoiceItems as $index => $item)
                                        <tr class="{{ $loop->last ? '' : 'border-bottom' }}">
                                            <td class="text-muted">{{ $index + 1 }}</td>
                                            <td>{{ $item->product->definition->name ?? 'Offer : (' . $item->product_id . ')' }}
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">{{ number_format($item->price) }}</td>
                                            <td class="text-end fw-semibold">
                                                {{ number_format($item->price * $item->quantity) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">الإجمالي:</td>
                                        <td class="text-end fw-bold text-danger">
                                            {{ number_format($invoiceDetails->totalprice) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-top">
                        <button class="btn btn-secondary" wire:click="closeModal">
                            <i class="bi bi-x-circle me-1"></i> إغلاق
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

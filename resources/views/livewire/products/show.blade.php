<div>
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
                    <label for="selected_type" class="form-label small text-muted mb-1">تصفية حسب النوع</label>
                    <select class="form-select" wire:model.live="selected_type" id="selected_type">
                        <option value="">جميع الأنواع</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->typename }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">

                    <div class="btn-group w-100" role="group" style="height: 35px">
                        <button wire:click="filterActive('active')" type="button"
                            class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </button>
                        <button wire:click="filterActive('inactive')" type="button"
                            class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">#</th>
                            <th>الاسم</th>
                            <th class="text-center" width="150">الكود</th>
                            <th class="text-center"width="200">الباركود</th>
                            <th class="text-center" width="200">النوع</th>
                            <th width="100" class="text-center">الحالة</th>
                            <th class="text-center" width="100">الكمية</th>
                            <th width="80" class="text-center">سعر بيع</th>
                            <th width="150" class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:key="definition-{{ $product->definition->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-medium">{{ $product->definition->name }}</td>
                                <td class="text-center">{{ $product->definition->code }}</td>
                                <td class="text-center">{{ $product->definition->barcode }}</td>
                                <td class="text-center">
                                    <span class="text-center">
                                        {{ $product->definition->type->typename ?? 'غير محدد' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($product->definition->is_active === 'active')
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check-circle me-1"></i> نشط
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-times-circle me-1"></i> غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge 
        {{ $product->quantity <=0
            ? 'bg-danger'
            : ($product->quantity > 0 && $product->quantity < 5
                ? 'bg-warning text-dark'
                : 'bg-light text-dark') }}">
                                        {{ $product->quantity }}
                                    </span>
                                </td>


                                <td class="text-center">{{ number_format($product->price_sell) }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button data-bs-toggle="modal"
                                            data-bs-target="#Edit{{ $product->definition->id }}"
                                            class="btn btn-sm btn-icon btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>


                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="Edit{{ $product->definition->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $product->definition->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">تعديل المخزن</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <livewire:products.edit :product_id="$product->id" :key="'product-edit-' . $product->definition->id" />

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <span class="text-muted">لا توجد تعريفات متاحة</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                {{ $products->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
</div>

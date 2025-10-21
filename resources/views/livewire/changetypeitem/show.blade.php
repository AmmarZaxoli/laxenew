<div>
    <div class="container-fluid p-0">
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row g-3 mb-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label small text-muted mb-1">بحث</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control" id="search"
                            placeholder="ابحث بالاسم أو الكود..." autocomplete="off">
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="selected_type" class="form-label small text-muted mb-1">تصفية حسب النوع</label>
                    <select class="form-control" wire:model.live="selected_type" id="selected_type">
                        <option value="">جميع الأنواع</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->typename }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <label for="count" class="form-label small text-muted mb-1">عدد العناصر</label>
                    <select class="form-control" wire:model.live="count" id="count">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>


                <style>
                    .btn {
                        border-radius: 8px;
                        padding: 10px 20px;
                        font-weight: 500;
                        transition: var(--transition);
                    }

                    .btn-primary {
                        background-color: var(--primary);
                        border-color: var(--primary);
                    }

                    .btn-primary:hover {
                        background-color: var(--secondary);
                        border-color: var(--secondary);
                        transform: translateY(-2px);
                    }

                    .btn-outline-primary:hover {
                        background-color: var(--primary);
                        color: white;
                        transform: translateY(-2px);
                    }

                    .btn-outline-secondary:hover {
                        color: white;
                        transform: translateY(-2px);
                    }
                </style>
                <!-- Batch Actions Section (Visible when rows are selected) -->
                @if (count($selectedRows) > 0)
                    <div class="col-md-5">
                        <div class="d-flex align-items-center gap-2 p-2 bg-light rounded">
                            <span class="small text-muted">{{ count($selectedRows) }} عنصر محدد</span>

                            <div class="ms-auto d-flex gap-2">
                                <!-- Button to open the batch update modal -->
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#batchUpdateTypeModal">
                                    <i class="fas fa-check-circle me-1"></i> تحديث النوع للمحدد
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" wire:click="$set('selectedRows', [])">
                                    <i class="fas fa-times me-1"></i> إلغاء التحديد
                                </button>
                            </div>
                        </div>

                        <!-- Current Selection Info -->
                        @if ($currentSelectedType)
                            <div class="mt-2 p-2 bg-info bg-opacity-10 rounded">
                                <small class="text-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    العناصر المحددة كلها من نوع:
                                    <strong>{{ $types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد' }}</strong>
                                </small>
                            </div>
                        @elseif(count($selectedRows) > 1)
                            <div class="mt-2 p-2 bg-warning bg-opacity-10 rounded">
                                <small class="text-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    العناصر المحددة تحتوي على أكثر من نوع
                                </small>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Same Type Filter Indicator -->
            @if ($showSameTypeOnly && $currentSelectedType)
                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-filter me-2"></i>
                        <span>
                            جاري عرض العناصر من نوع
                            <strong>"{{ $types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد' }}"</strong>
                            فقط
                        </span>
                        <button type="button" class="btn-close ms-auto" wire:click="showAllTypes"></button>
                    </div>
                </div>
            @endif

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">
                            </th>
                            <th width="40" class="text-center">#</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center" width="100">الكود</th>
                            <th class="text-center" width="180">الباركود</th>
                            <th class="text-center" width="240">النوع</th>
                            <th width="250" class="text-center">صورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($definitions as $definition)
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:key="definition-{{ $definition->id }}">
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model.live="selectedRows"
                                            value="{{ $definition->id }}" id="row-{{ $definition->id }}">
                                        <label class="form-check-label" for="row-{{ $definition->id }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-medium">{{ $definition->name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success fs-6">
                                        {{ $definition->code }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $definition->barcode }}</td>
                                <td class="text-center">
                                    <span class="text-center">
                                        {{ $definition->type->typename ?? 'غير محدد' }}
                                    </span>
                                </td>


                                <td class="text-center">
                                    @if ($definition->image && file_exists(public_path('storage/' . $definition->image)))
                                        <img src="{{ asset('storage/' . $definition->image) }}" width="40"
                                            height="40" class="rounded-circle object-fit-cover border"
                                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $definition->id }}"
                                            style="cursor: pointer;" alt="صورة المنتج">
                                    @else
                                        <span class="text-muted small">لا يوجد</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Image Modal -->
                            @if ($definition->image && file_exists(public_path('storage/' . $definition->image)))
                                <div class="modal fade" id="imageModal{{ $definition->id }}" tabindex="-1"
                                    aria-labelledby="imageModalLabel{{ $definition->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">صورة {{ $definition->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body text-center p-0">
                                                <img src="{{ asset('storage/' . $definition->image) }}"
                                                    class="img-fluid rounded" alt="صورة المنتج">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Edit Modal -->
                            <div class="modal fade" id="Edit{{ $definition->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $definition->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">تعديل التعريف</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <livewire:definitions.edit :definition_id="$definition->id" :key="'definition-edit-' . $definition->id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
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
                {{ $definitions->links() }}
            </div>
        </div>
    </div>

    <!-- Batch Update Type Modal -->
    <div class="modal fade" id="batchUpdateTypeModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="batchUpdateTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchUpdateTypeModalLabel">تحديث النوع للمحدد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="text-muted small">
                            سيتم تحديث النوع لـ <strong>{{ count($selectedRows) }}</strong> عنصر محدد
                        </p>

                        <!-- Show current common type if exists -->
                        @if ($currentSelectedType)
                            <div class="alert alert-info py-2">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    النوع الحالي:
                                    <strong>{{ $types->where('id', $currentSelectedType)->first()->typename ?? 'غير محدد' }}</strong>
                                </small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12">
                        <label for="batch_type" class="form-label small text-muted mb-1">اختر النوع الجديد</label>
                        <select class="form-control" wire:model="batchType" id="batch_type">
                            <option value="">اختر النوع</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->typename }}</option>
                            @endforeach
                        </select>
                        @error('batchType')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-outline-primary" wire:click="updateSelectedType"
                        wire:loading.attr="disabled" data-bs-dismiss="modal">
                        <span wire:loading.remove>تحديث النوع</span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin me-1"></i> جاري التحديث...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success text-white">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong class="me-auto">نجاح</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong class="me-auto">خطأ</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    const bsToast = new bootstrap.Toast(toast);
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
@endpush

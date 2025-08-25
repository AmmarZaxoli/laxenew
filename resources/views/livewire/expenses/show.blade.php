<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <!-- Bulk actions when items are selected -->
                @if(count($selectedExpenses) > 0)
                <div class="d-flex align-items-center gap-2 me-3 p-2 bg-light rounded">
                    <span class="text-primary fw-bold">{{ count($selectedExpenses) }} عنصر محدد</span>
                    <button wire:click="openBulkModal" class="btn btn-sm btn-primary">
                        <i class="fas fa-calendar-alt"></i> تغيير التاريخ
                    </button>
                    <button wire:click="$set('selectedExpenses', [])" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                </div>
                @endif

                <!-- Search by name -->
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model.live.debounce.200ms="searchName" class="form-control shadow-sm"
                        placeholder="بحث بالاسم" autocomplete="off">
                </div>

                <!-- Start Date -->
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt" autocomplete="off" class="form-control shadow-sm">
                </div>

                <!-- End Date -->
                <label for="priceInput" class="form-label"> إلى : </label>
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt1" class="form-control shadow-sm">
                </div>

                <!-- Load data button -->
                <button wire:click="getdatabtdate" style="margin-top: 5px" class="btn btn-outline-primary"
                    @if (!$showResults) disabled @endif wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-search"></i> عرض البيانات
                    </span>
                    <span wire:loading>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري
                        التحميل...
                    </span>
                </button>

                <!-- Reset button -->
                <button wire:click="resetSearch" class="btn btn-outline-secondary" style="margin-top: 5px">
                    <i class="fas fa-undo"></i> إعادة تعيين
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" width="50">
                        <input type="checkbox" wire:model.live="selectAll">
                    </th>
                    <th class="text-center">#</th>
                    <th>الاسم</th>
                    <th class="text-center">ثمن المصروف</th>
                    <th>وصف المصروف</th>
                    <th class="text-center">تاريخ الإنشاء</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @if ($showResults)
                    @forelse($expenses as $expense)
                        <tr class="@if(in_array($expense->id, $selectedExpenses)) table-active @endif">
                            <td class="text-center">
                                <input type="checkbox" 
                                    wire:model.live="selectedExpenses" 
                                    value="{{ $expense->id }}">
                            </td>
                            <td class="text-center">{{ $loop->iteration + ($expenses->currentPage() - 1) * $expenses->perPage() }}</td>
                            <td>{{ $expense->name }}</td>
                            <td class="text-center">{{ number_format($expense->price) }}</td>
                            <td>{{ $expense->namething }}</td>
                            <td class="text-center">{{ $expense->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $expense->id }}"
                                        class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirmDelete', { id: {{ $expense->id }} })"
                                        class="btn btn-sm btn-icon btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $expense->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel{{ $expense->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header" class="card-header  text-black py-3"
                                        style="background-color: rgb(231, 231, 231)">
                                        <h4 class="modal-title">تعديل المصروف</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @livewire('expenses.edit', ['expenseId' => $expense->id], key($expense->id))
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    @endforelse
                @else
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">الرجاء تحديد التاريخ ثم الضغط على عرض
                            البيانات
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if ($showResults)
            <div class="d-flex gap-3 flex-wrap mt-2">
                <div class="alert alert-info text-center" style="min-width: 200px;">
                    <strong>إجمالي المصروفات:</strong><br>
                    {{ number_format($totalPrice) }}
                </div>

                @if ($searchName)
                    <div class="alert alert-secondary text-center" style="min-width: 200px;">
                        <strong>إجمالي نتائج البحث:</strong><br>
                        {{ number_format($searchTotalPrice) }}
                    </div>
                @endif
                
                @if(count($selectedExpenses) > 0)
                    <div class="alert alert-warning text-center" style="min-width: 200px;">
                        <strong>العناصر المحددة:</strong><br>
                        {{ count($selectedExpenses) }} عنصر
                    </div>
                @endif
            </div>
        @endif

        <!-- Bulk Update Modal -->
        @if($showBulkModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تغيير تاريخ العناصر المحددة</h5>
                        <button type="button" class="btn-close" wire:click="closeBulkModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulkDate" class="form-label">التاريخ الجديد</label>
                            <input type="date" class="form-control" id="bulkDate" wire:model="bulkDate">
                        </div>
                        <p class="text-muted">سيتم تغيير تاريخ {{ count($selectedExpenses) }} عنصر</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeBulkModal">إلغاء</button>
                        <button type="button" class="btn btn-primary" wire:click="updateBulkDates">تطبيق</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @script
            <script>
                // Listen for delete confirmation
                $wire.on('confirmDelete', (event) => {
                    Swal.fire({
                        title: "تأكيد الحذف",
                        text: "هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لا يمكن التراجع عن هذه العملية.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "نعم، احذف!",
                        cancelButtonText: "إلغاء",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $wire.delete(event.id);
                        }
                    });
                });

                // Show success message after actions
                $wire.on("showSuccessMessage", (message) => {
                    Toast.fire({
                        icon: 'success',
                        title: message
                    });
                });
                
                // Show error message
                $wire.on("showErrorMessage", (message) => {
                    Toast.fire({
                        icon: 'error',
                        title: message
                    });
                });

                // Initialize Toast
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            </script>
        @endscript

        <!-- Pagination -->
        @if ($showResults)
            <div class="justify-content-end">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
</div>
<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">
            <div class="d-flex gap-2 flex-wrap align-items-center">

                <!-- Search by name -->
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" wire:model.live.debounce.200ms="searchName" class="form-control shadow-sm"
                        placeholder="بحث بالاسم" autocomplete="off">
                </div>

                <!-- Start Date -->
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="createdAt" autocomplete="off" 
                        class="form-control shadow-sm">
                </div>

                <!-- End Date -->
                <label for="priceInput" class="form-label"> إلى : </label>
                <div class="input-group" style="width: 200px;">

                    <span class="input-group-text"><i class="fas fa-calendar"></i> </span>
                    <input type="date" wire:model="updatedAt" wire:change="$refresh" class="form-control shadow-sm">
                </div>

                <!-- Load data button -->
      <button  wire:click="loadExpenses"  style="margin-top: 5px"  class="btn btn-outline-primary" 
    @if (!$showResults) disabled @endif
    wire:loading.attr="disabled">
    <span wire:loading.remove>
        <i class="fas fa-search"></i> عرض البيانات
    </span>
    <span wire:loading>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري التحميل...
    </span>
</button>



                <!-- Reset button -->
                <button wire:click="resetSearch" class="btn btn-outline-secondary" style="margin-top: 5px">
                    <i class="fas fa-undo"></i> إعادة تعيين
                </button>


            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="alert alert-success my-2">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger my-2">{{ session('error') }}</div>
        @endif
        @if ($errorMessage)
            <div class="alert alert-danger my-2">{{ $errorMessage }}</div>
        @endif
        @if ($successMessage)
            <div class="alert alert-success my-2">{{ $successMessage }}</div>
        @endif

        <!-- Table -->
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th>الاسم</th>
                    <th class="text-center">ثمن المصروف</th>
                    <th>وصف المصروف</th>
                    <th class="text-center">تاريخ الإنشاء</th>
                    <th class="text-center">تاريخ التحديث</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @if ($showResults)
                    @forelse($expenses as $expense)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $expense->name }}</td>
                            <td class="text-center">{{ number_format($expense->price, 2) }}</td>
                            <td>{{ $expense->namething }}</td>
                            <td class="text-center">{{ $expense->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">{{ $expense->updated_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                 

                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $expense->id }}"
                                         class="btn btn-sm btn-icon btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>


                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirm', { id: {{ $expense->id }} })"
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
                            <td colspan="7" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    @endforelse
                @else
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">الرجاء تحديد التاريخ ثم الضغط على عرض
                            البيانات
                        </td>
                    </tr>
                @endif
            </tbody>
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
                </div>
            @endif
        </table>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @script
            <script>
                $wire.on("confirm", (event) => {
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
                            $wire.dispatch("delete", {
                                id: event.id
                            });
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
            <div class=" justify-content-end ">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
</div>

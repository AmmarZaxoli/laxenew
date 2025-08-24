<div>
    <div class="table-responsive" style="border-radius: 10px; background-color:white; padding: 20px">
        <!-- Filters Section -->
        <div class="d-flex justify-content-between mb-3 flex-wrap">

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
                    <th class="font-weight-bold border-end text-center">#</th>
                    <th class="font-weight-bold border-end">الاسم</th>
                    <th class="font-weight-bold border-end"> رقم السر</th>
                    <th class="font-weight-bold border-end"> رول </th>
                    <th class="text-center" style="width: 10%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @if ($showResults)
                    @forelse($accounts as $account)
                        <tr>
                            <td class="align-middle text-center" style="width: 42px;">{{ $loop->iteration }}</td>
                            <td class="font-weight-medium border-end">{{ $account->name }}</td>
                            <td class="font-weight-medium border-end">{{ $account->password }}</td>
                            <td class="font-weight-medium border-end">{{ $account->role }}</td>


                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button (opens modal) -->
                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center py-1"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $account->id }}">
                                        <i class="fas fa-edit me-1" style="font-size: 1.2rem;"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <!-- Delete Button -->
                                    <button wire:click="$dispatch('confirm', { id: {{ $account->id }} })"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center py-1">
                                        <i class="fas fa-trash-alt mr-1" style="font-size: 1.2rem;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $account->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel{{ $account->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header" class="card-header  text-black py-3"
                                        style="background-color: rgb(231, 231, 231)">
                                        <h4 class="modal-title">تعديل الحساب</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @livewire('accounts.edit', ['accountid' => $account->id], key($account->id)) </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">لا توجد نتائج مطابقة</td>
                        </tr>
                    @endforelse
                @else
                @endif
            </tbody>

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
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
</div>

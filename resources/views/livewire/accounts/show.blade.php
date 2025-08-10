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
        <table class="table table-striped table-hover table-bordered" style="table-layout: fixed">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th> رقم السر</th>
                    <th> رول </th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @if($showResults)
                    @forelse($accounts as $account)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $account->name }}</td>
                            <td>{{ $account->password }}</td>
                            <td>{{ $account->role }}</td>


                            <td>
                                <!-- Edit Button (opens modal) -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $account->id }}">
                                    تعديل
                                </button>

                                <!-- Delete Button -->
                                <!-- Delete Button -->
                                <button wire:click="$dispatch('confirm', { id: {{ $account->id }} })"
                                    class="btn btn-sm btn-danger">
                                    حذف
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $account->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel{{ $account->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header" class="card-header  text-black py-3" style="background-color: rgb(231, 231, 231)">
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
        @if($showResults)
            <div class=" justify-content-end ">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
</div>
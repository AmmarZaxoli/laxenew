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
                            placeholder="ابحث بالاسم أو الكود...">
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
                        <button wire:click="filterActive('1')" type="button"
                            class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check-circle me-1"></i> نشط
                        </button>
                        <button wire:click="filterActive('0')" type="button"
                            class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-times-circle me-1"></i> غير نشط
                        </button>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="btn-group w-100" role="group" style="height: 35px">
                        <button wire:click="filterDelivery('all')" type="button"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i> الكل
                        </button>
                        <button wire:click="filterDelivery(true)" type="button" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check me-1"></i> مجاني
                        </button>
                        <button wire:click="filterDelivery(false)" type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-times me-1"></i> غير مجاني
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
                            <th class="text-center">الاسم</th>
                            <th class="text-center" width="40">الكود</th>
                            <th class="text-center" width="130">الباركود</th>
                            <th class="text-center" width="140">النوع</th>
                            <th width="100" class="text-center">الحالة</th>
                            <th width="120" class="text-center">التوصيل</th>
                            <th class="text-center" width="40">المدين</th>
                            <th width="80" class="text-center">صورة</th>
                            <th width="40" class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($definitions as $definition)
                            <tr class="align-middle" style="cursor: pointer;"
                                wire:key="definition-{{ $definition->id }}">
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
                                    @if ($definition->is_active === 1)
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
                                    @if ($definition->delivery_type)
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-check"></i> نعم
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-times"></i> لا
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">{{ $definition->madin }}</td>


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
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button data-bs-toggle="modal" data-bs-target="#Edit{{ $definition->id }}"
                                            class="btn btn-sm btn-icon btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- <button
                                            wire:click.prevent="$dispatch('confirm', { id: {{ $definition->id }} })"
                                            class="btn btn-sm btn-icon btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button> --}}
                                    </div>
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
                {{-- {{ $definitions->links('pagination::bootstrap-5') }} --}}
                {{ $definitions->links() }}

            </div>
        </div>

    </div>

    <!-- Add Definition Modal -->

    @script
        <script>
            Livewire.on('definitionUpdated', ({
                id
            }) => {
                const modal = document.getElementById('Edit' + id);
                if (modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }

                // Show success toast (optional)
                Toast.fire({
                    icon: 'success',
                    title: 'تم التحديث بنجاح.'
                });
            });
        </script>
    @endscript


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        document.addEventListener('livewire:load', () => {
            Livewire.on('showSuccessMessage', (message) => {
                window.Toast.fire({
                    icon: 'success',
                    title: message
                });
            });

            Livewire.on('confirm', (event) => {
                Swal.fire({
                    title: 'تأكيد الحذف',
                    text: 'هل أنت متأكد من رغبتك في حذف هذا العنصر؟ لا يمكن التراجع عن هذه العملية.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('delete', event.id);
                    }
                });
            });
        });
    </script>


</div>

<div>
    <div class="card body formtype">
        <input type="text" wire:model.live="search" class="form-control mb-3" placeholder="ابحث...">

        <div class="table-responsive">
            <table class="table table-hover">
                @php
                    $count = 1;
                @endphp
                <thead class="thead-light">
                    <tr>
                        <th class="d-none border-end">ID</th>
                        <th class="font-weight-bold  border-end">#</th>
                        <th class="font-weight-bold  border-end">أنواع</th>
                        <th class="text-center" style="width: 25%">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr class="align-middle" style="height: 42px;">
                            <td class="d-none border-end">{{ $type->id }}</td>
                            <td class="font-weight-medium border-end" style="text-align: center;width:5%">
                                {{ $count++ }}
                            </td>
                            <td class="font-weight-medium border-end">{{ $type->typename }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#Edit{{ $type->id }}"
                                        class="btn btn-sm btn-outline-primary d-flex align-items-center py-1">
                                        <i class="fas fa-edit mr-1"></i> تعديل
                                    </button>



                                    {{-- <button wire:click.prevent="$dispatch('confirm', { id: {{ $type->id }} })"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center py-1">
                                        <i class="fas fa-trash-alt mr-1"></i> حذف
                                    </button> --}}


                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="Edit{{ $type->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="padding: 10px">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel">تعديل نوع</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <livewire:types.edit :type_id="$type->id" :key="'type-edit-' . $type->id" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">
                                <i class="fas fa-info-circle mr-2"></i> لا توجد أنواع متاحة
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $types->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@script
    <script>
        $wire.on("confirm", (event) => {

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من التراجع!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "نعم، احذفه!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("delete", {
                        id: event.id
                    });
                }
            });

        });
    </script>
@endscript

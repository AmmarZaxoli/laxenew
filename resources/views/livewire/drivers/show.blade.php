<div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="d-none border-end">ID</th>
                    <th class="font-weight-bold border-end text-center">#</th>
                    <th class="font-weight-bold border-end">اسم</th>
                    <th class="font-weight-bold border-end">الهاتف</th>
                    <th class="font-weight-bold border-end">رقم السيارة</th>
                    <th class="font-weight-bold border-end">سعر التوصيل</th>
                    <th class="font-weight-bold border-end">عنوان</th>
                    <th class="text-center" style="width: 10%">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($drivers as $driver)
                    <tr class="align-middle" style="height: 42px;">
                        <td class="d-none border-end">{{ $driver->id }}</td>
                        <td class="font-weight-medium border-end text-center" style="width:5%">
                            {{ $count++ }}
                        </td>
                        <td class="font-weight-medium border-end">{{ $driver->nameDriver }}</td>
                        <td class="font-weight-medium border-end" style="width: 10%">{{ $driver->mobile }}</td>
                        <td class="font-weight-medium border-end">{{ $driver->numcar }}</td>
                        <td class="font-weight-medium border-end">{{ number_format($driver->taxiprice) }}</td>
                        <td class="font-weight-medium border-end">{{ $driver->address }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Edit Button - Now targets the correct modal -->
                                <button data-bs-toggle="modal" data-bs-target="#editModal{{ $driver->id }}"
                                    class="btn btn-sm btn-outline-primary d-flex align-items-center py-1">
                                    <i class="fas fa-edit me-1" style="font-size: 1.2rem;"></i>
                                 </button>

                                {{-- <button wire:click.prevent="deleteConfirmation({{ $driver->id }})"
                                    class="btn btn-sm btn-outline-danger d-flex align-items-center py-1">
                                    <i class="fas fa-trash-alt mr-1"></i> حذف
                                </button> --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted">
                            <i class="fas fa-info-circle me-2"></i> لا توجد أنواع متاحة
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $drivers->links('pagination::bootstrap-5') }}
    </div>

    <!-- Modals placed outside the table -->
    @foreach ($drivers as $driver)
        <div class="modal fade" id="editModal{{ $driver->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="editModalLabel{{ $driver->id }}" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="padding: 10px">
                    <div class="modal-header" class="card-header text-black py-3">
                        <h4 class="modal-title">تعديل الحساب</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('drivers.edit', ['driverId' => $driver->id], key($driver->id))
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>

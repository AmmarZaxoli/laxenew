<div>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid p-0">
                <div class="container py-3">
                    <h4 class="fw-bold">تعديل الاوفرات</h4>
                </div>

                <!-- Main Offers Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>كود</th>
                                        <th>سعر الاوفر</th>
                                        <th>إجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($offers as $offer)
                                        <tr class="align-middle">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $offer->nameoffer }}</td>
                                            <td class="text-center">{{ $offer->code }}</td>
                                            <td class="text-center">{{ number_format($offer->price) }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click="editOffer({{ $offer->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#editOfferModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                   <button class="btn btn-sm btn-outline-danger"
        wire:click="confirmRemoveOffer({{ $offer->id }})">
        <i class="fas fa-trash"></i>
    </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">لا توجد عروض متاحة</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Offer Modal -->
    <div wire:ignore.self data-bs-backdrop="static" class="modal fade" id="editOfferModal" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الاوفر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0">
                    <div class="container-fluid">
                        <div class="row g-3">
                            <!-- Search and Filter -->
                            <div class="col-12">
                                <div class="row g-3 mb-3 p-3">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" wire:model.live="search"
                                                placeholder="ابحث بالاسم أو الكود..." class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select wire:model.live="selectedType" class="form-select">
                                            <option value="">كل الانواع</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}">{{ $type->typename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Products -->
                            <div class="col-md-7">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>النوع</th>
                                                <th>الكود</th>
                                                <th>الرصيد</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($search || $selectedType)
                                                @forelse($filteredProducts as $product)
                                                    @if ($product->quantity !== null && $product->quantity !== 0 && $product->definition->is_active=='active')
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $product->definition->name ?? 'N/A' }}</td>
                                                            <td>{{ $product->definition->type->typename ?? 'N/A' }}</td>
                                                            <td>{{ $product->definition->code ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                                                    {{ $product->quantity }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $isSelected = collect($selectedProducts)->contains('id', $product->id);
                                                                @endphp
                                                                <button class="btn btn-sm btn-primary"
                                                                    wire:click="addProduct({{ $product->id }})"
                                                                    @if($isSelected) disabled @endif>
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">لا توجد منتجات</td>
                                                    </tr>
                                                @endforelse
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">ابدأ بالبحث أو اختيار النوع لعرض المنتجات</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    @if($search || $selectedType)
                                        {{ $filteredProducts->links() }}
                                    @endif
                                </div>
                            </div>

                            <!-- Selected Products -->
                            <div class="col-md-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>الكمية</th>
                                                <th>سعر الشراء</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selectedProducts as $index => $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product['name'] }}</td>
                                                    <td>
                                                        <input type="number"
                                                            wire:model="selectedProducts.{{ $index }}.quantity"
                                                            wire:change="validateQuantity({{ $index }}, $event.target.value)"
                                                            min="1"
                                                            max="{{ $product['stock'] }}"
                                                            class="form-control form-control-sm">
                                                    </td>
<td class="text-center">{{ number_format($totalBuy[$product['id']] ?? 0) }}</td>

                                                    <td>
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click="removeProduct({{ $index }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              
                </div>
        @if (count($selectedProducts) > 0)
                <div class="d-flex justify-content-end mt-3">
                    <div class="bg-light border rounded px-4 py-2 fw-bold text-end">
                        <span>مجموع الشراء:</span>
                        <span class="text-primary">
                            {{ number_format($this->getGrandTotalBuy()) }}

                        </span>
                        <span>د.ع</span>
                    </div>
                </div>
            @endif
                <!-- Modal Footer / Offer Info -->
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label">اسم الاوفر</label>
                                <input type="text" class="form-control" wire:model="nameoffer">
                                @error('nameoffer') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label">الكود</label>
                                <input type="text" class="form-control" wire:model="code">
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label">السعر</label>
                                <input type="number" class="form-control" wire:model="price">
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary flex-grow-1 flex-md-grow-0"
                            data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" class="btn btn-primary flex-grow-1 flex-md-grow-0"
                            wire:click="updateOffer">
                            <span wire:loading wire:target="updateOffer"
                                class="spinner-border spinner-border-sm"></span>
                            حفظ التغيرات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.addEventListener('confirm-remove-offer', event => {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من التراجع عن الحذف!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذف العرض!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // Change this line to use the correct syntax
                Livewire.dispatch('remove-offer', {offerId: event.detail.id});
                 Swal.fire(
                    'تم الحذف!',
                    'تم حذف العرض بنجاح.',
                    'success'
                )
            }
        });
    });
</script>

</div>
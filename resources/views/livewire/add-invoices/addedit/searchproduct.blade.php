<div>
<div>
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <!-- Search Input -->
                <div class="col-md-6" x-data="{ open: @entangle('showDropdown') }"
                    x-on:click.away="open = false; $wire.set('showDropdown', false)">
                    <label for="search" class="form-label fw-bold">بحث</label>
                    <div class="input-group">
                        <input type="search" autocomplete="off" wire:model.live="search" class="form-control"
                            placeholder="Enter product name, code or barcode..." wire:focus="$set('showDropdown', true)"
                            x-ref="searchInput">
                    </div>

                    <!-- Search Results Dropdown -->
                    @if ($showDropdown && $definitions->isNotEmpty())
                        <div class="card mt-2 shadow-lg position-absolute w-100" style="z-index: 1050;border:none">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" style="width: 47%;">
                                    @foreach ($definitions as $definition)
                                        <a href="#" class="list-group-item list-group-item-action"
                                            wire:click.prevent="selectProduct({{ $definition->id }})">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    @if ($definition->image)
                                                        <img src="{{ asset('storage/' . $definition->image) }}"
                                                            alt="{{ $definition->name }}" width="50" height="50"
                                                            class="rounded me-3 object-fit-cover">
                                                    @else
                                                        <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-box text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $definition->name }}</strong>
                                                        <div class="text-muted small">
                                                            <p>كود: {{ $definition->code }}</span>
                                                                <span class="d-none">كود:
                                                                    {{ $definition->type_id }}</span>
                                                                @if ($definition->barcode)
                                                                    <span class="ms-2 d-none">Barcode:
                                                                        {{ $definition->barcode }}</span>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-primary rounded-pill">اختار</span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                        <div class="col-md-3">
                    <label for="name" class="form-label fw-bold">اسم المنتج</label>

                    <input type="search" autocomplete="off" wire:model.live="name" class="form-control" readonly>

                </div>
                <div class="col-md-3">
                    <label for="code" class="form-label fw-bold">كود</label>

                    <input type="search" autocomplete="off" wire:model.live="code" class="form-control" readonly>

                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Definition Modal -->
    @if ($selectedProduct && $purchases->count() > 0)
        <div class="row mt-4" x-data="{ showTable: true }">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آخر عملية شراء للمنتج</h5>
                        <div>
                            <button x-show="!showTable" @click="showTable = true" class="btn btn-sm btn-success mx-1">
                                <i class="fas fa-eye"></i> عرض
                            </button>
                            <button x-show="showTable" @click="showTable = false" class="btn btn-sm btn-danger mx-1">
                                <i class="fas fa-eye-slash"></i> إخفاء
                            </button>
                        </div>
                    </div>
                    <div class="card-body" x-show="showTable" x-transition>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>اسم الزبون</th>
                                        <th>التاريخ</th>
                                        <th>سعر الشراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->buy_invoice?->num_invoice }}</td>
                                            <td>{{ $purchase->buy_invoice?->name_invoice }}</td>
                                            <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                                            <td>{{ number_format($purchase->buy_price) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>

<script>
    window.addEventListener('focus-search-input', () => {
        const input = document.getElementById('searchInput');
        if (input) {
            input.focus();
        }
    });
</script>
</div>

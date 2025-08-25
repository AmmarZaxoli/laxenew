<div class="content-container" style="position: relative; padding-top: 70px;">
    <!-- Button fixed at the top-center -->
    <button wire:click="toggleModal" class="btn position-fixed"
        style="
            width: 160px;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: linear-gradient(to right, #6366f1 0%, #4f46e5 100%);
            border: none;
            border-radius: 25px;
            padding: 6px 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: white;
            font-weight: 400;
            transition: all 0.3s ease;
        "
        onmouseover="this.style.transform='translateX(-50%) scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(0, 0, 0, 0.2)'"
        onmouseout="this.style.transform='translateX(-50%)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.1)'">
        <i class="fas fa-clipboard-check me-2"></i>
        <span>طلبات السوائق</span>
    </button>

    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index:1050;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">عدد الطلبات لكل سائق</h5>
                        <button type="button" class="btn-close" wire:click="toggleModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="createdAt" class="form-label">من تاريخ</label>
                                <input type="date" wire:model="createdAt" id="createdAt"
                                    class="form-control @error('createdAt') is-invalid @enderror">
                                @error('createdAt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="updatedAt" class="form-label">إلى تاريخ</label>
                                <input type="date" wire:model="updatedAt" id="updatedAt"
                                    class="form-control @error('updatedAt') is-invalid @enderror">
                                @error('updatedAt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <button type="button" class="btn btn-outline-primary py-2 px-4 shadow-sm"
                                    wire:loading.attr="disabled" style="margin-top: 5px"
                                    wire:target="filterByDate" wire:click="filterByDate">
                                    <span wire:loading.remove wire:target="filterByDate">
                                        <i class="fas fa-search me-2"></i> بحث
                                    </span>
                                    <span wire:loading wire:target="filterByDate">
                                        <i class="fas fa-spinner fa-spin me-2"></i>
                                        جاري البحث...
                                    </span>
                                </button>
                            </div>
                        </div>

                        @error('dateFilter')
                            <div class="alert alert-danger mb-3">{{ $message }}</div>
                        @enderror

                        <div class="table-responsive">
                            <!-- ✅ Total Orders -->
                            <div class="mb-3">
                                <strong>مجموع عدد الطلبات: </strong> {{ $totalOrders }}
                            </div>

                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr style="text-align: center;">
                                        <th>اسم السائق</th>
                                        <th>عدد الطلبات</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($drivers as $driver)
                                        <tr style="text-align: center;">
                                            <td>{{ $driver->nameDriver }}</td>
                                            <td>{{ $driver->orders_count }}</td>
                                            <td>
                                                {{ optional($driver->customers->first())->date_sell
                                                    ? \Carbon\Carbon::parse($driver->customers->first()->date_sell)->format('Y-m-d')
                                                    : 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                @if ($createdAt || $updatedAt)
                                                    لا توجد بيانات في الفترة المحددة
                                                @else
                                                    لا توجد بيانات اليوم
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="toggleModal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

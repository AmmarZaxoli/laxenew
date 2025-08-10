<div class="content-container" style="position: relative; padding-top: 70px;">
    <!-- Button fixed at the top-center -->
    <button wire:click="toggleModal" class="btn position-fixed" style="
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

    @if($showModal)
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
                                <input type="date" wire:model.lazy="createdAt" id="createdAt"
                                    class="form-control @error('createdAt') is-invalid @enderror">
                                @error('createdAt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="updatedAt" class="form-label">إلى تاريخ</label>
                                <input type="date" wire:model.lazy="updatedAt" id="updatedAt"
                                    class="form-control @error('updatedAt') is-invalid @enderror">
                                @error('updatedAt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        @error('dateFilter') <div class="alert alert-danger mb-3">{{ $message }}</div> @enderror

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>اسم السائق</th>
                                        <th>عدد الطلبات</th>
                                        <th>آخر تحديث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($drivers as $driver)
                                        <tr>
                                            <td>{{ $driver->nameDriver }}</td>
                                            <td>{{ $driver->invoices_count }}</td>
                                            <td>
                                                {{ optional($driver->invoices->first())->date_sell ? $driver->invoices->first()->date_sell->format('Y-m-d H:i') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                @if($this->createdAt || $this->updatedAt)
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
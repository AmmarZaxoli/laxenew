<div>
    <div class="card" style="padding: 10px">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="fas fa-file-invoice text-primary me-2"></i>
                تعديل الفاتورة رقم: <?php echo e($invoice->num_invoice); ?>

            </h2>
            <h1><?php echo e($invoice->name_invoice); ?></h1>
            <div>
                
                <button wire:click="toggleAddForm" class="btn btn-outline-success">
                    <i class="fas fa-plus me-1"></i> إضافة منتج
                </button>

            </div>
        </div>

        <div class="input-group mb-3">
            <input type="search" autocomplete="off" wire:model.live.debounce.500ms="search" class="form-control"
                placeholder="ابحث باسم المنتج أو الباركود...">
            
        </div>

        <div wire:loading.delay wire:target="search" class="text-center py-2">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جاري البحث...</span>
            </div>
        </div>

        

        

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 25%">الاسم</th>
                                <th class="text-center" style="width: 15%">code</th>
                                <th class="text-center" style="width: 10%">كمية بيع</th>
                                <th class="text-center" style="width: 10%">الكمية</th>
                                <th class="text-center" style="width: 15%">سعر الشراء</th>
                                <th class="text-center" style="width: 20%">تاريخ الانتهاء</th>
                                <th class="text-center" style="width: 20%">Edit</th>
                                <th class="text-center" style="width: 20%">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="text" readonly class="form-control-plaintext text-center"
                                            value="<?php echo e($product->name); ?>">
                                    </td>
                                    <td class="text-center align-middle text-muted"><?php echo e($product->code); ?></td>
                                    <td class="text-center align-middle text-muted"><?php echo e($product->q_sold); ?></td>
                                    <td class="text-center align-middle text-muted"><?php echo e($product->quantity); ?></td>
                                    <td class="text-center align-middle text-muted"><?php echo e($product->buy_price); ?></td>
                                    <td class="text-center align-middle text-muted"><?php echo e($product->dateex); ?></td>
                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <button wire:click="editProduct(<?php echo e($product->buy_product_invoice_id); ?>)"
                                            class="btn btn-sm btn-primary">
                                            تعديل
                                        </button>




                                    </td>
                                    <td class="text-center">
                                        <!-- Delete Button -->
                                        <button
                                            wire:click="deleteConfirmationproduct(<?php echo e($product->buy_product_invoice_id); ?>)"
                                            class="btn btn-sm btn-outline-danger d-flex align-items-center py-1">
                                            <i class="fas fa-trash-alt mr-1"></i> حذف
                                        </button>



                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="invoice-summary-container mb-5">
            <div class="row gy-3">
                <!-- Total Price -->
                <div class="col-12 col-sm-6 col-lg">
                    <div class="summary-card total-card">
                        <div class="card-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">إجمالي الفاتورة</div>
                            <div class="card-value"><?php echo e(number_format($this->totalPrice)); ?> </div>
                        </div>
                    </div>
                </div>

                <!-- Discount -->
                <div class="col-6 col-sm-3 col-lg">
                    <div class="summary-card discount-card">
                        <div class="card-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">الخصم</div>
                            <div class="card-value"><?php echo e($this->discount); ?><span>%</span></div>
                        </div>
                    </div>
                </div>

                <!-- After Discount -->
                <div class="col-6 col-sm-3 col-lg">
                    <div class="summary-card net-card">
                        <div class="card-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">الصافي</div>
                            <div class="card-value"><?php echo e(number_format($this->afterDiscountTotalPrice)); ?> </div>
                        </div>
                    </div>
                </div>

                <!-- Paid Amount -->
                <div class="col-6 col-sm-4 col-lg">
                    <div class="summary-card paid-card">
                        <div class="card-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">المدفوع</div>
                            <div class="card-value"><?php echo e(number_format($this->cash)); ?> </div>
                        </div>
                    </div>
                </div>

                <!-- Remaining -->
                <div class="col-6 col-sm-4 col-lg">
                    <div class="summary-card remaining-card">
                        <div class="card-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-content">
                            <div class="card-label">المتبقي</div>
                            <div class="card-value"><?php echo e(number_format($this->residual)); ?> </div>
                        </div>
                    </div>
                </div>
            </div>



            <div wire:ignore.self class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true"
                dir="rtl">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg">
                        <!-- Modal Header -->
                        <div class="modal-header bg-light">
                            <h5 class="modal-title text-dark">
                                <i class="fas fa-edit text-primary me-2"></i>
                                تعديل المنتج
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="إغلاق"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <form wire:submit.prevent="updateProduct">
                                <!-- Row 1: Name and Code -->
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label text-muted small mb-1">الاسم</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="fas fa-tag text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-2"
                                                wire:model="editName">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">الكود</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="fas fa-barcode text-muted"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0 ps-2"
                                                wire:model="editCode">
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 2: Quantity and Price -->
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="form-label text-muted small mb-1">الكمية</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="fas fa-boxes text-muted"></i>
                                            </span>
                                            <input type="number" class="form-control border-start-0 ps-2"
                                                wire:model="editQuantity">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">سعر الشراء</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="fas fa-money-bill-wave text-muted"></i>
                                            </span>
                                            <input type="number" step="0.01"
                                                class="form-control border-start-0 ps-2" wire:model="editBuyPrice">
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3: Expiry Date -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label text-muted small mb-1">تاريخ الانتهاء</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="fas fa-calendar-day text-muted"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 ps-2"
                                                wire:model="editDateex">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2">
                                        <i class="fas fa-save me-2"></i> حفظ التعديلات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .modal-content {
                    border-radius: 10px;
                }

                .input-group-text {
                    transition: all 0.2s ease;
                }

                .form-control:focus+.input-group-text,
                .form-control:focus~.input-group-text {
                    color: #4e73df;
                }

                .form-control {
                    border-left: none !important;
                }

                .form-control:focus {
                    box-shadow: none;
                    border-color: #dee2e6;
                }
            </style>
            <style>
                .invoice-summary-container {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }

                .summary-card {
                    background: white;
                    border-radius: 12px;
                    padding: 1rem;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                    border: 1px solid #f0f0f0;
                    transition: all 0.3s ease;
                }

                .summary-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
                }

                .card-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-left: 12px;
                    flex-shrink: 0;
                }

                .card-content {
                    flex-grow: 1;
                }

                .card-label {
                    color: #666;
                    font-size: 0.9rem;
                    margin-bottom: 4px;
                }

                .card-value {
                    font-weight: 700;
                    font-size: 1.4rem;
                    color: #333;
                }

                .card-value span {
                    font-size: 0.9rem;
                    color: #888;
                    margin-right: 4px;
                }

                /* Card Specific Styles */
                .total-card .card-icon {
                    background-color: rgba(41, 98, 255, 0.1);
                    color: #2962FF;
                }

                .discount-card .card-icon {
                    background-color: rgba(255, 171, 0, 0.1);
                    color: #FFAB00;
                }

                .net-card .card-icon {
                    background-color: rgba(0, 200, 83, 0.1);
                    color: #00C853;
                }

                .paid-card .card-icon {
                    background-color: rgba(233, 30, 99, 0.1);
                    color: #E91E63;
                }

                .remaining-card .card-icon {
                    background-color: rgba(156, 39, 176, 0.1);
                    color: #9C27B0;
                }

                /* Responsive Adjustments */
                @media (max-width: 576px) {
                    .card-value {
                        font-size: 1.2rem;
                    }

                    .card-icon {
                        width: 40px;
                        height: 40px;
                        font-size: 0.9rem;
                    }
                }
            </style>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <label for="note" class="form-label">ملاحظة</label>
                    <textarea wire:model="note" class="form-control" id="note" rows="3"
                        placeholder="أضف ملاحظة إذا لزم الأمر..."></textarea>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </div>
    <script>
        window.addEventListener('open-edit-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            modal.show();
        });

        window.addEventListener('close-edit-modal', () => {
            var modalEl = document.getElementById('editProductModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>

</div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/add-invoices/edit.blade.php ENDPATH**/ ?>
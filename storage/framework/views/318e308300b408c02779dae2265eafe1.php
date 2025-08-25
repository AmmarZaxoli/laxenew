<div>

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 280px;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }



        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            margin-bottom: 24px;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 16px 20px;
            font-weight: 700;
            color: var(--dark);
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            font-size: 18px;
            font-weight: 400;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #4a5568;
            font-size: 14px;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            color: var(--danger);
            border-color: var(--danger);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger);
            color: white;
            transform: translateY(-2px);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            padding: 12px 15px;
            font-size: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            font-size: 17px;
            font-weight: 500;
        }

        .table tr:hover td {
            background-color: #f8fafc;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;

        }

        .input-actions {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 5px;
        }

        .quick-select-btn {
            padding: 4px 10px;
            font-size: 0.8rem;
            border-radius: 6px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: var(--transition);
        }

        .quick-select-btn:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        .suggestion-list {
            max-height: 200px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 1050;
        }

        .suggestion-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f1f5f9;
            transition: var(--transition);
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f1f5f9;
        }

        .form-check-input {
            width: 3em;
            height: 1.5em;
        }

        .form-check-label {
            font-weight: 600;
        }

        .text-success {
            color: #10b981 !important;
        }

        .text-danger {
            color: #ef4444 !important;
        }

        .summary-card {
            background: linear-gradient(135deg, #f6f9fc 0%, #ffffff 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
        }

        .badge-notification {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .product-image:hover {
            transform: scale(1.8);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 10;
            position: relative;
        }

        .fa-phone {

            color: #10b981;
        }

        .fa-map-marker-alt,
        .fa-tag,
        .fa-sticky-note {

            color: #4895ef;
        }

        .fa-taxi {

            color: #dfcf79;
        }

        .fa-code {
            color: rgb(255, 62, 62);
        }

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animation for new invoice button */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-pulse {
            animation: pulse 2s infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header h5 {
                font-size: 1.1rem;
            }

            .btn {
                padding: 8px 16px;
            }

            .input-actions {
                position: relative;
                margin-top: 8px;
                justify-content: center;
                left: 0;
                transform: none;
            }

            .input-container {
                flex-direction: column;
            }
        }
    </style>



    <div class="container-fluid py-4 body">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">فاتورة مبيعات جديدة</h5>
                        <div class="badge bg-primary p-2">
                            <i class="fas fa-receipt me-1"></i>
                            نظام المبيعات
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Invoice Number -->
                            <div class="col-md-3 mb-3">
                                <label for="nextInvoice" class="form-label">رقم الفاتورة</label>
                                <input type="text" name="numList" id="nextInvoice" class="form-control"
                                    value="<?php echo e($numsellinvoice); ?>" readonly required>
                            </div>

                            <!-- New Invoice Button -->
                            <div class="col-md-3 mb-3  align-items-end" style="margin-top: 56px">
                                <!--[if BLOCK]><![endif]--><?php if($showNewButton): ?>
                                    <button id="getNextInvoiceBtn"
                                        class="btn btn-outline-primary d-flex align-items-center"
                                        wire:click="makesellInvoice" wire:loading.attr="disabled" type="button"
                                        style="margin-top: -15px">

                                        <!-- Spinner shows only while loading -->
                                        <span wire:loading class="spinner-border spinner-border-sm me-1" role="status"
                                            aria-hidden="true"></span>

                                        <i class="fas fa-plus-circle me-1"></i> فاتورة جديدة
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Date and Time -->
                            <div class="col-md-6 mb-3">
                                <label for="dateBuy" class="form-label">التاريخ والوقت</label>
                                <input type="datetime-local" name="dateBuy" id="dateBuy" class="form-control"
                                    wire:model="date_sell">
                            </div>



                            <!-- Mobile Input with Suggestions -->
                            <div class="col-md-6 mb-3 position-relative">
                                <label for="mobileInput" class="form-label">الهاتف</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" id="mobileInput" wire:model.live="mobile" class="form-control"
                                        autocomplete="off" placeholder="اكتب رقم الهاتف">
                                </div>

                                <!--[if BLOCK]><![endif]--><?php if(!empty($phoneSuggestions) && $showSuggestions): ?>
                                    <div class="suggestion-list position-absolute w-100 mt-1">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $phoneSuggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="suggestion-item bg-white"
                                                wire:click="selectPhone('<?php echo e($suggestion->mobile); ?>')">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-medium"><?php echo e($suggestion->mobile); ?></span>
                                                    <small class="text-muted"><?php echo e($suggestion->address); ?></small>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">العنوان</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" wire:model="address" class="form-control"
                                        placeholder="يتم ملؤه تلقائياً إن وجد">
                                </div>
                            </div>

                            <!-- Driver Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="nameDriver" class="form-label">اسم السائق</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-taxi"></i></span>
                                    <select id="nameDriver" wire:model.live="selected_driver" class="form-select">
                                        <option value="">اختر السائق</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->nameDriver); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>
                            </div>

                            <!-- Taxi Price -->
                            <div class="col-md-6 mb-3">
                                <label for="pricetaxi" class="form-label">أجرة التكسي</label>
                                <div class="input-container">
                                    <input type="number" id="pricetaxi" name="price" class="form-control ps-5"
                                        wire:model.live="pricetaxi" min="0" step="1000"
                                        @blur="$wire.set('pricetaxi', $event.target.value || 0)">
                                    <div class="input-actions">
                                        <button type="button" class="quick-select-btn"
                                            @click="$wire.set('pricetaxi', 3000)">3K</button>
                                        <button type="button" class="quick-select-btn"
                                            @click="$wire.set('pricetaxi', 4000)">4K</button>
                                        <button type="button" class="quick-select-btn"
                                            @click="$wire.set('pricetaxi', 5000)">5K</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Barcode -->
                            <div class="col-md-6 mb-3">
                                <label for="searchInput" class="form-label">الباركود</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="أدخل باركود المنتج" wire:model.defer="barcodeInput"
                                        wire:keydown.enter.prevent="addProductByBarcode" autocomplete="off">
                                </div>
                            </div>

                            <!-- Product Code -->
                            <div class="col-md-6 mb-3">
                                <label for="productCode" class="form-label">كود المنتج</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                    <input type="text" name="code" id="productCode"
                                        wire:model.live='search_code_name' autocomplete="off" class="form-control"
                                        placeholder="الكود المنتج">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Product Type -->
                            <div class="col-md-6 mb-3">
                                <label for="type-select" class="form-label">النوع</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select id="type-select" name="type_id" class="form-select"
                                        wire:model.live="selected_type">
                                        <option value="">اختر الأنواع</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($type->id); ?>"><?php echo e($type->typename); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="col-md-6 mb-3">
                                <label for="customerNote" class="form-label">ملاحظة</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                    <input type="text" name="note" id="customerNote" class="form-control"
                                        wire:model="note" placeholder="ملاحظة">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="button"
                                    class="btn btn-outline-primary d-flex align-items-center justify-content-center py-2"
                                    wire:click="offersshow">
                                    <i class="fas fa-percentage me-2"></i> العروض
                                </button>
                            </div>

                            <!-- Payment Toggle -->
                            <div class="col-md-6 mb-3 d-flex justify-content-end">
                                <div class="form-check form-switch d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" role="switch" id="cashToggle"
                                        wire:model.live="cashornot">
                                    <label class="form-check-label ms-2 fw-bold" for="cashToggle">
                                        <span x-text="$wire.cashornot ? 'نقدي' : 'آجل'"
                                            :class="$wire.cashornot ? 'text-success' : 'text-danger'"></span>
                                        <i
                                            x-bind:class="$wire.cashornot ? 'fas fa-money-bill-wave text-success ms-1' :
                                                'far fa-credit-card text-danger ms-1'"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Available Products -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">المنتجات المتاحة</h5>
                        <span class="badge bg-info"><?php echo e($products->count()); ?></span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th class="text-center">الباركود</th>
                                        <th class="text-center">الكود</th>
                                        <th class="text-center">المخزون</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الصورة</th>
                                        <th class="text-center">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="product-row" wire:click="addProduct(<?php echo e($product->id); ?>)">
                                            <td><?php echo e($product->definition->name); ?></td>
                                            <td class="text-center"><?php echo e($product->definition->barcode); ?></td>
                                            <td class="text-center"><?php echo e($product->definition->code); ?></td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-<?php echo e($product->quantity > 0 ? 'success' : 'danger'); ?>">
                                                    <?php echo e($product->quantity); ?>

                                                </span>
                                            </td>
                                            <td class="text-center"><?php echo e(number_format($product->price_sell)); ?></td>
                                            <td class="text-center">
                                                <!--[if BLOCK]><![endif]--><?php if($product->definition->image && file_exists(public_path('storage/' . $product->definition->image))): ?>
                                                    <img src="<?php echo e(asset('storage/' . $product->definition->image)); ?>"
                                                        class="product-image" data-bs-toggle="modal"
                                                        data-bs-target="#imageModal<?php echo e($product->definition->id); ?>"
                                                        alt="صورة المنتج">
                                                <?php else: ?>
                                                    <span class="text-muted small">لا يوجد</span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click.stop="addProduct(<?php echo e($product->id); ?>)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">لا توجد منتجات
                                                متاحة</td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offers -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">العروض</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning me-2"><?php echo e($offers ? count($offers) : 0); ?></span>
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" wire:model.live='search_offer' autocomplete="off"
                                    class="form-control" placeholder="ابحث بالاسم أو الكود">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>المنتج</th>
                                        <th class="text-center">الكود</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($offers)): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr class="offer-row" wire:click="addOffer(<?php echo e($offer['id']); ?>)">
                                                <td><?php echo e($offer['nameoffer']); ?></td>
                                                <td class="text-center"><?php echo e($offer['code']); ?></td>
                                                <td class="text-center"><?php echo e(number_format($offer['price'])); ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        wire:click.stop="addOffer(<?php echo e($offer['id']); ?>)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">لا توجد
                                                    عروض متاحة</td>
                                            </tr>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Selected Products -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">المنتجات المحددة</h5>
                        <span class="badge bg-primary"><?php echo e(count($selectedProducts)); ?></span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>اسم المنتج</th>
                                        <th class="text-center">الكود</th>
                                        <th class="text-center">الكمية</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الإجمالي</th>
                                        <th class="text-center">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $selectedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($product['name']); ?></td>
                                            <td class="text-center"><?php echo e($product['code']); ?></td>
                                            <td class="text-center">
                                                <input type="number"
                                                    wire:change="updateQuantity(<?php echo e($product['id']); ?>, $event.target.value)"
                                                    value="<?php echo e($product['quantity']); ?>" min="1"
                                                    max="<?php echo e($dd); ?>"
                                                    class="form-control form-control-sm text-center mx-auto"
                                                    style="width: 70px;">
                                            </td>
                                            <td class="text-center"><?php echo e(number_format($product['price'])); ?></td>
                                            <td class="text-center"><?php echo e(number_format($product['total'])); ?></td>
                                            <td class="text-center">
                                                <button wire:click="removeProduct(<?php echo e($product['id']); ?>)"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">لم يتم اختيار
                                                منتجات بعد</td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selected Offers -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">العروض المحددة</h5>
                        <span class="badge bg-success"><?php echo e(count($selectedoffer)); ?></span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>اسم العرض</th>
                                        <th class="text-center">الكود</th>
                                        <th class="text-center">الكمية</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الإجمالي</th>
                                        <th class="text-center">الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $selectedoffer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($offer['nameoffer']); ?></td>
                                            <td class="text-center"><?php echo e($offer['code']); ?></td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <button wire:loading.attr="disabled"
                                                        wire:target="decrementOffer(<?php echo e($offer['id']); ?>)"
                                                        wire:click="decrementOffer(<?php echo e($offer['id']); ?>)"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        <?php if($offer['quantity'] <= 0): echo 'disabled'; endif; ?>>
                                                        <span wire:loading.remove
                                                            wire:target="decrementOffer(<?php echo e($offer['id']); ?>)">-</span>
                                                        <span wire:loading
                                                            wire:target="decrementOffer(<?php echo e($offer['id']); ?>)">
                                                            <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                        </span>
                                                    </button>

                                                    <span class="mx-2 fw-bold"><?php echo e($offer['quantity']); ?></span>

                                                    <button wire:loading.attr="disabled"
                                                        wire:target="incrementOffer(<?php echo e($offer['id']); ?>)"
                                                        wire:click="incrementOffer(<?php echo e($offer['id']); ?>)"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <span wire:loading.remove
                                                            wire:target="incrementOffer(<?php echo e($offer['id']); ?>)">+</span>
                                                        <span wire:loading
                                                            wire:target="incrementOffer(<?php echo e($offer['id']); ?>)">
                                                            <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-center"><?php echo e(number_format($offer['price'])); ?></td>
                                            <td class="text-center">
                                                <?php echo e(number_format($offer['quantity'] * $offer['price'])); ?></td>
                                            <td class="text-center">
                                                <button wire:loading.attr="disabled"
                                                    wire:target="removeOffer(<?php echo e($offer['id']); ?>)"
                                                    wire:click="removeOffer(<?php echo e($offer['id']); ?>)"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <span wire:loading.remove
                                                        wire:target="removeOffer(<?php echo e($offer['id']); ?>)">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <span wire:loading wire:target="removeOffer(<?php echo e($offer['id']); ?>)">
                                                        <i class="fas fa-spinner fa-spin fa-xs"></i>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">لم يتم اختيار
                                                عروض بعد</td>
                                        </tr>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary and Actions -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">
                    <!-- Summary Card -->
                    <div class="summary-card" style="width: 500px">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted">الإجمالي الفرعي:</span>
                            <span class="fw-bold fs-5"><?php echo e(number_format($this->totalPrice)); ?> د.ع</span>
                        </div>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted">الخصم:</span>
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="number" class="form-control form-control-sm border-danger text-center"
                                    wire:model.live="discount" min="0" step="1000">
                                <span class="input-group-text">د.ع</span>
                            </div>
                        </div>

                        <div class="pt-3 mt-3 border-top d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">الإجمالي النهائي:</span>
                            <span class="fw-bold text-success fs-4">
                                <?php echo e(number_format($generalprice)); ?> د.ع
                            </span>
                        </div>
                    </div>

                    <!-- Free Delivery Message -->
                    <!--[if BLOCK]><![endif]--><?php if($delivery_type == 1): ?>
                        <div class="d-flex align-items-center justify-content-center text-success fw-bold fs-5 px-4">
                            <i class="fas fa-truck me-2"></i> توصيل مجاني
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column gap-3">
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" wire:model="printAfterSave">
                            <label class="form-check-label fw-bold">طباعة بعد الحفظ</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit"
                                class="btn btn-outline-primary d-flex align-items-center justify-content-center py-2 px-4"
                                wire:loading.attr="disabled" wire:target="gitprofit" wire:click="gitprofit">
                                <span wire:loading.remove wire:target="gitprofit">
                                    <i class="fas fa-save me-2"></i> حفظ الفاتورة
                                </span>
                                <span wire:loading wire:target="gitprofit">
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                </span>
                            </button>

                            <button type="button"
                                class="btn btn-outline-danger d-flex align-items-center justify-content-center py-2 px-4"
                                wire:loading.attr="disabled" wire:target="refresh" wire:click="refresh">
                                <span wire:loading.remove wire:target="refresh">
                                    <i class="fas fa-trash-alt me-2"></i> مسح
                                </span>
                                <span wire:loading wire:target="refresh">
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <iframe id="printFrame" style="display:none;"></iframe>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('trigger-print', (url) => {
                const iframe = document.getElementById('printFrame');
                iframe.src = '';

                setTimeout(() => {
                    iframe.src = url;
                    iframe.onload = function() {
                        try {
                            iframe.contentWindow.focus();
                            iframe.contentWindow.print();
                        } catch (e) {
                            console.error("Printing failed:", e);
                        }
                    };
                }, 50);
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', function(event) {
                const input = document.getElementById('mobileInput');
                const suggestionList = document.querySelector('.suggestion-list');

                if (suggestionList && !suggestionList.contains(event.target) && event.target !== input) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('showSuggestions', false);
                }
            });
        });

        window.addEventListener('confirm-wrong-mobile', () => {
            Swal.fire({
                title: "تحذير",
                text: "رقم الهاتف غير صحيح (يجب أن يكون 11 رقم). هل تريد الاستمرار؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "نعم، استمر",
                cancelButtonText: "إلغاء",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('ignore-mobile-check');
                }
            });
        });
    </script>


</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/selling/sell.blade.php ENDPATH**/ ?>
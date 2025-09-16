<div>
    <div class="order-dashboard">
        <div class="dashboard-header d-flex ">
            <div class="row g-6 w-100">
                <!-- Phone Number Search -->
                <div class="col-md-4 mb-3">
                    <label for="phoneNumber" class="dashboard-title">رقم الهاتف</label>
                    <div class="input-group">
                        <input type="text" id="phoneNumber" wire:model="phoneNumber" class="form-control"
                               placeholder="ادخل رقم الهاتف">
                        <button class="btn btn-outline-secondary" wire:click="searchOrders">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- From Date -->
                <div class="col-md-3 col-sm-12">
                    <label for="from_date" class="dashboard-title">من تاريخ</label>
                    <input type="date" id="from_date" wire:model="from_date" class="form-control">
                </div>

                <!-- To Date -->
                <div class="col-md-3 col-sm-12">
                    <label for="to_date" class="dashboard-title">إلى تاريخ</label>
                    <input type="date" id="to_date" wire:model="to_date" class="form-control">
                </div>

                <!-- Search Button -->
                <div class="col-md-2 col-sm-12 d-flex align-items-end">
                    <button class="btn btn-primary w-100" wire:click="searchOrders">
                        بحث
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <!--[if BLOCK]><![endif]--><?php if($loading): ?>
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">جاري تحميل الطلبات...</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Orders Table -->
        <div class="table-wrapper">
            <!--[if BLOCK]><![endif]--><?php if(!empty($orders)): ?>
                <div class="p-3 bg-light border-bottom">
                    <strong>عدد الطلبات: <?php echo e($totalOrders); ?></strong>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($phoneNumber) || !empty($from_date) || !empty($to_date)): ?>
                        <span class="text-muted"> (تم التصفية)</span>
                        <button class="btn btn-sm btn-outline-secondary ms-2" wire:click="resetSearch">
                            إعادة تعيين
                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">رقم التليفون</th>
                            <th class="text-center">عنوان</th>
                            <th class="text-center">طريقة الدفع</th>
                            <th class="text-center">تاريخ الشراء</th>
                            <th class="text-center">السعر الإجمالي</th>
                            <th class="text-center">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e(($currentPage - 1) * $perPage + $loop->iteration); ?></td>
                                <td class="text-center"><?php echo e($order['phoneNumber'] ?? 'N/A'); ?></td>
                                <td class="text-center"><?php echo e($order['address']['location'] ?? 'N/A'); ?></td>
                                <td class="font-medium text-center">
                                    <!--[if BLOCK]><![endif]--><?php if($order['paymentMethod'] === 'BY_CASH'): ?>
                                        نقداً
                                    <?php elseif($order['paymentMethod'] === 'CARD'): ?>
                                        بطاقة
                                    <?php else: ?>
                                        <?php echo e($order['paymentMethod']); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="text-center">
                                    <?php echo e(\Carbon\Carbon::parse($order['createdAt'])->format('d M Y, H:i')); ?>

                                </td>
                                <td class="text-center font-semibold"><?php echo e(number_format($order['total'])); ?> د.ع</td>
                                <td class="text-center">
                                    <span class="status-tag completed">معتمد</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h3>لا توجد طلبات معتمدة</h3>
                    <p>لا توجد حالياً أي طلبات معتمدة للعرض.</p>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($phoneNumber) || !empty($from_date) || !empty($to_date)): ?>
                        <button class="btn btn-primary mt-3" wire:click="resetSearch">
                            إعادة تعيين البحث
                        </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Pagination -->
        <?php if(!empty($orders) && $totalOrders > $perPage): ?>
            <div class="pagination-wrapper">
                <div class="desktop-pagination">
                    <div class="pagination-info">
                        عرض <span><?php echo e(($currentPage - 1) * $perPage + 1); ?></span>
                        إلى <span><?php echo e(min($currentPage * $perPage, $totalOrders)); ?></span>
                        من <span><?php echo e($totalOrders); ?></span> طلب
                    </div>

                    <nav class="pagination-controls">
                        <button wire:click="previousPage" <?php if($currentPage <= 1): ?> disabled <?php endif; ?>
                            class="pagination-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= $this->totalPages; $i++): ?>
                            <button wire:click="gotoPage(<?php echo e($i); ?>)"
                                class="<?php echo e($i == $currentPage ? 'active' : ''); ?>">
                                <?php echo e($i); ?>

                            </button>
                        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->

                        <button wire:click="nextPage" <?php if($currentPage >= $this->totalPages): ?> disabled <?php endif; ?>
                            class="pagination-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #f43f5e;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
        }

        .order-dashboard {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dark);
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 1.5rem;
            display: flex;
            align-items: center;
        }

        .dashboard-title {
            font-size: 1rem;
            color: white;
            margin-bottom: 8px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            padding: 1rem;
            text-align: left;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-dark);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: var(--light);
            border-bottom: 1px solid var(--gray-light);
            font-family: 'Times New Roman', Times, serif;
        }

        .orders-table td {
            padding: 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--gray-light);
            vertical-align: middle;
        }

        .orders-table tr:hover {
            background-color: rgba(99, 102, 241, 0.05);
        }

        .status-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-tag.completed {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 1rem;
            color: var(--gray);
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .empty-state p {
            font-size: 0.875rem;
            color: var(--gray);
            margin: 0;
        }

        .pagination-wrapper {
            padding: 1rem;
            border-top: 1px solid var(--gray-light);
        }

        .desktop-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .pagination-info span {
            font-weight: 600;
            color: var(--dark);
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination-controls button {
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--gray-light);
            border-radius: 6px;
            background-color: white;
            color: var(--dark);
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-controls button:hover:not(:disabled) {
            background-color: var(--light);
            border-color: var(--gray);
        }

        .pagination-controls button.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .pagination-controls button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-arrow svg {
            width: 1rem;
            height: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .desktop-pagination {
                flex-direction: column;
                gap: 1rem;
            }
            
            .dashboard-header .row {
                flex-direction: column;
            }
            
            .dashboard-header .col-md-4,
            .dashboard-header .col-md-3,
            .dashboard-header .col-md-2 {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .orders-table th, 
            .orders-table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
</div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/getAPI/approved.blade.php ENDPATH**/ ?>
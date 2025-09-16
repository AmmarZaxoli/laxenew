<div>
    <div>
    <div class="order-dashboard">
        <div class="dashboard-header d-flex ">
            <div class="row g-6 w-100">
                <!-- Driver Selection -->
                <div class="col-md-4 mb-3">
                    <label for="nameDriver" class="dashboard-title">اسم السائق</label>
                    <div class="input-group">
                        <select id="nameDriver" wire:model.live="selected_driver" class="form-select">
                            <option value="">اختر السائق</option>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->nameDriver); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Date picker -->
                <div class="col-md-4 col-sm-12">
                    <label for="date_sell" class="dashboard-title">تاريخ البيع</label>
                    <input type="date" id="date_sell" wire:model.live="date_sell" class="form-control">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="pricetaxi" class="dashboard-title">سعر التوصيل</label>
                    <input type="number" id="pricetaxi" name="price" class="form-control"
                        wire:model.live="pricetaxi" min="0" step="1000" required>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <?php if($loading): ?>
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">جاري تحميل الطلبات...</p>
        </div>
        <?php endif; ?>

        <!-- Orders Table -->
        <div class="table-wrapper">
            <?php if(!empty($orders)): ?>
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
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($order['status'] === 'APPROVED'): ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center"><?php echo e($order['phoneNumber'] ?? 'N/A'); ?></td>
                                    <td class="text-center"><?php echo e($order['address']['location'] ?? 'N/A'); ?></td>
                                    <td class="font-medium text-center">
                                        <?php if($order['paymentMethod'] === 'BY_CASH'): ?>
                                            نقداً
                                        <?php elseif($order['paymentMethod'] === 'CARD'): ?>
                                            بطاقة
                                        <?php else: ?>
                                            <?php echo e($order['paymentMethod']); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\Carbon\Carbon::parse($order['createdAt'])->format('d M Y, H:i')); ?>

                                    </td>
                                    <td class="text-center font-semibold"><?php echo e(number_format($order['total'])); ?> د.ع</td>
                                    <td class="text-center">
                                        <span class="status-tag completed">معتمد</span>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                </div>
            <?php endif; ?>
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

                        <?php $__currentLoopData = range(1, $totalPages); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button wire:click="gotoPage(<?php echo e($i); ?>)"
                                class="<?php echo e($i == $currentPage ? 'active' : ''); ?>">
                                <?php echo e($i); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <button wire:click="nextPage" <?php if($currentPage >= $totalPages): ?> disabled <?php endif; ?>
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
        <?php endif; ?>
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
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
        }

        .dashboard-title {
            font-size: 1.3rem;
            color: white;
            margin: 0 5px 10px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-dark);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: var(--light);
            border-bottom: 1px solid var(--gray-light);
            font-family:'Times New Roman', Times, serif;
        }

        .orders-table td {
            padding: 1rem 1.5rem;
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
            padding: 1rem 2rem;
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
            
            .dashboard-header .col-md-4 {
                width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
</div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\getAPI\approved.blade.php ENDPATH**/ ?>
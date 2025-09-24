<div>
    <div class="order-dashboard">
        <div class="dashboard-header d-flex ">
            <div class="row g-6 w-100">


                <!-- Button -->
                <div class="mb-3 d-flex gap-2">
                    <button class="btn-delivered" wire:click="markDelivered">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-truck me-1" viewBox="0 0 16 16">
                            <path
                                d="M0 1a1 1 0 0 1 1-1h9.5a1 1 0 0 1 1 1V2h2.293a1 1 0 0 1 .707.293l1.707 1.707A1 1 0 0 1 16 4.707V8h-1.5A1.5 1.5 0 0 0 13 9.5v1A1.5 1.5 0 0 0 14.5 12h1v1a1 1 0 0 1-1 1H14a2 2 0 1 1-4 0H6a2 2 0 1 1-4 0H1a1 1 0 0 1-1-1V1zm1 1v9h2a2 2 0 1 1 4 0h4a2 2 0 1 1 4 0h.5v-2h-1.5A1.5 1.5 0 0 0 13 8.5v-1A1.5 1.5 0 0 0 14.5 6H16V4.707l-1.707-1.707A1 1 0 0 0 13.293 3H11v1a1 1 0 0 1-1 1H2zm2.5 6a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm7 0a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                        </svg>
                        تغيير الحالة إلى Delivered
                    </button>

                    <span class="align-self-center" style="color: white">
                        <?php echo e(count($selectedOrders)); ?> صف/صفوف محددة
                    </span>
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
        <table class="orders-table" wire:key="orders-table">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" wire:model.live="selectAll">
                    </th>
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
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr wire:key="order-<?php echo e($index); ?>">
                        <td class="text-center">
                            <input type="checkbox" wire:model.live="selectedOrders" value="<?php echo e($order['id']); ?>" style="cursor: pointer">
                        </td>
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
                        <td class="text-center"><?php echo e(\Carbon\Carbon::parse($order['createdAt'])->format('d M Y, H:i')); ?>

                        </td>
                        <td class="text-center font-semibold"><?php echo e(number_format($order['total'])); ?> د.ع</td>
                        <td class="text-center">
                            <span class="status-tag completed">معتمد</span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">لا توجد طلبات معتمدة</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination-wrapper">
            <div class="pagination-controls justify-center">
                <!-- Previous Button -->
                <button wire:click="previousPage" <?php if($currentPage == 1): ?> disabled <?php endif; ?>>
                    &laquo;
                </button>

                <!-- Numbered Pages -->
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <button wire:click="goToPage(<?php echo e($i); ?>)"
                        class="<?php if($currentPage == $i): ?> active <?php endif; ?>">
                        <?php echo e($i); ?>

                    </button>
                <?php endfor; ?>

                <!-- Next Button -->
                <button wire:click="nextPage" <?php if($currentPage == $totalPages): ?> disabled <?php endif; ?>>
                    &raquo;
                </button>
            </div>
        </div>






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

        .btn-delivered {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            /* Blue gradient */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-delivered:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-delivered:active {
            transform: translateY(1px);
        }

        .btn-delivered svg {
            fill: white;
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

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .pagination-controls button {
            padding: 0.4rem 0.8rem;
            border: 1px solid var(--gray-light);
            border-radius: 6px;
            background-color: white;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-controls button.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .pagination-controls button:hover:not(:disabled) {
            background-color: var(--light);
        }

        .pagination-controls button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\getAPI\approved.blade.php ENDPATH**/ ?>
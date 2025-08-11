<div><div class="order-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1 class="dashboard-title">Pending Orders</h1>
            <div class="action-controls">
                <select class="action-select" wire:model="bulkAction">
                    <option value="">Bulk Actions</option>
                    <option value="accept">Accept Selected</option>
                    <option value="reject">Reject Selected</option>
                </select>
                <button class="apply-btn" wire:click="applyBulkAction">Apply</button>
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($loading): ?>
            <div class="loading-state">
                <div class="loading-spinner"></div>
                <span>Loading orders...</span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Message Section -->
    <!--[if BLOCK]><![endif]--><?php if($responseMessage): ?>
        <div class="response-message">
            <?php echo e($responseMessage); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Orders Table -->
    <div class="table-wrapper">
        <!--[if BLOCK]><![endif]--><?php if(!empty($orders)): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">
                            <input type="checkbox" wire:model="selectAll">
                        </th>
                        <th class="text-center">Order ID</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Total (IQD)</th>
                    </tr>
                </thead>
                <tbody>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" wire:model="selectedOrders" value="<?php echo e($order['id']); ?>">
                            </td>
                            <td class="font-medium text-center"><?php echo e($order['id']); ?></td>
                            <td class="text-center">
                                <span class="status-tag <?php echo e(strtolower($order['status'])); ?>">
                                    <?php echo e($order['status']); ?>

                                </span>
                            </td>
                            <td class="text-center"><?php echo e(\Carbon\Carbon::parse($order['createdAt'])->format('d M Y, H:i')); ?></td>
                            <td class="text-center"><?php echo e($order['user']['name'] ?? 'N/A'); ?></td>
                            <td class="text-center"><?php echo e($order['phoneNumber'] ?? 'N/A'); ?></td>
                            <td class="text-center"><?php echo e($order['address']['location'] ?? 'N/A'); ?></td>
                            <td class="text-center font-semibold"><?php echo e(number_format($order['total'])); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3>No orders</h3>
                <p>There are currently no pending orders to display.</p>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Footer Actions -->
    <!--[if BLOCK]><![endif]--><?php if(!empty($orders)): ?>
        <div class="footer-actions">
            <button class="action-btn accept-btn" wire:click="acceptSelected">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Accept Selected
            </button>
            <button class="action-btn reject-btn" wire:click="rejectSelected">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Reject Selected
            </button>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Pagination -->
  <?php if(!empty($orders) && $totalOrders > $perPage): ?>
    <div class="pagination-wrapper">
        <div class="mobile-pagination">
            <button 
                wire:click="previousPage" 
                <?php if($currentPage <= 1): ?> disabled <?php endif; ?>
                wire:loading.attr="disabled"
                wire:target="previousPage, nextPage, gotoPage"
            >
                <span wire:loading.remove wire:target="previousPage">Previous</span>
                <span wire:loading wire:target="previousPage" class="spinner"></span>
            </button>

            <button 
                wire:click="nextPage" 
                <?php if($currentPage >= $totalPages): ?> disabled <?php endif; ?>
                wire:loading.attr="disabled"
                wire:target="previousPage, nextPage, gotoPage"
            >
                <span wire:loading.remove wire:target="nextPage">Next</span>
                <span wire:loading wire:target="nextPage" class="spinner"></span>
            </button>
        </div>

        <div class="desktop-pagination">
            <div class="pagination-info">
                Showing <span><?php echo e((($currentPage - 1) * $perPage) + 1); ?></span> 
                to <span><?php echo e(min($currentPage * $perPage, $totalOrders)); ?></span> 
                of <span><?php echo e($totalOrders); ?></span> orders
            </div>

            <nav class="pagination-controls">
                <button 
                    wire:click="previousPage" 
                    <?php if($currentPage <= 1): ?> disabled <?php endif; ?> 
                    class="pagination-arrow"
                    wire:loading.attr="disabled"
                    wire:target="previousPage, nextPage, gotoPage"
                >
                    <span wire:loading.remove wire:target="previousPage">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="previousPage" class="spinner"></span>
                </button>

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = range(1, $totalPages); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button 
                        wire:click="gotoPage(<?php echo e($i); ?>)" 
                        class="<?php echo e($i == $currentPage ? 'active' : ''); ?>"
                        wire:loading.attr="disabled"
                        wire:target="previousPage, nextPage, gotoPage"
                    >
                        <span wire:loading.remove wire:target="gotoPage(<?php echo e($i); ?>)"><?php echo e($i); ?></span>
                        <span wire:loading wire:target="gotoPage(<?php echo e($i); ?>)" class="spinner"></span>
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                <button 
                    wire:click="nextPage" 
                    <?php if($currentPage >= $totalPages): ?> disabled <?php endif; ?> 
                    class="pagination-arrow"
                    wire:loading.attr="disabled"
                    wire:target="previousPage, nextPage, gotoPage"
                >
                    <span wire:loading.remove wire:target="nextPage">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="nextPage" class="spinner"></span>
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
    margin: 2rem auto;
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
    justify-content: space-between;
}
.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(0, 0, 0, 0.2);
  border-top-color: rgba(0, 0, 0, 0.7);
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
  vertical-align: middle;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}


.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.action-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.action-select {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background-color: #5662cc;
    color: white;
    font-size: 0.875rem;
    min-width: 180px;
        border-color: white;

}

.action-select:focus {
    outline: none;
    border-color: white;
    
}


.apply-btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    background-color: white;
    color: var(--primary-dark);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.apply-btn:hover {
    background-color: rgba(255, 255, 255, 0.9);
}

.dashboard-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0;
}

.loading-state {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
    font-weight: 500;
}

.loading-spinner {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.response-message {
    padding: 0.75rem 2rem;
    background-color: rgba(99, 102, 241, 0.1);
    color: var(--primary-dark);
    font-size: 0.875rem;
    border-bottom: 1px solid var(--gray-light);
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
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary-dark);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background-color: var(--light);
    border-bottom: 1px solid var(--gray-light);
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

input[type="checkbox"] {
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid var(--gray-light);
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    position: relative;
}

input[type="checkbox"]:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

input[type="checkbox"]:checked::after {
    content: "✓";
    position: absolute;
    color: white;
    font-size: 0.75rem;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.status-tag {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-tag.pending {
    background-color: rgba(251, 191, 36, 0.1);
    color: var(--warning);
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

.footer-actions {
    display: flex;
    gap: 1rem;
    padding: 1rem 2rem;
    background-color: var(--light);
    border-top: 1px solid var(--gray-light);
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.action-btn svg {
    width: 1.25rem;
    height: 1.25rem;
}

.accept-btn {
    background-color: var(--success);
    color: white;
}

.accept-btn:hover {
    background-color: #0da271;
}

.reject-btn {
    background-color: var(--secondary);
    color: white;
}

.reject-btn:hover {
    background-color: #e11d48;
}

.pagination-wrapper {
    padding: 1rem 2rem;
    border-top: 1px solid var(--gray-light);
}

.mobile-pagination {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.mobile-pagination button {
    padding: 0.5rem 1rem;
    border: 1px solid var(--gray-light);
    border-radius: 6px;
    background-color: white;
    color: var(--dark);
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}

.mobile-pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.mobile-pagination button:hover:not(:disabled) {
    background-color: var(--light);
    border-color: var(--gray);
}

.desktop-pagination {
    display: none;
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

@media (min-width: 640px) {
    .mobile-pagination {
        display: none;
    }
    
    .desktop-pagination {
        display: flex;
    }
    
    .orders-table th, 
    .orders-table td {
        padding: 1.25rem 1.5rem;
    }
}
</style>
</div><?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/getAPI/show.blade.php ENDPATH**/ ?>
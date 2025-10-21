<div>
    <div>
        <div class="order-dashboard">
            <div class="dashboard-header d-flex ">
                <div class="row g-6">



                    <!-- Driver Selection -->
                    <div class="col-md-4 mb-3">
                        <label for="nameDriver" class="dashboard-title">اسم السائق</label>
                        <div class="input-group">
                            <select id="nameDriver" wire:model.live="selected_driver" class="form-control" style="width: 1150px">
                                <option value="">اختر السائق</option>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->nameDriver); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Second: Date picker -->
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




            <!-- Orders Table -->
            <div class="table-wrapper">
                <?php if(!empty($orders)): ?>
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                               
                                <th class="text-center">يختار</th>
                                <th class="text-center">رقم التليفون</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">طريقة الدفع</th>
                                <th class="text-center">تاريخ الشراء</th>
                                <th class="text-center">السعر الإجمالي</th>
                                <th class="text-center">الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" wire:model="selectedOrders"
                                            wire:click="check('<?php echo e($order['id']); ?>')" value="<?php echo e($order['id']); ?>">

                                    </td>

                                    <td class="text-center"><?php echo e($order['phoneNumber'] ?? 'N/A'); ?></td>
                                    <td class="text-center"><?php echo e($order['address']['location'] ?? 'N/A'); ?></td>
                                    <td class="font-medium text-center"><?php echo e($order['paymentMethod']); ?></td>
                                    <td class="text-center">
                                        <?php echo e(\Carbon\Carbon::parse($order['createdAt'])->format('d M Y, H:i')); ?></td>
                                    <td class="text-center font-semibold"><?php echo e(number_format($order['total'])); ?></td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button wire:click="view('<?php echo e($order['id']); ?>')"
                                                class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                href="#exampleModalToggle" role="button">
                                                View
                                            </button>

                                            <button wire:click="cancel('<?php echo e($order['id']); ?>')"
                                                class="btn btn-outline-danger btn-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </td>




                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <p>لا توجد حاليًا أي طلبات معلقة لعرضها.</p>
                    </div>
                <?php endif; ?>
            </div>


            <!-- Modal -->
            <div wire:ignore.self class="modal fade" id="exampleModalToggle" tabindex="-1"
                aria-labelledby="exampleModalToggleLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Order Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Normal Products Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Product Code</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $modalProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($product['productCode']); ?></td>
                                            <td class="text-center"><?php echo e($product['quantity']); ?></td>
                                            <td class="text-center"><?php echo e(number_format($product['price'])); ?></td>
                                            <td class="text-center"><?php echo e(number_format($product['total_price'])); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                            <!-- Product Packages Table -->
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center">Package Code</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $modalPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($package['packageCode']); ?></td>
                                            <td class="text-center"><?php echo e($package['quantity']); ?></td>
                                            <td class="text-center"><?php echo e(number_format($package['price'])); ?></td>
                                            <td class="text-center"><?php echo e(number_format($package['total_price'])); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>




            <!-- Footer Actions -->
            <?php if(!empty($orders)): ?>
                <div class="footer-actions">
                    <button class="action-btn accept-btn" wire:click="acceptSelected">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Accept Selected
                    </button>
                   
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <?php if(!empty($orders) && $totalOrders > $perPage): ?>
                <div class="pagination-wrapper">
                    <div class="mobile-pagination">
                        <button wire:click="previousPage" <?php if($currentPage <= 1): ?> disabled <?php endif; ?>
                            wire:loading.attr="disabled" wire:target="previousPage, nextPage, gotoPage">
                            <span wire:loading.remove wire:target="previousPage">Previous</span>
                            <span wire:loading wire:target="previousPage" class="spinner"></span>
                        </button>

                        <button wire:click="nextPage" <?php if($currentPage >= $totalPages): ?> disabled <?php endif; ?>
                            wire:loading.attr="disabled" wire:target="previousPage, nextPage, gotoPage">
                            <span wire:loading.remove wire:target="nextPage">Next</span>
                            <span wire:loading wire:target="nextPage" class="spinner"></span>
                        </button>
                    </div>

                    <div class="desktop-pagination">
                        <div class="pagination-info">
                            Showing <span><?php echo e(($currentPage - 1) * $perPage + 1); ?></span>
                            to <span><?php echo e(min($currentPage * $perPage, $totalOrders)); ?></span>
                            of <span><?php echo e($totalOrders); ?></span> orders
                        </div>

                        <nav class="pagination-controls">
                            <button wire:click="previousPage" <?php if($currentPage <= 1): ?> disabled <?php endif; ?>
                                class="pagination-arrow" wire:loading.attr="disabled"
                                wire:target="previousPage, nextPage, gotoPage">
                                <span wire:loading.remove wire:target="previousPage">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="previousPage" class="spinner"></span>
                            </button>

                            <?php $__currentLoopData = range(1, $totalPages); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button wire:click="gotoPage(<?php echo e($i); ?>)"
                                    class="<?php echo e($i == $currentPage ? 'active' : ''); ?>" wire:loading.attr="disabled"
                                    wire:target="previousPage, nextPage, gotoPage">
                                    <span wire:loading.remove
                                        wire:target="gotoPage(<?php echo e($i); ?>)"><?php echo e($i); ?></span>
                                    <span wire:loading wire:target="gotoPage(<?php echo e($i); ?>)"
                                        class="spinner"></span>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <button wire:click="nextPage" <?php if($currentPage >= $totalPages): ?> disabled <?php endif; ?>
                                class="pagination-arrow" wire:loading.attr="disabled"
                                wire:target="previousPage, nextPage, gotoPage">
                                <span wire:loading.remove wire:target="nextPage">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="nextPage" class="spinner"></span>
                            </button>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>

        </div>

      
    </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\livewire\getAPI\show.blade.php ENDPATH**/ ?>
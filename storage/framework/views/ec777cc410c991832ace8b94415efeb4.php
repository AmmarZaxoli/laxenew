<div>
    <div class="card body formtype">
        <!-- Simple Header -->
        <div class="container-fluid py-4">
            <div class="page-header">
                <h4 class="text-dark mb-2">
                    <i class="bi bi-qr-code-scan text-primary me-2"></i> مسح الفواتير
                </h4>

            </div>

            <div class="row g-3">
                <!-- Left Panel -->
                <div class="col-md-4">
                    <!-- Driver Selection Card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-person-badge me-2 text-primary"></i>اختيار السائق
                            </h6>

                            <div class="mb-3">
                                <label class="form-label small text-muted">حدد السائق </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-people"></i>
                                    </span>
                                    <select wire:model.live="selectedDriverId" class="form-select">
                                        <option value="">-- اختر السائق --</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($driver->id); ?>">
                                                <?php echo e($driver->nameDriver); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="searchInput" class="form-label">الباركود</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="أدخل باركود المنتج" wire:model.defer="barcodeInput"
                                        wire:keydown.enter.prevent="addBarcodeFromInput" autocomplete="off">

                                </div>
                            </div>
                            <!-- Scanner Button -->
                            <button type="button" class="btn btn-primary w-100 mb-3" onclick="startScanner()"
                                <?php echo e($selectedDriverId ? '' : 'disabled'); ?>>
                                <i class="bi bi-camera me-2"></i>ماسح ضوئي مفتوح للكاميرا
                            </button>

                            <!-- Scanner Box -->
                            <div id="scannerBox" class="card mt-2" style="display:none" wire:ignore>
                                <div class="card-body p-0">
                                    <div id="reader"></div>
                                </div>
                                <div class="card-footer p-2 text-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="stopScanner()">
                                        <i class="bi bi-x-circle me-1"></i>Close Camera
                                    </button>
                                </div>
                            </div>

                            <!-- Stats Overview -->
                            <!--[if BLOCK]><![endif]--><?php if($selectedDriverId): ?>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">
                                            <i class="bi bi-graph-up me-2"></i>إحصائيات سريعة
                                        </h6>
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="h5 fw-bold"><?php echo e(count($driverInvoices)); ?></div>
                                                <small class="text-muted">المجموع</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h5 fw-bold text-success"><?php echo e(count($scannedInvoices)); ?></div>
                                                <small class="text-muted">تم مسحه ضوئيًا</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h5 fw-bold text-warning">
                                                    <?php echo e(count($driverInvoices) - count($scannedInvoices)); ?>

                                                </div>
                                                <small class="text-muted">قيد الانتظار</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-md-8">
                    <!-- Two Tables Side by Side -->
                    <div class="row g-3">
                        <!-- Available Invoices -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="bi bi-file-earmark-text me-2"></i>الفواتير المتاحة
                                    </h6>
                                    <span class="badge bg-secondary"><?php echo e(count($driverInvoices)); ?></span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 400px;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="bg-white">
                                                <tr>
                                                    <th class="border-0">الفواتير #</th>
                                                    <th class="border-0">رقم الهاتف</th>
                                                    <th class="border-0 text-end">مبلغ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $driverInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr class="<?php echo e(in_array($invoice['num_invoice_sell'], $barcodes) ? 'table-success' : ''); ?>"
                                                        style="cursor: pointer;"
                                                        wire:click="addBarcode('<?php echo e($invoice['num_invoice_sell']); ?>')">
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge bg-light text-dark me-2">
                                                                    <?php echo e(substr($invoice['num_invoice_sell'], -6)); ?>

                                                                </span>
                                                                <!--[if BLOCK]><![endif]--><?php if(in_array($invoice['num_invoice_sell'], $barcodes)): ?>
                                                                    <i
                                                                        class="bi bi-check-circle-fill text-success small"></i>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <small><?php echo e($invoice['mobile']); ?></small>
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            <?php echo e(number_format($invoice['total_price_afterDiscount_invoice'])); ?>


                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center py-4 text-muted">
                                                            <!--[if BLOCK]><![endif]--><?php if($selectedDriverId): ?>
                                                                لم يتم العثور على أي فواتير
                                                            <?php else: ?>
                                                                اختر سائقًا لعرض الفواتير
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </td>
                                                    </tr>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(count($driverInvoices) > 0): ?>
                                    <div class="card-footer bg-white p-2">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            انقر على الفاتورة لمسحها ضوئيًا يدويًا
                                        </small>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Scanned Invoices -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-success">
                                        <i class="bi bi-check-circle me-2"></i>الفواتير الممسوحة ضوئياً
                                    </h6>
                                    <span class="badge bg-success"><?php echo e(count($scannedInvoices)); ?></span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 400px;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="bg-white">
                                                <tr>
                                                    <th class="border-0">الفواتير #</th>
                                                    <th class="border-0">رقم الهاتف</th>
                                                    <th class="border-0 text-end">مبلغ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $scannedInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr style="cursor: pointer;"
                                                        wire:click="removeBarcode(<?php echo e(array_search($invoice['num_invoice_sell'], array_column($scannedInvoices, 'num_invoice_sell'))); ?>)">
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge bg-success text-white me-2">
                                                                    <?php echo e(substr($invoice['num_invoice_sell'], -6)); ?>

                                                                </span>
                                                                <i
                                                                    class="bi bi-check-circle-fill text-success small"></i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <small><?php echo e($invoice['mobile']); ?></small>
                                                        </td>
                                                        <td class="text-end fw-bold text-success">
                                                            <?php echo e(number_format($invoice['total_price_afterDiscount_invoice'])); ?>


                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center py-4 text-muted">

                                                            امسح الفواتير ضوئيًا لتظهر هنا
                                                        </td>
                                                    </tr>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(count($scannedInvoices) > 0): ?>
                                    <div class="card-footer bg-white p-2">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            انقر على الفاتورة لإزالتها من قائمة الفواتير الممسوحة ضوئيًا
                                        </small>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>


                </div>
                <!-- Progress Bar -->
                <!--[if BLOCK]><![endif]--><?php if($selectedDriverId && count($driverInvoices) > 0): ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">
                                    <i class="bi bi-speedometer2 me-2"></i>تقدم عملية التجميع
                                </h6>
                                <span class="fw-bold">
                                    <?php echo e(round((count($scannedInvoices) / count($driverInvoices)) * 100)); ?>%
                                </span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: <?php echo e((count($scannedInvoices) / max(count($driverInvoices), 1)) * 100); ?>%">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 small text-muted">
                                <span>قيد الانتظار: <?php echo e(count($driverInvoices) - count($scannedInvoices)); ?></span>
                                <span>المبلغ الإجمالي:
                                    <?php echo e(number_format(array_sum(array_column($scannedInvoices, 'total_price_afterDiscount_invoice')))); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Action Buttons -->
            <!--[if BLOCK]><![endif]--><?php if(count($scannedInvoices) > 0): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">

                                <button class="btn btn-outline-secondary" wire:click="$set('scannedInvoices', [])">
                                    <i class="bi bi-arrow-clockwise me-2"></i>إعادة ضبط المسح
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode = null;
        let audioCtx = null;
        let lastCode = null;
        let lastScanTime = 0;
        const COOLDOWN = 2500;

        function playBeep() {
            if (!audioCtx) audioCtx = new(window.AudioContext || window.webkitAudioContext)();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'square';
            osc.frequency.setValueAtTime(800, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.1);
        }

        function startScanner() {
            document.getElementById('scannerBox').style.display = 'block';
            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 15,
                    qrbox: {
                        width: 250,
                        height: 140
                    },
                    aspectRatio: 1.777778
                },
                (decodedText) => {
                    const now = Date.now();
                    if (decodedText === lastCode && (now - lastScanTime) < COOLDOWN) {
                        return;
                    }
                    lastCode = decodedText;
                    lastScanTime = now;

                    // Visual feedback
                    document.getElementById('reader').style.border = '3px solid #28a745';
                    setTimeout(() => {
                        document.getElementById('reader').style.border = 'none';
                    }, 300);

                    playBeep();
                    if (navigator.vibrate) navigator.vibrate([100, 50, 100]);

                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('addBarcode', decodedText);
                }
            ).catch(err => {
                console.error('Camera error:', err);
                alert('Unable to access camera. Please ensure camera permissions are granted.');
            });
        }

        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    document.getElementById('scannerBox').style.display = 'none';
                    lastCode = null;
                });
            }
        }

        // Auto-focus on driver select
        document.addEventListener('livewire:initialized', () => {
            window.Livewire.find('<?php echo e($_instance->getId()); ?>').on('driver-selected', () => {
                document.querySelector('select[wire\\:model\\.live="selectedDriverId"]').focus();
            });
        });
    </script>

    <style>
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .card-header {
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .table-sm td,
        .table-sm th {
            padding: 0.5rem;
        }

        #reader {
            width: 100%;
            min-height: 250px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .progress {
            background-color: #e9ecef;
        }

        .badge {
            font-size: 0.75em;
            padding: 0.25em 0.5em;
        }

        .btn:disabled {
            opacity: 0.5;
        }

        .border-success {
            border-color: #198754 !important;
        }
    </style>
</div>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/livewire/barcode/barcode-scanner.blade.php ENDPATH**/ ?>
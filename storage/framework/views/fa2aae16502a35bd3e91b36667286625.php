<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>A6 Invoice Top-Center on A4</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            color: #813434;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            direction: rtl;
            background: white;
        }

        /* Responsive wrapper to allow horizontal scroll on small screens */
        .invoices-wrapper {
            padding: 10px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background: #f5f5f5;
            min-height: 100vh; /* fill full viewport height */
            box-sizing: border-box;
        }

        /* A6 invoice box */
        .invoice-container {
            width: 105mm;
            height: 148mm;
            margin: 0 auto 20px auto; /* center horizontally, margin below */
            border: 1px solid #000;
            box-sizing: border-box;
            overflow-x: hidden; /* prevent horizontal overflow inside invoice */
            background: white;
        }

        /* Inner padding & layout */
        .invoice-inner {
            padding: 35mm 11mm 5mm 5mm; /* top right bottom left */
            height: calc(100% - 15mm);
            box-sizing: border-box;
        }

        .driver-info {
            margin-bottom: 8mm;
            margin-right: 5mm;
        }

        .info-line {
            margin-bottom: 1.7mm;
        }

        /* Beautiful product table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            color: #4a2b2b; /* dark shade of #813434 for text */
            background-color: #fff8f7; /* very light warm background */
            box-shadow: 0 2px 6px rgba(129, 52, 52, 0.15);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 5mm;
        }

        .product-table th,
        .product-table td {
            padding: 8px 12px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid #d9b7b7;
        }

        .product-table thead th {
            background-color: #813434;
            color: #813434;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 3px solid #562a2a;
        }

        .product-table tbody tr:hover {
            background-color: #f5e4e4;
            cursor: default;
        }

        .product-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Rounded corners on thead */
        .product-table thead tr th:first-child {
            border-top-right-radius: 8px;
        }
        .product-table thead tr th:last-child {
            border-top-left-radius: 8px;
        }

        /* Zebra striping */
        .product-table tbody tr:nth-child(even) {
            background-color: #fff0ef;
        }

        /* Totals stacked vertically to prevent overflow */
        .totals {
            display: flex;
            flex-direction: column;
            gap: 3mm;
            padding-left: 2mm; /* matches table padding */
        }

        .total-line {
            white-space: nowrap;
            font-size: 12px;
            color: #4a2b2b;
        }

        .grand-total {
            font-weight: bold;
        }

        /* Page break for printing */
        .page-break {
            page-break-after: always;
        }

        /* Optional: Adjust font size slightly on very small screens */
        @media (max-width: 320px) {
            body {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="invoices-wrapper">
        <?php $__currentLoopData = $data['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="invoice-container">
                <div class="invoice-inner">
                    <!-- Driver Info -->
                    <div class="driver-info">
                        <div class="info-line"><strong>:</strong> <?php echo e($data['driver_name']); ?></div>
                        <div class="info-line"><strong>:</strong> <?php echo e($invoice['address']); ?></div>
                        <div class="info-line"><strong>:</strong> <?php echo e($invoice['mobile']); ?></div>
                    </div>

                    <!-- Products Table -->
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>الكود</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoice['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i + 1); ?></td>
                                    <td><?php echo e($product['name']); ?></td>
                                    <td><?php echo e($product['code'] ?? '—'); ?></td>
                                    <td><?php echo e($product['qty']); ?></td>
                                    <td><?php echo e(number_format($product['price'])); ?></td>
                                    <td><?php echo e(number_format($product['total'])); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <!-- Totals -->
                    <div class="totals">
                        <div class="total-line">المجموع: <?php echo e(number_format($invoice['total'])); ?> د.ع</div>
                        <div class="total-line">التوصيل: <?php echo e(number_format($invoice['taxi_price'])); ?> د.ع</div>
                        <div class="total-line grand-total">الإجمالي: <?php echo e(number_format($invoice['grand_total'])); ?> د.ع</div>
                    </div>
                </div>
            </div>

            <?php if(!$loop->last): ?>
                <div class="page-break"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views\print\invoices.blade.php ENDPATH**/ ?>
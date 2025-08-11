<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>A6 Invoice Print</title>
    <style>
       @page { size: A4 portrait; margin: 0; }


        body {
            color: #813434;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            direction: rtl;
            background: white;
        }

        .invoices-wrapper {
            padding: 10px;
            background: #f5f5f5;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .invoice-container {
            width: 105mm;
            height: 148mm;
            margin: 0 auto 20px auto;
            background: white;
            page-break-inside: avoid;
        }

        .invoice-inner {
            padding: 35mm 11mm 5mm 5mm;
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

        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            color: #4a2b2b;
            background-color: #fff8f7;
            box-shadow: 0 2px 6px rgba(129, 52, 52, 0.15);
            margin-bottom: 5mm;
        }

        .product-table th,
        .product-table td {
            padding: 4px 6px;
            text-align: center;
            border-bottom: 1px solid #d9b7b7;
        }

        .product-table thead th {
            background-color: #f3dcdc;
            font-weight: bold;
        }

        .product-table tbody tr:nth-child(even) {
            background-color: #fff0ef;
        }

        .totals {
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }

        .total-line {
            white-space: nowrap;
            font-size: 12px;
            color: #4a2b2b;
        }

        .grand-total {
            font-weight: bold;
        }

        @media print {
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="invoices-wrapper">
        <?php $__currentLoopData = $data['invoices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="invoice-container">
                <div class="invoice-inner">
                    <?php if($invoice['show_header']): ?>
                        <div class="driver-info">
                            <div class="info-line"><strong>السائق:</strong> <?php echo e($data['driver_name']); ?></div>
                            <div class="info-line"><strong>العنوان:</strong> <?php echo e($invoice['address']); ?></div>
                            <div class="info-line"><strong>الموبايل:</strong> <?php echo e($invoice['mobile']); ?></div>
                        </div>
                    <?php endif; ?>

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

                 <?php if(!empty($invoice['show_footer'])): ?>
    <div class="totals">
        <div class="total-line">المجموع: <?php echo e(number_format($invoice['total'])); ?> د.ع</div>
        <div class="total-line">التوصيل: <?php echo e(number_format($invoice['taxi_price'])); ?> د.ع</div>
        <div class="total-line grand-total">الإجمالي: <?php echo e(number_format($invoice['grand_total'])); ?> د.ع</div>
    </div>
<?php endif; ?>

                </div>
            </div>

            <?php if(!$loop->last): ?>
                <div class="page-break"></div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>

</html>
<?php /**PATH C:\Users\PC\Desktop\laxe8-10\resources\views/print/invoices.blade.php ENDPATH**/ ?>